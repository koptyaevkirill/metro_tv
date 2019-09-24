<?php

namespace console\controllers;

use yii\console\Controller;
use Yii;
use common\models\Device;
use common\models\DeviceDetails;
use common\components\ExportDataExcel;
use yii\helpers\FileHelper;

use moonland\phpexcel\Excel;
use common\components\module\APIClient;
use yii\helpers\ArrayHelper;
use common\components\helpers\SegmentHelper;
use common\models\Segment;

/**
 * Console operation with data
 *
 */
class DataController extends Controller
{
    
    /**
     * Delete data older than specified time
     */
    public function actionDelete()
    {
        $time = strtotime("-3 month");
        $command = Yii::$app->db->createCommand('DELETE FROM `tv_data` WHERE `created_at` < :created_at');
        $command->bindValue(':created_at', $time);
        $command->execute();
    }
    
    /**
     * Creating the next day for each device
     */
    public function actionFixData()
    {
        $time = date('d-m-Y', strtotime("next day"));
        $devices = Device::find()->all();
        $model = Yii::createObject(['class' => DeviceDetails::className()]);
        foreach ($devices as $device) {
            $model->isNewRecord = true;
            $model->id = null;
            $model->device_name = $device->name;
            $model->day = $time;
            $model->save();
        }
    }
    
    /**
     * 
     */
    public function actionBindWithVideo()
    {
        $start = microtime(true);
        $command = Yii::$app->db->createCommand("SELECT id, start, finish FROM `tv_playlist` WHERE `sync` = :sync ORDER BY `id` DESC");
        $command->bindValue(':sync', 0);
        $playlist = $command->queryAll();
        foreach($playlist as $key => $item) {
            $command = Yii::$app->db->createCommand("UPDATE `tv_data` SET `video_id` = :video_id WHERE `visit_time` >= :from AND `visit_time` <= :to");
            $command->bindValue(':video_id', (int) $item['id']);
            $command->bindValue(':from', (int) $item['start']);
            $command->bindValue(':to', (int) $item['finish']);
            $count = $command->execute();
            echo $count.' --- '.$item['id']."\n";
            Yii::$app->db->createCommand("UPDATE `tv_playlist` SET `sync` = 1 WHERE `id` = :id")->bindValue(':id', $item['id'])->execute();
        }
        $time = microtime(true) - $start;
        $this->stdout($time);
    }
    
    /**
     * 
     */
    public function actionCreateDataSegment()
    {
        $command = Yii::$app->db->createCommand("SELECT * FROM `tv_segment` WHERE `status` = :status");
        $command->bindValue(':status', 0);
        $model = $command->queryOne();
        if($model) {
            $sql = '';
            $sql_device = '';
            $sql_date = "`start` >= ".$model['valid_from']." AND `finish` <= ".$model['valid_to'];
            if($model['videos']) {
                $sql = 'AND (';
                $videos = explode(";", $model['videos']);
                foreach($videos as $video_title) {
                    $sql .= " video_title_en = '$video_title'";
                    if($video_title != end($videos)) { $sql .= ' OR '; }
                }
                $sql .= ')';
            }
            if($model['device_ids']) {
                $sql_device = 'AND (';
                $device_ids = explode(";", $model['device_ids']);
                foreach($device_ids as $device_id) {
                    $sql_device .= " `tv_data`.device_name = '$device_id'";
                    if($device_id != end($device_ids)) { $sql_device .= ' OR '; }
                }
                $sql_device .= ')';
            }
            if( $model['valid_end_enabled'] ) {
                $days = round(($model['valid_to'] - $model['valid_from']) / (60 * 60 * 24));
                $start_time = strtotime(date('d-m-Y '.$model['valid_end_from'].':00:00', $model['valid_from']));
                $end_time = strtotime(date('d-m-Y '.$model['valid_end_to'].':00:00', $model['valid_from']));
                $sql_date = '(';
                for($i = 0; $i < $days; $i++) {
                    $sql_date .= "(`start` >= ".$start_time." AND `finish` <= ".$end_time.")";
                    if($i + 1 != $days) { $sql_date .= ' OR '; }
                    $start_time = strtotime("+1 day", $start_time);
                    $end_time = strtotime("+1 day", $end_time);
                }
                $sql_date .= ')';
            }
            $command = Yii::$app->db->createCommand("SELECT `MAC`, COUNT(`tv_data`.`MAC`) as count FROM `tv_playlist` LEFT JOIN `tv_data` ON `tv_data`.`video_id` = `tv_playlist`.`id` WHERE $sql_date $sql $sql_device GROUP BY `tv_data`.`MAC` HAVING COUNT(`tv_data`.`MAC`) >= :count");
            // $command = Yii::$app->db->createCommand("SELECT `MAC`, id FROM `tv_data` limit 518586");
            // $command->bindValue(':from', $model['valid_from']);
            // $command->bindValue(':to', $model['valid_to']);
            $command->bindValue(':count', $model['count_contact']);
            $data = $command->queryAll();
            $count = 0;
            $dir = Yii::getAlias('@common')."/data/segments";
            if (!file_exists($dir)) { FileHelper::createDirectory($dir); }
            $exporter = new ExportDataExcel('file', $dir.'/'.$model['title'].'.xls');
            $exporter->initialize();

            $fp = fopen($dir.'/'.$model['title'].".txt", "w");
            
            foreach($data as $key => $item) {
                if($item['count'] <= $model['count_contact_to']) {
                    $exporter->addRow($item);
                    echo $key."\n";
                    $count++;
                    fwrite($fp, str_replace(":", "", $item['MAC']).PHP_EOL);
                }
                unset($data[$key]);
            }

            fclose($fp);

            $exporter->finalize();
            $command = Yii::$app->db->createCommand("UPDATE `tv_segment` SET `status` = :status, `count_row` = :count_row WHERE `id` = :id");
            $command->bindValue(':id', $model['id']);
            $command->bindValue(':status', 1);
            $command->bindValue(':count_row', $count);
            $command->execute();
        }
    }
    
    protected function exportData($data, $filename) {
        $doc = new \PHPExcel();
        $doc->setActiveSheetIndex(0);
        $doc->getActiveSheet()->fromArray($data);
        $objWriter = \PHPExcel_IOFactory::createWriter($doc, "Excel5");
        $objWriter->save($filename);
    }

    public function actionSendYandex(int $id)
    {
        $model = Segment::findOne($id);
        $dir = Yii::getAlias('@common')."/data/segments";
        $filename = $model->title.".xls";
        if (file_exists($dir.'/'.$filename)) {
            if(!file_exists($dir.'/'.$model->title.".txt")) {
                $xml = simplexml_load_file($dir.'/'.$filename);
                $rows = $xml->Worksheet->Table->Row;
                $fp = fopen($dir.'/'.$model->title.".txt", "w");
                foreach($rows as $row) {
                    $text = str_replace(":", "", $row->Cell->Data).PHP_EOL;
                    fwrite($fp, $text);
                }
                fclose($fp);
            }
            $client = Yii::createObject(['class' => APIClient::class], [APIClient::YANDEX_TOKEN, APIClient::API_YANDEX_URL]);
            $filesend_response = $client->sendSegmentFile($model->title, $dir.'/'.$model->title.".txt");
            $segment = $client->segmentConfirm(ArrayHelper::getValue($filesend_response, 'segment.id'), $model->title);
            $model->setAttribute('platform_id', ArrayHelper::getValue($segment, 'segment.id'));
            $model->save();
        }
    }

    public function actionSendMail(int $id)
    {
        $model = Segment::findOne($id);
        $dir = Yii::getAlias('@common')."/data/segments";
        $filename = $model->title.".xls";
        if (file_exists($dir.'/'.$filename)) {
            if(!file_exists($dir.'/'.$model->title.".txt")) {
                $xml = simplexml_load_file($dir.'/'.$filename);
                $rows = $xml->Worksheet->Table->Row;
                $fp = fopen($dir.'/'.$model->title.".txt", "w");
                foreach($rows as $row) {
                    $text = str_replace(":", "", $row->Cell->Data).PHP_EOL;
                    fwrite($fp, $text);
                }
                fclose($fp);
            }
            $token = SegmentHelper::getValidMailToken();
            $client = Yii::createObject(['class' => APIClient::class], [$token, APIClient::API_MAIL_URL]);
            $info = $client->sendUserListFile($model->title, $dir.'/'.$model->title.".txt");
            $model->setAttribute('platform_id_mail', ArrayHelper::getValue($info, 'id'));
            $model->save();
        }
    }

}

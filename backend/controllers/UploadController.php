<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\UploadPlaylistForm;
use backend\models\Playlist;
use backend\models\UploadDataForm;
use backend\models\SearchDataForm;
use yii\web\UploadedFile;
use common\components\ExportDataExcel;
use yii\helpers\ArrayHelper;

/**
 * Upload controller
 */
class UploadController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['upload-playlist', 'delete'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }
    
    public function actionUploadPlaylist()
    {
        set_time_limit(0);
		date_default_timezone_set('Europe/Minsk');
        $model = Yii::createObject(['class' => UploadPlaylistForm::className()]);
        $data = Playlist::find()->select('filename')->distinct()->all();
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstance($model, 'playlistFile');
            $model->playlistFile = $file;
            $file_date = explode('.', $file->name);
            $fp = fopen($file->tempName, 'r');
            if($fp) {
                $first_time = true;
                do {
                    if ($first_time == true) {
                        $first_time = false;
                        continue;
                    }
                    if(!empty($line[3])) {
                        $start = strtotime($file_date[0]." ".$line[5]);
                        $model->isNewRecord = true;
                        $model->id = null;
                        $model->company_name = $line[1];
                        $model->video_title_ru = $line[2];
                        $model->video_title_en = $line[3];
                        $model->filename = $file->name;
                        $model->start = $start;
                        $model->finish = $start + (strtotime($line[4])-strtotime("00:00"));
                        $model->save();
                    }
                } while( ($line = fgetcsv($fp, 1000, ";")) != FALSE);
                $this->redirect(['upload-playlist']);
                Yii::$app->getSession()->setFlash('success', Yii::t('app', '{Entity} added successfully', ['Entity' => Yii::t('app', 'Playlist')]));
            }
        }
        return $this->render('upload_playlist', [
            'model' => $model,
            'data' => $data
        ]);
    }
    
    public function actionDelete() {
        if (!is_null(Yii::$app->request->get('table')) && !is_null(Yii::$app->request->get('filename'))) {
            $command = Yii::$app->db->createCommand("DELETE FROM tv_".Yii::$app->request->get('table')." WHERE `filename` = :filename");
            $command->bindValue(':filename', Yii::$app->request->get('filename'));
            $command->execute();
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error'));
        }
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
}

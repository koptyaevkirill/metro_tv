<?php
namespace api\components\actions;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Data;
use common\models\DeviceDetails;

class CreateDataAction extends \yii\rest\CreateAction
{
    public function run()
    {
        $params = Yii::$app->request->bodyParams;
        $device_name = ArrayHelper::getValue($params, 'device_name');
        $model = Yii::createObject(['class' => Data::className()]);
        $data_exist = [];
        $count = 0;
        foreach(ArrayHelper::getValue($params, 'data', []) as $data) {
            if(!ArrayHelper::keyExists($data['MAC'], $data_exist, false)) {
                $model->isNewRecord = true;
                $model->id = null;
                $model->device_name = $device_name;
                $model->MAC = $data['MAC'];
                $model->device = $data['device'];
                $model->visit_time = (int)$data['visit_time'];
                $model->signal = (string)$data['signal'];
                $model->save();
                $data_exist[$data['MAC']] = (int)$data['visit_time'];
                $count++;
            }
        }
        $device_details = DeviceDetails::find()->where(['device_name' => $device_name])->andWhere(['day' => date('d-m-Y')])->one();
        $device_details->updateCounters(['count_data' => $count]);
    }
}

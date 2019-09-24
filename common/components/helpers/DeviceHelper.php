<?php
namespace common\components\helpers;
use yii\helpers\ArrayHelper;
use common\models\Device;;

class DeviceHelper {
    
    public static function getOptions($params = null) {
        return ArrayHelper::map(Device::find()->where($params)->asArray()->all(),'name', 'title');
    }
}

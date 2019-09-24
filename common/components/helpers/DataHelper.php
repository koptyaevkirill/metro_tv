<?php
namespace common\components\helpers;
use yii\helpers\ArrayHelper;
use backend\models\Playlist;

class DataHelper {
    
    public static function getOptions($params = null) {
        return ArrayHelper::map(Playlist::find()->select('video_title_en')->where($params)->distinct()->orderBy('video_title_en')->asArray()->all(),'video_title_en', 'video_title_en');
    }
}

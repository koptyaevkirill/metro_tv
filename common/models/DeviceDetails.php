<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * DeviceDetails model
 *
 * @property integer $id
 */
class DeviceDetails extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tv_device_details}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = [
            [['created_at', 'updated_at'], 'integer'],
            [['device_name', 'day'], 'string']
        ];
        return $rules;
    }
}

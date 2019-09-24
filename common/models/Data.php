<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tv_data".
 */

class Data extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tv_data';
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
    
    public function getDevice() {
        return $this->hasOne(Device::className(), ['name' => 'device_name']);
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        $rules = [
            [['id', 'visit_time', 'created_at', 'updated_at'], 'integer'],
            [['device_name', 'MAC','device', 'signal'], 'string', 'max' => 255],
            [['device_name', 'MAC'], 'required']
        ];
        return $rules;
    }
    
    
}

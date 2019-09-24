<?php
namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "tv_segment".
 */

class Segment extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tv_segment';
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
            [['valid_from', 'valid_to', 'title', 'count_contact', 'count_contact_to'], 'required'],
            [['id', 'platform_id', 'status', 'count_row', 'created_at', 'updated_at', 'valid_end_enabled'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['device_ids', 'videos', 'valid_end_from', 'valid_end_to'], 'default'],
            [['valid_end_enabled'], 'default', 'value'=> 0],
            [['count_contact', 'count_contact_to'], 'integer', 'min' => 1]
        ];
        return $rules;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'status' => Yii::t('app', 'Status'),
            'videos' => Yii::t('app', 'Video'),
            'device_ids' => Yii::t('app', 'Devices'),
            'count_row' => Yii::t('app', 'Count row'),
            'platform_id' => Yii::t('app', 'Platform Id'),
            'valid_from' => Yii::t('app', 'From'),
            'valid_to' => Yii::t('app', 'To'),
            'valid_end_enabled' => Yii::t('app', 'Enable interval'),
            'count_contact' => Yii::t('app', 'Accumulated contacts'),
            'count_contact_to' => Yii::t('app', 'Accumulated contacts'),
            'created_at' => Yii::t('app', 'Created At')
        ];
    }
}

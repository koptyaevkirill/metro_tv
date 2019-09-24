<?php
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\Data;
/**
 * Device model
 *
 * @property integer $id
 */
class Device extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tv_device}}';
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
            [['active', 'created_at', 'updated_at'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255, 'min' => 4],
            ['name', 'required'],
            ['name', 'unique', 'targetAttribute' => 'name', 'message' => Yii::t('app', 'This name has already been taken')]
        ];
        return $rules;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLastdata() {
        return Data::find()->where(['device_name' => $this->name])->orderBy('id DESC')->limit(1)->one();
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetails() {
        return $this->hasMany(DeviceDetails::className(), ['device_name' => 'name']);
    }
    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'name' => Yii::t('app', 'Unique name device'),
            'title' => Yii::t('app', 'Title'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At')
        ];
    }
}

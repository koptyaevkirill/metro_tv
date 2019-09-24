<?php
namespace backend\models;
use yii\base\Model;
use Yii;

class UploadDataForm extends Data {

    /**
     * @var UploadedFile
     */
    public $dataFile;

    public function rules() {
        return [
            ['dataFile', 'file', 'skipOnEmpty' => false],
        ];
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'dataFile' => Yii::t('app', 'Select {single}', ['single' => Yii::t('app', 'file')])
        ]);
    }
}

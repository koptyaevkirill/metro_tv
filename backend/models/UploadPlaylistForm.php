<?php
namespace backend\models;
use yii\base\Model;
use Yii;

class UploadPlaylistForm extends Playlist {

    /**
     * @var UploadedFile
     */
    public $playlistFile;

    public function rules() {
        return [
            ['playlistFile', 'file', 'skipOnEmpty' => false],
        ];
    }

    public function upload() {
        $this->documentFile->saveAs('/' . $this->documentFile->baseName . '.' . $this->documentFile->extension);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), [
            'playlistFile' => Yii::t('app', 'Select {single}', ['single' => Yii::t('app', 'file')])
        ]);
    }
}

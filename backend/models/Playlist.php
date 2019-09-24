<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tv_playlist".
 */

class Playlist extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tv_playlist';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'obg_link'], 'required'],
            [['id', 'updated_at', 'angleRotate'], 'integer'],
            [['filename'], 'string']
        ];
    }
}

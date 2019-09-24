<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180731_173119_addFilenameInPlaylist
 */
class m180731_173119_addFilenameInPlaylist extends Migration
{
    protected $tableName = '{{%tv_playlist}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableName, 'filename', Schema::TYPE_STRING);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableName, 'filename');
    }
}

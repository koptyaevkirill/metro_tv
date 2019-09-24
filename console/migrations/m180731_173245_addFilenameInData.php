<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180731_173245_addFilenameInData
 */
class m180731_173245_addFilenameInData extends Migration
{
    protected $tableName = '{{%tv_data}}';

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

<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181208_213901_initSegment
 */
class m181208_213901_initSegment extends Migration
{
    protected $tableCurrentName = '{{%tv_segment}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableCurrentName, [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_INTEGER . ' NOT NULL  DEFAULT 0',
            'count_row' => Schema::TYPE_INTEGER . ' NOT NULL  DEFAULT 0',
            'count_contact' => Schema::TYPE_INTEGER,
            'valid_from' => Schema::TYPE_INTEGER,
            'valid_to' => Schema::TYPE_INTEGER,
            'videos' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableCurrentName);
    }
}

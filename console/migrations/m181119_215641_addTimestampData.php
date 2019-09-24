<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181119_215641_addTimestampData
 */
class m181119_215641_addTimestampData extends Migration
{
    protected $tableCurrentName = '{{%tv_data}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'created_at', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn($this->tableCurrentName, 'updated_at', Schema::TYPE_INTEGER . ' NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'created_at');
        $this->dropColumn($this->tableCurrentName, 'updated_at');
    }
}

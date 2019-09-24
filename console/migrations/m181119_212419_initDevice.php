<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181119_212419_initDevice
 */
class m181119_212419_initDevice extends Migration
{
    protected $tableCurrentName = '{{%tv_device}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableCurrentName, [
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'active' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ]);
        $this->addPrimaryKey('pk_tvdevice_name', $this->tableCurrentName, 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk_tvdevice_name', $this->tableCurrentName);
        $this->dropTable($this->tableCurrentName);
    }
}

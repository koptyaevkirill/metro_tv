<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181209_203909_initDeviceDetails
 */
class m181209_203909_initDeviceDetails extends Migration
{
    protected $tableCurrentName = '{{%tv_device_details}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableCurrentName, [
            'id' => Schema::TYPE_PK,
            'device_name' => Schema::TYPE_STRING . ' NOT NULL',
            'day' => Schema::TYPE_STRING . ' NOT NULL',
            'count_data' => Schema::TYPE_INTEGER . ' NOT NULL  DEFAULT 0',
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

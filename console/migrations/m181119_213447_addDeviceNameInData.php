<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181119_213447_addDeviceNameInData
 */
class m181119_213447_addDeviceNameInData extends Migration
{
    protected $tableCurrentName = '{{%tv_data}}';
    protected $tableDeviceName = '{{%tv_device}}';
    
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'device_name', Schema::TYPE_STRING . ' NOT NULL');
        $this->addForeignKey('fk_tvdata_tvdevice', $this->tableCurrentName, 'device_name', $this->tableDeviceName, 'name', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {
        $this->dropForeignKey('fk_tvdata_tvdevice', $this->tableCurrentName);
        $this->dropColumn($this->tableCurrentName, 'device_name');
    }
}

<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190422_102413_addDevicesInSegment
 */
class m190422_102413_addDevicesInSegment extends Migration
{
    protected $tableCurrentName = '{{%tv_segment}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'device_ids', Schema::TYPE_TEXT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'device_ids');
    }
}

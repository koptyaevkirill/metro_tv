<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190506_131106_addValidToInSegment
 */
class m190506_131106_addValidToInSegment extends Migration
{
    protected $tableCurrentName = '{{%tv_segment}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'valid_end_from', Schema::TYPE_INTEGER);
        $this->addColumn($this->tableCurrentName, 'valid_end_to', Schema::TYPE_INTEGER);
        $this->addColumn($this->tableCurrentName, 'valid_end_enabled', Schema::TYPE_BOOLEAN);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'valid_end_from', Schema::TYPE_INTEGER);
        $this->dropColumn($this->tableCurrentName, 'valid_end_to', Schema::TYPE_INTEGER);
        $this->dropColumn($this->tableCurrentName, 'valid_end_enabled', Schema::TYPE_BOOLEAN);
    }
}

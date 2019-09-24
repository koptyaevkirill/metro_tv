<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181217_101801_addCountContactToInSegment
 */
class m181217_101801_addCountContactToInSegment extends Migration
{
    protected $tableCurrentName = '{{%tv_segment}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'count_contact_to', Schema::TYPE_INTEGER);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'count_contact_to');
    }
}

<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181217_095720_addVideoIDInData
 */
class m181217_095720_addVideoIDInData extends Migration
{
    protected $tableCurrentName = '{{%tv_data}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'video_id', Schema::TYPE_INTEGER);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'video_id');
    }
}

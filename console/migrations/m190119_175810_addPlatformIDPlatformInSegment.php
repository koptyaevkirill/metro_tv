<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190119_175810_addPlatformIDPlatformInSegment
 */
class m190119_175810_addPlatformIDPlatformInSegment extends Migration
{
    protected $tableCurrentName = '{{%tv_segment}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'platform_id', Schema::TYPE_INTEGER);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'platform_id');
    }
}

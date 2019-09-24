<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m190129_060513_addPlatformIDMailForSegment
 */
class m190129_060513_addPlatformIDMailForSegment extends Migration
{
    protected $tableCurrentName = '{{%tv_segment}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'platform_id_mail', Schema::TYPE_INTEGER);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'platform_id_mail');
    }
}

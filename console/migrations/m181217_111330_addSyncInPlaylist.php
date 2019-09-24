<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181217_111330_addSyncInPlaylist
 */
class m181217_111330_addSyncInPlaylist extends Migration
{
    protected $tableCurrentName = '{{%tv_playlist}}';
    
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn($this->tableCurrentName, 'sync', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn($this->tableCurrentName, 'sync');
    }
}

<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181119_211825_deleteFilenamData
 */
class m181119_211825_deleteFilenamData extends Migration
{
    protected $tableCurrentName = '{{%tv_data}}';
    
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->dropColumn($this->tableCurrentName, 'filename');
    }

    /**
     * @inheritdoc
     */
    public function safeDown() {}
}

<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180729_190607_initData
 */
class m180729_190607_initData extends Migration
{
    protected $tableCurrentName = '{{%tv_data}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableCurrentName, [
            'id' => Schema::TYPE_PK,
            'MAC' => Schema::TYPE_STRING,
            'device' => Schema::TYPE_STRING,
            'visit_time' => Schema::TYPE_INTEGER,
            'signal' => Schema::TYPE_STRING
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->tableCurrentName);
    }
}

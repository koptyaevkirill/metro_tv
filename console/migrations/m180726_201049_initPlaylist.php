<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m180726_201049_initPlaylist
 */
class m180726_201049_initPlaylist extends Migration
{
    protected $tableCurrentName = '{{%tv_playlist}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable($this->tableCurrentName, [
            'id' => Schema::TYPE_PK,
            'company_name' => Schema::TYPE_STRING,
            'video_title_ru' => Schema::TYPE_STRING,
            'video_title_en' => Schema::TYPE_STRING,
            'start' => Schema::TYPE_INTEGER,
            'finish' => Schema::TYPE_INTEGER
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

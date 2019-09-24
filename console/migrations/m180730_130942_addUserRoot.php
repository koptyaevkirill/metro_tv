<?php

use yii\db\Migration;
use common\models\User;

/**
 * Class m180730_130942_addUserRoot
 */
class m180730_130942_addUserRoot extends Migration
{
    protected $tableCurrentName = '{{%user}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $model = Yii::createObject(['class' => User::className()]);
        $model->username = 'root';
        $model->setPassword('metrotv');
        $model->email = 'root@metrotv.by';
        $model->generateAuthKey();
        $model->save();
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $model = User::find()->where(['username' => 'root'])->one();
        $model->delete();
    }
}

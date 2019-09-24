<?php
namespace backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use common\models\Device;
use yii\data\SqlDataProvider;
use yii\db\Query;

use common\models\Data;

/**
 * Device model
 *
 * @property integer $id
 */
class DeviceForm extends Device
{
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountDataDay() {
        $command = Yii::$app->db->createCommand('SELECT count(created_at) FROM `tv_data` WHERE `device_name` = :device_name AND `created_at` > :from AND `created_at` < :to');
        $command->bindValue(':device_name', $this->name);
        $command->bindValue(':from', 1543525200);
        $command->bindValue(':to', 1543611540);
        $total = $command->queryScalar();
        return $total;
    }
    
    public function getDatas() {
        $command = Yii::$app->db->createCommand('SELECT `created_at` FROM '.Data::tableName().' WHERE `device_name` = :device_name');
        $command->bindValue(':device_name', $this->name);
        $data = $command->queryAll();
        return $data;
    }
    
    
}

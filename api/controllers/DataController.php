<?php
namespace api\controllers;

use yii\rest\ActiveController;
use api\components\actions\CreateDataAction;

class DataController extends ActiveController
{
    public $modelClass = 'backend\models\Data';
    
    public function actions() {
        $actions = array_merge(parent::actions(), [
            'create' => [
                'class' => CreateDataAction::className(),
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'scenario' => $this->createScenario
            ]
        ]);
        return $actions;
    }
}

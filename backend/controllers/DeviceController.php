<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use DateTime;

/**
 * DeviceController implements the CRUD actions for Device model.
 */
class DeviceController extends Controller
{
    public $modelClass          = 'common\models\Device';
    public $modelFormClass      = 'backend\models\DeviceForm';
    public $modelSearchClass    = 'backend\models\DeviceSearch';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@']
                ]
            ]
        ];
        return $behaviors;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new $this->modelSearchClass;
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function actionCreate() {
        $model = new $this->modelFormClass;
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post())  && $model->validate()) {
            if ($model->save()) {
                if (!$returnUrl = filter_input(INPUT_POST, 'returnUrl' , FILTER_SANITIZE_URL)) {
                    $returnUrl = ['index'];
                }
                return $this->redirect($returnUrl);
            } else {
                throw new \yii\web\ServerErrorHttpException(Yii::t('app', 'Failed to save model'));
            }
            return $this->redirect($returnUrl);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function actionUpdate(string $id = null) {
        $model = $this->modelFormClass::findOne($id);
        $this->performAjaxValidation($model);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {    
            if ($model->save()) {
                if (!$returnUrl = filter_input(INPUT_POST, 'returnUrl' , FILTER_SANITIZE_URL)) {
                    $returnUrl = ['index'];
                }
                return $this->redirect($returnUrl);
            } else {
                throw new \yii\web\ServerErrorHttpException(Yii::t('app', 'Failed to save model'));
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function actionDelete($id)
    {
        try {
            $this->delete($id);
        }catch (\Exception $e) {
            throw($e);
            Yii::$app->getSession()->setFlash('error', [
                'type' => 'error',
                'duration' => 5000,
                'message' => $e->getMessage(),
                'title' => Yii::t('app', 'Delete Error'),
            ]);
        }
        
        if (!$returnUrl = Yii::$app->request->referrer) {
            $returnUrl = ['index'];
        }
        
        return $this->redirect($returnUrl);
    }
    protected function delete($id) {
        $model = $this->modelFormClass::findOne($id);
        if (!$result = $model->delete()) {
            throw new \yii\base\Exception("Delete error: ".print_r($model->getErrors(), true));
        }
        return $result;
    }
    
    public function performAjaxValidation(\yii\base\Model $model) {
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                echo json_encode(ActiveForm::validate($model));
                Yii::$app->end();
            }
        }
    }
    
    /**
     * Display channel list with ajax request
     */
    public function actionDetails(string $id = null) {
        $model = $this->modelFormClass::findOne($id);
        if(Yii::$app->request->isAjax && $model instanceof $this->modelClass) {
            return $this->renderAjax('details', [
                'model' => $model
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}

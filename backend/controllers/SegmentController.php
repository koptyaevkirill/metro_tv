<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\components\ExportDataExcel;
use moonland\phpexcel\Excel;

use common\components\module\APIClient;
use yii\helpers\ArrayHelper;
use common\components\helpers\SegmentHelper;

/**
 * SegmentController implements the CRUD actions for Segment model.
 */
class SegmentController extends Controller
{
    public $modelClass          = 'common\models\Segment';
    public $modelFormClass      = 'backend\models\SegmentForm';
    public $modelSearchClass    = 'backend\models\SegmentSearch';
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
        $model = new $this->modelFormClass;
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }
    
    
    /**
     * @return string
     */
    public function actionCreate()
    {
        $model = new $this->modelFormClass;
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                if(Yii::$app->consoleRunner->run('data/create-data-segment')) {
                    Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Create successfully. Please wait status "Create"'));
                }
                return $this->redirect(['index']);
            } else {
                throw new \yii\web\ServerErrorHttpException(Yii::t('app', 'Failed to save model'));
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public function actionDelete(int $id = null)
    {
        try {
            $model = $this->modelClass::findOne($id);
            if($model->platform_id_mail) {
                $token = SegmentHelper::getValidMailToken();
                $client = Yii::createObject(['class' => APIClient::class], [$token, APIClient::API_MAIL_URL]);
                $info = $client->deleteUserList($model->platform_id_mail);
            } elseif($model->platform_id) {
                $client = Yii::createObject(['class' => APIClient::class], [APIClient::YANDEX_TOKEN, APIClient::API_YANDEX_URL]);
                $info = $client->deleteSegment($model->platform_id);
            }
            $this->delete($id);
        } catch (\Exception $e) {
            throw($e);
            Yii::$app->getSession()->setFlash('error', [
                'type' => 'error',
                'duration' => 5000,
                'message' => $e->getMessage(),
                'title' => Yii::t('app', 'Delete Error'),
            ]);
        }
        if (!$returnUrl = Yii::$app->request->referrer) { $returnUrl = ['index']; }
        return $this->redirect($returnUrl);
    }
    protected function delete(int $id = null) {
        $model = $this->modelFormClass::findOne($id);
        if (!$result = $model->delete()) {
            throw new \yii\base\Exception("Delete error: ".print_r($model->getErrors(), true));
        }
        return $result;
    }
    
    /**
     * @inheritdoc
     */
    public function actionDownload(int $id = null)
    {
        $model = $this->modelFormClass::findOne($id);
        $dir = Yii::getAlias('@common')."/data/segments";
        $filename = $model->title.".xls";
        if (file_exists($dir.'/'.$filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($dir.'/'.$filename));
            readfile($dir.'/'.$filename);
            exit();
        }
    }
    
    /**
     * @inheritdoc
     */
    public function actionViewSite(int $id = null, string $type = '')
    {
        $model = $this->modelClass::findOne($id);
        $info = '';
        if($model->platform_id_mail && $type === 'mail') {
            $token = SegmentHelper::getValidMailToken();
            $client = Yii::createObject(['class' => APIClient::class], [$token, APIClient::API_MAIL_URL]);
            $info = $client->getUserList($model->platform_id_mail);
        } elseif($model->platform_id && $type === 'yandex') {
            $client = Yii::createObject(['class' => APIClient::class], [APIClient::YANDEX_TOKEN, APIClient::API_YANDEX_URL]);
            $info = $client->getSegment($model->platform_id, $model->title);
        }
        return $this->renderAjax('segment-platform-view', [
            'info' => $info
        ]);
    }
    
    /**
     * @param integer $id Segment
     * 
     * @return string
     */
    public function actionSendYandex(int $id = null)
    {
    	$cmd = sprintf('data/send-yandex %d', $id);
        if(Yii::$app->consoleRunner->run($cmd)) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Send successfully'));
        } else {
        	Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error send'));
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id Segment
     * 
     * @return string
     */
    public function actionSendMail(int $id = null)
    {
        $cmd = sprintf('data/send-mail %d', $id);
        if(Yii::$app->consoleRunner->run($cmd)) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Send successfully'));
        } else {
        	Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Error send'));
        }
        return $this->redirect(['index']);
    }
}

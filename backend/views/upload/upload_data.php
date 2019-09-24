<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model \backend\models\UploadDataForm
 */

$this->title = Yii::t('app', 'Upload {entity}', ['entity' => Yii::t('app', 'data')]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-playlist">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'dataFile')->fileInput() ?>
    <div class="form-group mt10">
        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>


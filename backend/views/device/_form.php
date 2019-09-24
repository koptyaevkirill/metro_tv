<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model broadcaster\rotation\models\DeviceForm */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="device-form">
    <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'enableClientValidation' => false
        ]); ?>
        <?= $form->field($model, 'name')->textInput(); ?>
        <?= $form->field($model, 'title')->textInput(); ?>
        <?= $form->field($model, 'active')->hiddenInput(['value' => 0])->label(false); ?>
        <?= Html::hiddenInput('returnUrl', Yii::$app->request->referrer ?: ['index']);?>
        <div class="form-group text-right">
            <?= Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-success']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>

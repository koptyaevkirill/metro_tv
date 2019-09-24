<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\components\helpers\DataHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model \backend\models\ViewDataForm
 */

$this->title = Yii::t('app', 'View {entity}', ['entity' => Yii::t('app', 'data')]);
$this->params['breadcrumbs'][] = $this->title;
$videos = DataHelper::getOptions();
?>
<div class="view-data">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="row mt15">
        <div class="col-sm-6">
            <?= $form->field($model, 'video')->label(false)->widget(Select2::className(), [
                'data' => $videos,
                'options' => [
                    'placeholder' => Yii::t('app', 'Select {single}', ['single' => Yii::t('app', 'videos')]),
                    'multiple' => true
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]); ?>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'from')->label(false)->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => Yii::t('app', 'Enter the start date')],
                        'readonly' => true,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyymmdd'
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'to')->label(false)->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => Yii::t('app', 'Enter end date')],
                        'readonly' => true,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyymmdd'
                        ]
                    ]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'count')->label(false)->textInput([
                        'placeholder' => Yii::t('app', 'Accumulated contacts')
                    ]); ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'count')->label(false)->textInput([
                        'placeholder' => Yii::t('app', 'Segment title'),
                        'value' => Yii::t('app', 'Segment').'_'.date('Ymd').'-'.date('H:i')
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group mt15 text-center">
        <?= Html::submitButton(Yii::t('app', 'Create a segment by the specified parameters'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>


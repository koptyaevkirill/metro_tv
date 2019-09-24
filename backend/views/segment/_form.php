<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\time\TimePicker;
use kartik\select2\Select2;
use common\components\helpers\DataHelper;
use common\components\helpers\DeviceHelper;
use common\components\helpers\SegmentHelper;

/* @var $this yii\web\View */
/* @var $model broadcaster\rotation\models\DeviceForm */
/* @var $form yii\widgets\ActiveForm */
$videos = DataHelper::getOptions();
$devices = DeviceHelper::getOptions();
$disabled = SegmentHelper::getCountCreatingSegments() > 0 ? true : false;
?>
<?php $form = ActiveForm::begin(['action' => ['create'],'options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="row mt15">
    <div class="col-sm-6">
        <?= $form->field($model, 'videos')->label(false)->widget(Select2::className(), [
            'data' => $videos,
            'options' => [
                'placeholder' => Yii::t('app', 'Select {single}', ['single' => Yii::t('app', 'videos')]),
                'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ]
        ]); ?>
        <?= $form->field($model, 'device_ids')->label(false)->widget(Select2::className(), [
            'data' => $devices,
            'options' => [
                'placeholder' => Yii::t('app', 'Select {single}', ['single' => Yii::t('app', 'devices')]),
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
                <?= $form->field($model, 'valid_from')->label(false)->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'The start date')],
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'valid_to')->label(false)->widget(DateTimePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'The end date')],
                    'readonly' => true,
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true
                    ]
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'count_contact')->label(false)->textInput([
                    'placeholder' => Yii::t('app', 'Accumulated contacts').' '.Yii::t('app', 'From')
                ]); ?>
                <?= $form->field($model, 'count_contact_to')->label(false)->textInput([
                    'placeholder' => Yii::t('app', 'Accumulated contacts').' '.Yii::t('app', 'To')
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'title')->label(false)->textInput([
                    'placeholder' => Yii::t('app', 'Segment title'),
                    'value' => Yii::t('app', 'Segment').'_'.date('Ymd').'-'.date('H-i')
                ]); ?>
            </div>
            <div class="col-sm-12"><?=$form->field($model, 'valid_end_enabled')->checkbox();?></div>
            <div class="col-sm-6">
                <?= $form->field($model, 'valid_end_from')->label(false)->widget(TimePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'The start date To')],
                    'readonly' => true,
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'showMeridian' => false,
                        'minuteStep' => 60,
                    ],
                    'addonOptions' => [
                        'asButton' => true,
                        'buttonOptions' => ['class' => 'btn btn-info']
                    ]
                ]); ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'valid_end_to')->label(false)->widget(TimePicker::classname(), [
                    'options' => ['placeholder' => Yii::t('app', 'The end date To')],
                    'readonly' => true,
                    'pluginOptions' => [
                        'todayHighlight' => true,
                        'showMeridian' => false,
                        'minuteStep' => 60,
                    ],
                    'addonOptions' => [
                        'asButton' => true,
                        'buttonOptions' => ['class' => 'btn btn-info']
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-group mt15 text-center">
    <?= Html::submitButton(Yii::t('app', 'Create a segment by the specified parameters'), ['class' => 'btn btn-success', 'disabled' => $disabled]) ?>
</div>
<?php ActiveForm::end() ?>

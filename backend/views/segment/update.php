<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model backend\models\DeviceForm */
$this->title = Yii::t('app', 'Update device');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Devices'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-create">
    <div class="row">
        <h1 class="mt0 text-center"><?= Html::encode($this->title) ?></h1>
        <div class="clearfix"></div>
        <div class="col-md-4 col-md-offset-4 mt15">
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
        </div>
    </div>
</div>
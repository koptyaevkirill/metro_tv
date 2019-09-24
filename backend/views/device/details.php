<?php
/* @var $this yii\web\View */
/* @var $model backend\models\DeviceForm */
/* @var $form yii\widgets\ActiveForm */
$data = $model->details;
$count_all = 0;
?>
<div class="list-group list-group-flush">
    <?php foreach ($data as $item): ?>
        <div class="list-group-item">
            <?= Yii::$app->formatter->asDate($item->day); ?><span class="badge"><?=$item->count_data;?></span>
        </div>
        <?php $count_all += $item->count_data; ?>
    <?php endforeach; ?>
    <div class="list-group-item list-group-item-success">
        <?= Yii::t('app', 'Total items'); ?><span class="badge"><?=$count_all;?></span>
    </div>
</div>

    
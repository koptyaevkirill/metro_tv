<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\DeviceForm */
/* @var $form yii\widgets\ActiveForm */
//$data = ArrayHelper::getColumn($model->datas, 'created_at');
//echo "<pre>";
//var_dump($data);
//echo "</pre>";
//exit();
?>
<div class="list-group list-group-flush">
    <div class="list-group-item list-group-item-success">
        <?= Yii::t('app', 'Total items'); ?><span class="badge"></span>
    </div>
    <?php foreach (range(0, $days) as $i): ?>
        <div class="list-group-item">
            <?php
                $count = 0;
//                foreach($data as $key => $item) {
//                    if($date_begin >= $item) {
//                        $count++;
//                    } else {
//                        break;
//                    }
//                    $data = array_slice($data, $key);
//                }
            ?>
            <?= Yii::$app->formatter->asDate($date_begin); ?><span class="badge"><?=$count;?></span>
            <?php $date_begin = $date_begin + strtotime("1 day", 0); ?>
        </div>
    <?php endforeach; ?>
</div>

    
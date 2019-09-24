<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'View {entity}', ['entity' => Yii::t('app', 'data')]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-index">
    <div class="row">
        <div class="col-md-12">
            <h1 class="mt0 text-center csite"><?= $this->title;?></h1>
            <?= $this->render('_form', [
                'model' => $model
            ]); ?>
        </div>
        
        <div class="col-md-12 text-center mt15">
            <?= $this->render('_grid', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider
            ]); ?>
        </div>
    </div>
</div>
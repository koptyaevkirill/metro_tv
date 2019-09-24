<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Devices');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-index">
    <div class="row">
        <h1 class="mt0 text-center csite"><?= $this->title;?></h1>
        <div class="col-md-12 text-center">
            <?= Html::a(Yii::t('app', 'Add device'), ['create'], ['class' => 'btn btn-success']); ?>
        </div>
        <div class="col-md-12 text-center mt15">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'headerRowOptions' => ['class' => 'text-center'],
                'columns' => [
                    'name' => [
                        'headerOptions' => ['class' => 'text-center'],
                        'attribute' => 'name',
                        'enableSorting' => false
                    ],
                    'title' => [
                        'headerOptions' => ['class' => 'text-center'],
                        'attribute' => 'title',
                        'enableSorting' => false
                    ],
                    'created_at' => [
                        'headerOptions' => ['class' => 'text-center'],
                        'attribute' => 'created_at',
                        'format' => 'datetime',
                        'enableSorting' => false
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'label' => Yii::t('app', 'Last request'),
                        'format' => 'raw',
                        'value' => function($model) {
                            return ($lastdata = $model->lastdata) ? Yii::$app->formatter->asDuration(time() - $lastdata->created_at, ' ') : '-';
                        }
                    ],
                    [
                        'headerOptions' => ['class' => 'text-center'],
                        'label' => Yii::t('app', 'Detailed information'),
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::button(Yii::t('app', 'View'), [
                                'class' => 'btn btn-default view-model',
                                'title' => Yii::t('app', 'View data for all time'),
                                'data-url' => Url::to(['details', 'id' => $model->name])
                            ]);
                        }
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => Yii::t('app', 'Actions'),
                        'headerOptions' => ['class' => 'text-center'],
                        'template' => '{update} {delete}',
                    ]
                ],
            ]) ?>
        </div>
    </div>
</div>

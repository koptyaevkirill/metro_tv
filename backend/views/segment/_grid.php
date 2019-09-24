<?php
use yii\grid\GridView;
use common\components\helpers\SegmentHelper;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model broadcaster\rotation\models\DeviceForm */
$disabled = SegmentHelper::getCountCreatingSegments() > 0 ? 'disabled' : false;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'headerRowOptions' => ['class' => 'text-center'],
    'columns' => [
        'id' => [
            'headerOptions' => ['class' => 'text-center'],
            'attribute' => 'id'
        ],
        'title' => [
            'headerOptions' => ['class' => 'text-center'],
            'attribute' => 'title',
            'contentOptions' => ['class' => 'wordwrap']
        ],
        'status' => [
            'headerOptions' => ['class' => 'text-center'],
            'attribute' => 'status',
            'format' => 'raw',
            'value' => function($model) {
                return SegmentHelper::getStatusType($model->status);
            }
        ],
        'count_row' => [
            'headerOptions' => ['class' => 'text-center'],
            'attribute' => 'count_row'
        ],
        [
            'label' => Yii::t('app', 'From').' - '.Yii::t('app', 'To'),
            'headerOptions' => ['class' => 'text-center'],
            'format' => 'raw',
            'value' => function($model) {
                $datetime = Yii::$app->formatter->asDatetime($model->valid_from).'<br/>'.Yii::$app->formatter->asDatetime($model->valid_to);
                if($model->valid_end_enabled) {
                    $datetime = Yii::$app->formatter->asDatetime($model->valid_from).'<br/>'.Yii::$app->formatter->asDatetime($model->valid_to).'<br/>'.$model->valid_end_from.' &mdash; '.$model->valid_end_to;
                }
                return $datetime;
            }
        ],
        [
            'headerOptions' => ['class' => 'text-center'],
            'label' => Yii::t('app', 'Accumulated contacts'),
            'format' => 'raw',
            'value' => function($model) {
                return $model->count_contact.' - '.$model->count_contact_to;
            }
        ],
        'created_at' => [
            'headerOptions' => ['class' => 'text-center'],
            'attribute' => 'created_at',
            'format' => 'datetime'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Information from the site'),
            'headerOptions' => ['class' => 'text-center'],
            'template' => '{view-yandex} {view-mail}',
            'buttons' => [
                'view-yandex' => function($url, $model) {
                    $disabled = $model->platform_id ? '' : 'disabled';
                    return Html::button(FA::icon('yahoo'), [
                        'class' => 'btn btn-default view-model '.$disabled,
                        'title' => Yii::t('app', 'Information from the site'),
                        'data-url' => Url::to(['view-site', 'id' => $model->id, 'type' => 'yandex']),
                    ]);
                },
                'view-mail' => function($url, $model) {
                    $disabled = $model->platform_id_mail ? '' : 'disabled';
                    return Html::button(FA::icon('at'), [
                        'class' => 'btn btn-default view-model '.$disabled,
                        'title' => Yii::t('app', 'Information from the site'),
                        'data-url' => Url::to(['view-site', 'id' => $model->id, 'type' => 'mail']),
                    ]);
                }
            ]
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => Yii::t('app', 'Actions'),
            'headerOptions' => ['class' => 'text-center'],
            'template' => '{send-yandex} {send-mail} {download} {delete}',
            'buttons' => [
                'send-yandex' => function ($url, $model) use ($disabled) {
                    $disabled = $model->platform_id ? 'disabled' : $disabled;
                    return Html::a(FA::icon('yahoo'), $url, [
                        'title' => Yii::t('app', 'Send to {entity}', ['entity' => Yii::t('app', 'yandex')]),
                        'aria-label' => Yii::t('app', 'Send to {entity}', ['entity' => Yii::t('app', 'yandex')]),
                        'class' => 'btn btn-danger '.$disabled
                    ]);
                },
                'send-mail' => function ($url, $model) use ($disabled) {
                    $disabled = $model->platform_id_mail ? 'disabled' : $disabled;
                    return Html::a(FA::icon('at'), $url, [
                        'title' => Yii::t('app', 'Send to {entity}', ['entity' => Yii::t('app', 'mail')]),
                        'aria-label' => Yii::t('app', 'Send to {entity}', ['entity' => Yii::t('app', 'mail')]),
                        'class' => 'btn btn-primary '.$disabled
                    ]);
                },
                'download' => function ($url, $model) use ($disabled) {
                    return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, [
                        'title' => Yii::t('app', 'Download'),
                        'aria-label' => Yii::t('app', 'Download'),
                        'class' => 'btn btn-info '.$disabled
                    ]);
                }
            ]
        ]
    ],
]); ?>
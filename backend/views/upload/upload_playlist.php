<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/**
 * @var $this  yii\web\View
 * @var $form  yii\widgets\ActiveForm
 * @var $model \backend\models\UploadPlaylistForm
 */

$this->title = Yii::t('app', 'Upload {entity}', ['entity' => Yii::t('app', 'playlist')]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="upload-playlist">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
    <?= $form->field($model, 'playlistFile')->fileInput() ?>
    <div class="form-group mt10">
        <?= Html::submitButton(Yii::t('app', 'Add'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
    <?php if(!empty($data)): ?>
      <div class="col-md-6 col-md-offset-3">
        <table class="table">
          <thead>
            <tr>
              <th scope="col"><?= Yii::t('app', 'Uploaded {entity}', ['entity' => Yii::t('app', 'files')]); ?></th>
              <th scope="col"><?= Yii::t('app', 'Delete'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($data as $item): ?>
                <tr>
                  <th scope="row"><?= $item->filename; ?></th>
                  <th scope="row"><a href="<?= Url::to(['delete', 'filename' => $item->filename, 'table' => 'playlist']); ?>"><span class="glyphicon glyphicon-trash"></span></a></th>
                </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
</div>


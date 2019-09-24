<?php

/* @var $this yii\web\View */
?>
<div class="segment-platform-view">
    <div class="row">
        <div class="col-md-12">
            <?php foreach($info as $index => $property): ?>
                <p><strong><?=$index;?></strong>: <?=$property;?></p>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php

use app\helpers\App;
use app\helpers\Html;
?>

<div class="d-flex">
    <div>
        <?= Html::image($model, ['w' => 60], ['class' => 'img-fluid symbol']) ?>
    </div>
    <div>
        <div class="ml-4">
            <span class="app-hidden"><?= strtotime($model->created_at) ?></span>
            <?= App::formatter('asFulldate', $model->created_at) ?>
            <br><span><b id="file-<?= $model->id ?>"><?= strtoupper($model->name) ?></b></span>
            <br><?= $model->fileSize ?>
            <br><?= strtoupper($model->extension) ?>
        </div>
    </div>
</div>
<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\VideoSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = 'Video: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new VideoSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="video-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <div class="row">
        <div class="col-md-6">
            <?= Detail::widget(['model' => $model]) ?>
        </div>
        <div class="col-md-6">
            <iframe class="br-1" width="100%" height="100%"src="https://www.youtube.com/embed/<?= $model->videoId ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
        </div>
    </div>
</div>
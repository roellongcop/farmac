<?php

use app\models\search\VideoSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = 'Update Video: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new VideoSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="video-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
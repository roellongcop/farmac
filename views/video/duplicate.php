<?php

use app\models\search\VideoSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = 'Duplicate Video: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new VideoSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="video-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
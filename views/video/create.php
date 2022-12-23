<?php

use app\models\search\VideoSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new VideoSearch();
?>
<div class="video-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
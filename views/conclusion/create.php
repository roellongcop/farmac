<?php

use app\models\search\ConclusionSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Conclusion */

$this->title = 'Create Conclusion';
$this->params['breadcrumbs'][] = ['label' => 'Conclusions', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ConclusionSearch();
?>
<div class="conclusion-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
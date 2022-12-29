<?php

use app\models\search\ConcernSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Concern */

$this->title = 'Create Concern';
$this->params['breadcrumbs'][] = ['label' => 'Concerns', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ConcernSearch();
?>
<div class="concern-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
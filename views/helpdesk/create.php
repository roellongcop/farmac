<?php

use app\models\search\HelpdeskSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */

$this->title = 'Create Helpdesk';
$this->params['breadcrumbs'][] = ['label' => 'Helpdesks', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new HelpdeskSearch();
?>
<div class="helpdesk-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
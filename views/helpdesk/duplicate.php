<?php

use app\models\search\HelpdeskSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */

$this->title = 'Duplicate Helpdesk: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Helpdesks', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new HelpdeskSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="helpdesk-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
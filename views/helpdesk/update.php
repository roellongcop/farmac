<?php

use app\models\search\HelpdeskSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */

$this->title = 'Update Helpdesk: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Helpdesks', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new HelpdeskSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="helpdesk-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
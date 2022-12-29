<?php

use app\models\search\ConcernSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Concern */

$this->title = 'Duplicate Concern: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Concerns', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ConcernSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false;
?>
<div class="concern-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
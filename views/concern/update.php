<?php

use app\models\search\ConcernSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Concern */

$this->title = 'Update Concern: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Concerns', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ConcernSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false;
?>
<div class="concern-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
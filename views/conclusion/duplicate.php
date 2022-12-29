<?php

use app\models\search\ConclusionSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Conclusion */

$this->title = 'Duplicate Conclusion: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Conclusions', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ConclusionSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="conclusion-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
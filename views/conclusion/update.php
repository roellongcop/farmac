<?php

use app\models\search\ConclusionSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Conclusion */

$this->title = 'Update Conclusion: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Conclusions', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ConclusionSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="conclusion-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
<?php

use app\models\search\InquirySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Inquiry */

$this->title = 'Update Inquiry: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Inquiries', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new InquirySearch();
$this->params['showCreateButton'] = true; 
?>
<div class="inquiry-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
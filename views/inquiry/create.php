<?php

use app\models\search\InquirySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Inquiry */

$this->title = 'Create Inquiry';
$this->params['breadcrumbs'][] = ['label' => 'Inquiries', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new InquirySearch();
?>
<div class="inquiry-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
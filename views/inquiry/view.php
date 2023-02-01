<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\InquirySearch;

/* @var $this yii\web\View */
/* @var $model app\models\Inquiry */

$this->title = 'Inquiry: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Inquiries', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new InquirySearch();
$this->params['showCreateButton'] = true; 
?>
<div class="inquiry-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>
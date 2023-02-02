<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\search\InquirySearch;
use app\widgets\Anchors;
use app\widgets\Detail;

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
    <?= App::if($model->isCreatableConcern, Html::a('Create Concern', ['concern/create', 'name' => $model->name], [
        'class' => 'btn btn-success font-weight-bold'
    ])) ?>
    <?= Detail::widget(['model' => $model]) ?>
</div>
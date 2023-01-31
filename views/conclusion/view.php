<?php

use app\helpers\Html;
use app\models\search\ConclusionSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Conclusion */

$this->title = 'Conclusion: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Conclusions', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ConclusionSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="conclusion-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Html::a('View Concern', $model->concern->viewUrl, [
        'class' => 'btn btn-primary font-weight-bold'
    ]) ?>
    <?= Detail::widget(['model' => $model]) ?>
</div>
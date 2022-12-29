<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ConclusionSearch;

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
    <?= Detail::widget(['model' => $model]) ?>
</div>
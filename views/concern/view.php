<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ConcernSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Concern */

$this->title = 'Concern: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Concerns', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ConcernSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="concern-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>
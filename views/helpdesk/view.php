<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\HelpdeskSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */

$this->title = 'Helpdesk: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Helpdesks', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new HelpdeskSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="helpdesk-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>
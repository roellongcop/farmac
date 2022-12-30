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
$this->params['wrapCard'] = false; 
?>
<div class="concern-view-page">
    <?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
        <?= Anchors::widget([
        	'names' => ['update', 'duplicate', 'delete', 'log'], 
        	'model' => $model
        ]) ?> 
        <?= Detail::widget(['model' => $model]) ?>
    <?php $this->endContent() ?>

    <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
        'title' => 'Decision Table'
    ]) ?>
    <?php $this->endContent() ?>
</div>
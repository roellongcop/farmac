<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ArticleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Article: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ArticleSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="article-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>
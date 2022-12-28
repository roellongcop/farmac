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
<div class="article-view-page article-content">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
    <p class="lead font-weight-bold text-uppercase mt-10">Sub Content</p>
    <?= $this->render('_sub-content', [
        'model' => $model
    ]) ?>
</div>
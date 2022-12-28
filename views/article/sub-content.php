<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\ArticleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Article: ' . $model->menu;
$this->params['breadcrumbs'][] = 'Livelihood Activities';
$this->params['breadcrumbs'][] = $model->category;
$this->params['breadcrumbs'][] = $model->menu;
$this->params['searchModel'] = new ArticleSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false; 
?>
<div class="article-view-page article-content">
    <?= $this->render('_sub-content', [
        'model' => $model
    ]) ?>
</div>
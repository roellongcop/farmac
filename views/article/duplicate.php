<?php

use app\models\search\ArticleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Duplicate Article: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new ArticleSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="article-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
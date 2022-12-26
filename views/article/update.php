<?php

use app\models\search\ArticleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Update Article: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new ArticleSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="article-update-page">
	<?= $this->render('_form', [
        'model' => $model,
        'activeStep' => $activeStep,
        'stepForms' => $stepForms
    ]) ?>
</div>
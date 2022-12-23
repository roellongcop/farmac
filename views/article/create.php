<?php

use app\models\search\ArticleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ArticleSearch();
$this->params['wrapCard'] = false;
?>
<div class="article-create-page">
	<?= $this->render('_form', [
		'model' => $model,
        'activeStep' => $activeStep,
        'stepForms' => $stepForms
	]) ?>
</div>
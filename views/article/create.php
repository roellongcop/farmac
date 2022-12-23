<?php

use app\models\search\ArticleSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Create Article';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new ArticleSearch();
?>
<div class="article-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
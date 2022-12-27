<?php

use app\models\search\ArticleSearch;
use app\widgets\ActiveForm;
use app\widgets\TinyMce;

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
	<?php $form = ActiveForm::begin(['id' => 'form-sub-content']) ?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <label>Content</label>
        <?= TinyMce::widget([
            'model' => $model,
            'attribute' => 'content'
        ]) ?>

        <div class="form-group mt-10">
            <?= ActiveForm::buttons() ?>
        </div>
    <?php ActiveForm::end() ?>
</div>
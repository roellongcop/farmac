<?php

use app\helpers\App;
use app\helpers\ArrayHelper;
use app\helpers\Html;
use app\widgets\Checkbox;
use app\widgets\DataList;
use app\widgets\ImageGallery;
use app\widgets\TinyMce;
?>
<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>

<div class="row">
	<div class="col-md-6">
		<?= DataList::widget([
			'form' => $form,
			'model' => $model,
			'attribute' => 'category',
			'data' => ArrayHelper::combine(App::params('article_categories'))
		]) ?>
		<?= $form->field($model, 'menu')->textInput(['maxlength' => true]) ?>
		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-md-6 text-center">
		<?= Html::image($model->photo, ['w' => 300], [
            'class' => 'img-fluid symbol article-photo',
            'loading' => 'lazy',
        ] ) ?>
        <div class="my-5"></div>

        <?= ImageGallery::widget([
        	'buttonTitle' => 'Choose Photo',
            'tag' => 'Article',
            'model' => $model,
            'attribute' => 'photo',
            'fixedSize' => false,
            'ajaxSuccess' => "
                if(s.status == 'success') {
                    $('.article-photo').attr('src', s.src);
                }
            ",
        ]) ?> 
	</div>
</div>
<div class="my-5"></div>
<div class="row">
	<div class="col-md-12">
		<label>Main Content</label>
		<?= TinyMce::widget([
			'model' => $model,
			'attribute' => 'content'
		]) ?>
	</div>
</div>

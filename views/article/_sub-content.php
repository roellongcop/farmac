<?php

use app\helpers\App;
use app\helpers\Html;
?>

<div class="row article-content" data-sticky-container>
	<div class="col-md-8">
		<?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
			<div class="text-center">
				<?= Html::image($model->photo, [], [
					'class' => 'img-fluid symbol',
					'width' => '100%'
				]) ?>
			</div>
			<h1 class="font-weight-bold text-dark my-10"> <?= $model->title ?> </h1>
			<div> <?= $model->content ?> </div>
			<?= App::foreach($model->contents, fn($content) => <<< HTML
				<div class="separator separator-dashed my-5"></div>
				<h4 class="font-weight-bold text-dark" id="content-{$content->slug}">
					{$content->title}
				</h4>
				<div> {$content->content} </div>
			HTML) ?>
		<?php $this->endContent() ?>
	</div>

	<div class="col-md-4">
		<div data-sticky="true" data-margin-top="100">
			<?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
				<div class="text-center mb-5">
					<h3 class=" font-weight-bold"><?= $model->title ?></h3>
				</div>
				<ul class="navi navi-accent navi-hover navi-bold navi-border">
					<?= App::foreach($model->contents, fn($content) => <<< HTML
						<li class="navi-item">
						    <a class="navi-link" href="#content-{$content->slug}">
						        <span class="navi-icon">
						        	<i class="fas fa-bookmark"></i>        
						        </span>
						        <span class="navi-text">
						        	{$content->title}
						        </span>
						    </a>
						</li> 
					HTML) ?>
				</ul>
			<?php $this->endContent() ?>
		</div>
	</div>
</div>

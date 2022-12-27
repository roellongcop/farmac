<?php

use app\helpers\App;
use app\helpers\Html;
?>

<div class="row">
	<div class="col-md-8">
		<?= Html::image($model->photo, [], ['class' => 'img-fluid symbol']) ?>

		<h4 class="font-weight-bold text-dark">
			<?= $model->title ?>
		</h4>
		<div>
			<?= $model->content ?>
		</div>


		<?= App::foreach($model->contents, fn($content) => <<< HTML
			<div class="separator separator-dashed my-5"></div>
			<h4 class="font-weight-bold text-dark" id="content-{$content->slug}">
				{$content->title}
			</h4>
			<div class="article-content">
				{$content->content}
			</div>
		HTML) ?>
	</div>

	<div class="col-md-4" style="border-left: 1px solid #ddd;">
		<p class="lead font-weight-bold"><?= $model->title ?></p>
		<ul class="navi navi-accent navi-hover navi-bold navi-border">
			<?= App::foreach($model->contents, fn($content) => <<< HTML
				<li class="navi-item">
				    <a class="navi-link" href="#content-{$content->slug}">
				        <span class="navi-icon">
				        	<i class="fas fa-cog"></i>        
				        </span>
				        <span class="navi-text">
				        	{$content->title}
				        </span>
				    </a>
				</li> 
			HTML) ?>
		</ul>
	</div>
</div>

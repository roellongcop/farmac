<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\models\Video;
use app\widgets\Youtube;
?>

<div class="card card-custom card-stretch gutter-b">
	<div class="card-body">
		<div id="carousel-video" class="carousel slide" data-ride="carousel" data-interval="8000">
			<div class="d-flex align-items-center justify-content-between flex-wrap">
				<span class="font-size-h6 text-muted font-weight-bolder text-uppercase pr-2">
					videos
				</span>
				<div class="p-0">
					<?= Html::tag('a', 'View All', [
						'href' => Url::toRoute(['video/client']),
						'class' => 'btn btn-sm btn-outline-secondary font-weight-bold mr-2'
					]) ?>
					<a href="#carousel-video" class="btn btn-icon btn-light btn-sm mr-1" role="button" data-slide="prev">
						<span class="svg-icon svg-icon-md">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<polygon points="0 0 24 0 24 24 0 24"></polygon>
									<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999)"></path>
								</g>
							</svg>
						</span>
					</a>
					<a href="#carousel-video" class="btn btn-icon btn-light btn-sm" role="button" data-slide="next">
						<span class="svg-icon svg-icon-md">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<polygon points="0 0 24 0 24 24 0 24"></polygon>
									<path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-270.000000) translate(-12.000003, -11.999999)"></path>
								</g>
							</svg>
						</span>
					</a>
				</div>
			</div>
			<div class="carousel-inner pt-9">
				<?= App::foreach(Video::recent(), function ($video, $key, $counter) {
					$class = $counter == 1 ? 'active': '';
					$youtube = Youtube::widget(['videoId' => $video->videoId]);
					return <<< HTML
						<div class="carousel-item {$class}">
							<div class="d-flex flex-column justify-content-between h-100">
								<h3 class="font-size-h4 text-dark-75 text-hover-primary font-weight-bold cursor-pointer">
									{$video->title}
								</h3>
								<p class="text-dark-75 font-size-lg font-weight-normal pt-2 mb-0">
									{$video->truncatedContent}
								</p>
							</div>
							<div class="my-2 text-center">
								{$youtube}
							</div>
							<div class="mt-10 border-0 d-flex align-items-center justify-content-between pt-0">
								<span class="label label-lg label-light-primary label-inline font-size-sm font-weight-bolder py-5">
									{$video->getCreatedDateFormat('d M y')}
								</span>
								<a href="{$video->clientUrlByTitle}" class="btn btn-sm btn-primary font-weight-bolder px-6">View</a>
							</div>
						</div>
					HTML;
				}) ?>
			</div>
		</div>
	</div>
</div>
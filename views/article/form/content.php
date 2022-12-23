<?php

use app\helpers\App;
?>

<div class="align-items-center d-flex justify-content-between">
	<div>
		<h4 class="mb-0 font-weight-bold text-dark">
			<?= $activeStep['description'] ?>
		</h4>
	</div>
	<div>
		<a href="#modal-add-content" class="btn btn-light-info font-weight-bolder btn-sm" data-toggle="modal">
			<i class="fa fa-plus"></i> Add Content
		</a>
	</div>
</div>

<div class="my-5"></div>
<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered" id="tbl-contents">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th class="th-action">action</th>
				</tr>
			</thead>
			<tbody>
				<?= App::foreach($model->contents, function($content, $key, $counter) {
					return <<< HTML
						<tr>
							<td>{$counter}</td>
							<td>{$content->title}</td>
							<td>
								<a href="{$content->viewUrl}" class="btn btn-info btn-sm" target="_blank">
									View
								</a>
								<a href="{$content->deleteUrl}" class="btn btn-danger btn-sm" data-confirm="Are you sure?" data-method="post">
									Delete
								</a>
							</td>
						</tr>
					HTML;
				}) ?>
			</tbody>
		</table>
	</div>
</div>


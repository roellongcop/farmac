<?php

use app\helpers\App;
use app\models\Inquiry;
?>

<div class="card card-custom card-stretch gutter-b">
	<div class="card-header border-0 pt-6">
		<h3 class="card-title align-items-start flex-column">
			<span class="card-label font-weight-bolder font-size-h4 text-dark-75">Top Unsolved Inquiries</span>
			<span class="text-muted mt-3 font-weight-bold font-size-lg">Top 5 Unsolved inquires</span>
		</h3>
	</div>

	<div class="card-body pt-7">
		<?= App::foreach(
			Inquiry::topUnsolved(), 
			fn ($inquiry) => $this->render('_inquiry', ['inquiry' => $inquiry])
		) ?>
	</div>
</div>
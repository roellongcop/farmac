<?php

$this->registerCss(<<< CSS

	.top-inquiries .symbol.symbol-35 .symbol-label {
	    min-width: 35px;
	    height: 35px;
	    width: fit-content;
	    padding-left: 0.5em;
	    padding-right: 0.5em;
	}
CSS);
?>


<div class="d-flex align-items-center mb-6 top-inquiries">
	<div class="symbol symbol-35 symbol-light-info flex-shrink-0 mr-3"  style="width: 20%;">
		<span class="symbol-label font-weight-bolder font-size-lg m-auto"><?= $inquiry->total ?></span>
	</div>
	<div class="d-flex align-items-center flex-wrap flex-row-fluid">
		<div class="d-flex flex-column pr-5 flex-grow-1">
			<a href="#" class="text-dark text-hover-primary mb-1 font-weight-bolder font-size-lg"><?= $inquiry->name ?></a>
			<span class="text-muted font-weight-bold"><?= $inquiry->userFullname ?></span>
		</div>
	</div>
</div>
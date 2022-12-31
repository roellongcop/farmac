<?php

use app\helpers\App;

$con = $conclusion ?? '';
?>

<?= App::if($model, fn ($model) => App::foreach($model->rules, function($rule) use($con) {
	$value = ($con)? ($con->conditions[$rule['label']] ?? ''): '';


	$inputs = App::foreach($rule['sub'] ?? [], function ($r) use($rule, $value) {
		$checked = ($value == $r['label'])? 'checked': '';

		return <<< HTML
			<label class="radio" v={$value}>
				<input type="radio" value="{$r['label']}" name="Conclusion[conditions][{$rule['label']}]" {$checked}>
				<span></span>
				{$r['label']}
			</label>
		HTML;
	});

	return <<< HTML
		<div class="form-group">
			<label class="font-weight-bold">{$rule['label']}</label>
			<div class="radio-inline">
				{$inputs}
			</div>
		</div>
	HTML;
})) ?>
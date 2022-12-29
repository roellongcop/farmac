<?php

use app\helpers\App;

$con = $conclusion ?? '';
?>

<?= App::if($model, fn ($model) => App::foreach($model->rules, function($rule) use($con) {
	$value = ($con)? ($con->conditions[$rule['label']] ?? ''): '';
	$NAchecked = ($value == '_')? 'checked': '';


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
				<label class="radio">
					<input value="_" type="radio" name="Conclusion[conditions][{$rule['label']}]" {$NAchecked}>
					<span></span>
					N/A
				</label>
			</div>
		</div>
	HTML;
})) ?>
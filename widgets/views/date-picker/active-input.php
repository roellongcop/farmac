<?php

$this->registerWidgetJs($widgetFunction, <<< JS
	$('.datepicker-{$widgetId}').datepicker({$options});
JS);
?>

<?= $form->field($model, $attribute)->textInput([
	'class' => "form-control datepicker-{$widgetId}",
	'autocomplete' => 'off',
	// 'readonly' => true
]) ?>
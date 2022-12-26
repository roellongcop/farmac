<?php

use app\helpers\App;

$this->addJsFile('sortable/Sortable.min');

$this->registerJs(<<< JS
	new Sortable(document.getElementById('content-container-list'), {
        handle: '.handle-sortable', // handle's class
        animation: 150,
        ghostClass: 'bg-light-primary'
    });
JS);
?>

<h4 class="mb-0 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>

<?= App::foreach($model->contents, function($content, $key, $counter) {

}) ?>


<div class="list-container mt-2"  id="content-container-list">
    <?= App::foreach($model->contents, function($content, $key, $counter) {
     
        return <<< HTML
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <button class="btn btn-secondary handle-sortable" type="button">
                        <i class="fas fa-arrows-alt"></i>
                    </button>
                </div>
                <input type="text" class="form-control" value="{$content->title}" readonly>
                <input type="hidden" name="sort[]" value="{$content->id}">
            </div>
        HTML;
    }) ?>
</div>
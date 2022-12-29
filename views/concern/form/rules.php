<?php

$this->addJsFile('js/jquery.nestable');

$this->registerWidgetCssFile('nestable');
$this->registerWidgetJsFile('nestable');

$this->registerJs(<<< JS
    new NestableWidget({
        widgetId: 'concern-rule',
        defaultName: 'Concern[rules]',
        maxDepth: 2,
        type: 'concern-rule'
    }).init();
JS);
?>

<div id="concern-rule">
    <div class="row">
        <div class="col-md-12">
            <div class="dd" id="dd-concern-rule">
                <ol class="dd-list" id="ol-dd-list-concern-rule">
                    <?= $this->render('_navigation', [
                        'data_id' => [],
                        'rules' => $model->rules,
                    ]) ?>
                </ol>
            </div>
            <menu id="nestable-menu-concern-rule" class="btn btn-group menu-nestable-menu pl-0 mt-3">
                <a href="#!" class="btn btn-secondary btn-linkedin btn-sm" id="add-main-navigation-concern-rule">
                    Add Entry
                </a>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-action="collapse-all">
                    <i class="fas fa-compress"></i> Collapse
                </button>
                <button class="btn btn-outline-secondary btn-sm" type="button" data-action="expand-all">
                    <i class="fas fa-expand"></i> Expand
                </button>
            </menu>
        </div>
    </div>
</div>
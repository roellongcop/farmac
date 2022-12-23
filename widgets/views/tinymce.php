<?php

use app\helpers\App;
use app\helpers\Html;

$this->registerJsFile(App::publishedUrl("/plugins/custom/tinymce/tinymce.bundle.js"), [
    'depends' => App::setting('theme')->appAssetClass
]);
$this->registerWidgetJsFile('tinymce');

$this->registerJs(<<< JS
    new TinyMceWidget({
        widgetId: '{$widgetId}',
        options: {$options},
    }).init();
JS);

$this->registerCss(<<< CSS
    #tinymce-{$widgetId} .tox-tinymce {
        height: {$height} !important;
        max-height: {$height} !important;
    }
CSS);
?>
<div class="tinymce" id="tinymce-<?= $widgetId ?>">
    <?= $textInput ?>
</div>


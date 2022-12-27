<?php

use app\helpers\App;
use app\helpers\Html;

$tableId = $tableId ?? 'table-file';
$pageLength = $pageLength ?? 5;
$withAction = $withAction ?? true;

$this->registerJsFile(App::publishedUrl("/plugins/custom/datatables/datatables.bundle.js"), [
    'depends' => App::setting('theme')->appAssetClass
]);


$this->registerJs(<<< JS
    $('#{$tableId}').DataTable({
        pageLength: {$pageLength},
        order: [[0, 'desc']],
        columns: [
            null,
            { "width": "20%" },
        ]
    });
JS);

?>
<table class="table table-bordered table-head-solid" id="<?= $tableId ?>">
    <thead>
        <tr>
            <th class="th-file">File</th>
            <?= Html::if($withAction, Html::tag('th', 'action', ['width' => 100, 'class' => 'text-center'])) ?>
        </tr>
    </thead>
    <tbody class="files-container">
        <?= $content ?>
    </tbody>
</table>
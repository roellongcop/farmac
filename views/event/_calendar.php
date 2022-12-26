<?php

use app\helpers\App;

$this->registerCssFile(App::publishedUrl("/plugins/custom/fullcalendar/fullcalendar.bundle.css"), [
    'depends' => App::setting('theme')->appAssetClass
]);
$this->registerJsFile(App::publishedUrl("/plugins/custom/fullcalendar/fullcalendar.bundle.js"), [
    'depends' => App::setting('theme')->appAssetClass
]);


$this->addJsFile('js/calendar');
?>



<div id="kt_calendar"></div>
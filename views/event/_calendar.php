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




<div class="modal fade" id="modal-event" tabindex="-1" role="dialog" aria-labelledby="modal-eventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-eventLabel">Update Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold btn-save-event">Save changes</button>
            </div>
        </div>
    </div>
</div>
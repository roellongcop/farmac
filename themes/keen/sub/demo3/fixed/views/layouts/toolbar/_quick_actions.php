<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\Notification;

$totalUnread = Notification::totalUnread();

$this->addJsFile('js/notification');
$this->registerJs(<<< JS
    pollNotification({$totalUnread});
JS);
?>
<div class="dropdown notification">
    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
        <div class="btn btn-icon btn-hover-transparent-white btn-dropdown btn-lg mr-1">
            <span class="svg-icon svg-icon-xl">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <rect x="0" y="0" width="24" height="24" />
                        <rect fill="#000000" opacity="0.3" x="13" y="4" width="3" height="16" rx="1.5" />
                        <rect fill="#000000" x="8" y="9" width="3" height="11" rx="1.5" />
                        <rect fill="#000000" x="18" y="11" width="3" height="9" rx="1.5" />
                        <rect fill="#000000" x="3" y="13" width="3" height="7" rx="1.5" />
                    </g>
                </svg>
            </span>
            <?= App::if($totalUnread, fn($total) => Html::tag('span', number_format($total), [
                'class' => 'badge badge-danger notification-badge'
            ])) ?>
        </div>
    </div>
    <div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
        <div class="d-flex flex-column p-10 rounded-to border-bottom">
            <h4 class="text-dark font-weight-bold mb-5">Notifications</h4>

            <div class="notification-content"></div>

            <?= Html::a('View All', ['notification/index'], [
                'class' => 'btn btn-primary font-weight-bold mt-10'
            ]) ?>
        </div>

    </div>
</div>
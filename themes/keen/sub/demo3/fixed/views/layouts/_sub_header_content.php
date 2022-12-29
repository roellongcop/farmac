<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

$page = $this->params['page'] ?? '';
?>

<!--begin::Logo-->
<!-- w-250px -->
<div class="d-none d-lg-flex align-items-center flex-wrap">  
	<!--begin::Logo-->
	<a href="index.html">
		<?= Html::image(App::setting('image')->primary_logo, ['w' => 150, 'quality' => 90], [
            'alt' => 'Primary Logo',
            'class' => 'max-h-50px',
        ]) ?>
	</a>
	<!--end::Logo-->
</div>
<!--end::Logo-->
<!--begin::Nav-->
<div class="subheader-nav nav flex-grow-1">
	<!--begin::Item-->
	<a href="<?= Url::toRoute(['/concern/client']) ?>" class="nav-item <?= $page == 'expert'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h6">Help Desk</span>
			<span class="nav-desc text-muted">Ask the system</span>
		</span>
	</a>
	<!--end::Item-->
	<!--begin::Item-->
	<!-- active -->
	<a href="<?= Url::toRoute(['/announcement/client']) ?>" class="nav-item <?= $page == 'announcement'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h6">Announcements</span>
			<span class="nav-desc text-muted">News & Updates</span>
		</span>
	</a>
	<!--end::Item-->
	<!--begin::Item-->
	<a href="<?= Url::toRoute(['/event/calendar-client']) ?>" class="nav-item <?= $page == 'calendar'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h6">Calendar</span>
			<span class="nav-desc text-muted">Events & Happenings </span>
		</span>
	</a>
	<!--end::Item-->
	<!--begin::Item-->
	<a href="<?= Url::toRoute(['/chat']) ?>" class="nav-item <?= $page == 'chat'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h6">Community Board</span>
			<span class="nav-desc text-muted">Group Chats & Inquiries</span>
		</span>
	</a>
	<!--end::Item-->

	<!--begin::Item-->
	<a href="<?= Url::toRoute(['/video/client']) ?>" class="nav-item <?= $page == 'video'? 'active': '' ?>"> 
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h6">Stream Videos</span>
			<span class="nav-desc text-muted">
				Youtube Contents
			</span>
		</span>
	</a>
	<!--end::Item-->
</div>
<!--end::Nav-->
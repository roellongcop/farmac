<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

$page = $this->params['page'] ?? '';
?>

<!--begin::Logo-->
<div class="d-none d-lg-flex align-items-center flex-wrap w-250px">
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
	<a href="<?= Url::toRoute(['/expert/index']) ?>" class="nav-item <?= $page == 'expert'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h4">Diagnostic AI</span>
			<span class="nav-desc text-muted">Ask the system</span>
		</span>
	</a>
	<!--end::Item-->
	<!--begin::Item-->
	<!-- active -->
	<a href="<?= Url::toRoute(['/announcement/client']) ?>" class="nav-item <?= $page == 'announcement'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h4">News and Updates</span>
			<span class="nav-desc text-muted">Publication Statements</span>
		</span>
	</a>
	<!--end::Item-->
	<!--begin::Item-->
	<a href="<?= Url::toRoute(['/event/calendar']) ?>" class="nav-item <?= $page == 'event'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h4">Calendar</span>
			<span class="nav-desc text-muted">Events & Happenings </span>
		</span>
	</a>
	<!--end::Item-->
	<!--begin::Item-->
	<a href="<?= Url::toRoute(['/chat']) ?>" class="nav-item <?= $page == 'chat'? 'active': '' ?>">
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h4">Community Board</span>
			<span class="nav-desc text-muted">Group Chats | Public & Private</span>
		</span>
	</a>
	<!--end::Item-->

	<!--begin::Item-->
	<a href="<?= Url::toRoute(['/user/my-account']) ?>" class="nav-item <?= $page == 'my-account'? 'active': '' ?>"> 
		<span class="nav-label px-10">
			<span class="nav-title text-dark-75 font-weight-bold font-size-h4">My Account</span>
			<span class="nav-desc text-muted">Profile Information</span>
		</span>
	</a>
	<!--end::Item-->
</div>
<!--end::Nav-->
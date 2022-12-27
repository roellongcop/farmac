<?php

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
?>

<h3>
	Your account was successfully activated by the admin.
</h3>

<?= App::if($user->isBlocked, Html::tag('p', 'Please click the verify link below if you not verifid your email yet.')) ?>

<p>
	<?= App::if($user->isBlocked, Html::tag('a', 'Verify Account', [
		'href' => Url::toRoute(['site/verify', 'vt' => $user->verification_token], true)
	])) ?>
	&nbsp;
	OR
	&nbsp;
	<?= Html::tag('a', 'Login', [
		'href' => Url::toRoute(['site/login'], true)
	]) ?>
</p>
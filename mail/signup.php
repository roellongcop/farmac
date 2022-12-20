<?php

use app\helpers\Html;
use app\helpers\Url;

$link = Url::toRoute(['site/verify', 'vt' => $user->verification_token], true);
?>
<h3>
	Thank You for signing up to FARMAC
</h3>

<p>Your account was successfully created.</p>
<p>You can access your account once activated by the admin.</p>

<p>For the mean time you can click the link below to verify your email</p>

<?= Html::tag('a', $link, [
	'href' => $link
]) ?>
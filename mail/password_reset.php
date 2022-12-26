<?php

use app\helpers\Html;
use app\helpers\Url;

$link = Url::toRoute(['site/reset-password', 'prt' => $user->password_reset_token], true);
?>

<h3>
	Hi! <?= $user->username ?>
</h3>
<p>
	Please click the link below to reset your password.
</p>

<p>
	<?= Html::tag($link, $link) ?>
</p>
<?php

use app\models\Helpdesk;
?>

<div class="navi-item">
    <a href="#" class="navi-link btn-hidden-message" data-message="<?= $inquiry->name ?>" data-hidden_message="/concern-<?= $inquiry->concern_id ? $inquiry->concern_id: (Helpdesk::UNSOLVED_PATTERN . <?= $inquiry->name) ?> ?>">
        <span class="navi-text"><?= $counter ?>) <?= $inquiry->name ?>
        </span>
    </a>
</div>

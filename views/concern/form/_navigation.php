<?php

use app\helpers\App;
use app\helpers\Html;
?>

<?= Html::foreach($rules, function($rule, $key) use ($data_id) {
    $data_id = App::generateRandomKey($data_id);
    return $this->render('_navigation-content', [
        'key' => $key,
        'rule' => $rule,
        'data_id' => $data_id,
    ]);
}) ?>

<?php

namespace app\tests\fixtures;

class HelpdeskFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Helpdesk';
    public $dataFile = '@app/tests/fixtures/data/helpdesk.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
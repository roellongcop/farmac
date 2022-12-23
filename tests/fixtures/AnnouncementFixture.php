<?php

namespace app\tests\fixtures;

class AnnouncementFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Announcement';
    public $dataFile = '@app/tests/fixtures/data/announcement.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
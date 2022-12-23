<?php

use app\models\Video;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'title' => 'Title',
		'description' => 'Description',
		'link' => 'Link',
		'record_status' => Video::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Video::RECORD_INACTIVE
]);

return $model->getData();
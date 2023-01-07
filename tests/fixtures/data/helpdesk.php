<?php

use app\models\Helpdesk;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'user_id' => 'User ID',
		'concern_id' => 'Concern ID',
		'question' => 'Question',
		'expectation' => 'Expectation',
		'status' => 'Status',
		'record_status' => Helpdesk::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Helpdesk::RECORD_INACTIVE
]);

return $model->getData();
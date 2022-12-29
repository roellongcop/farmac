<?php

use app\models\Conclusion;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'concern_id' => 'Concern ID',
		'conclusion' => 'Conclusion',
		'conditions' => 'Conditions',
		'record_status' => Conclusion::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Conclusion::RECORD_INACTIVE
]);

return $model->getData();
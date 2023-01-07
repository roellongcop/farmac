<?php

namespace tests\unit\models;

use app\models\Helpdesk;

class HelpdeskTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'user_id' => 'User ID',
            'concern_id' => 'Concern ID',
            'question' => 'Question',
            'expectation' => 'Expectation',
            'status' => 'Status',
            'record_status' => Helpdesk::RECORD_ACTIVE
        ], $replace);
    }

    public function testCreateSuccess()
    {
        $model = new Helpdesk($this->data());
        expect_that($model->save());
    }

    public function testNoInactiveDataAccessRoleUserCreateInactiveData()
    {
        \Yii::$app->user->login($this->tester->grabRecord('app\models\User', [
            'username' => 'no_inactive_data_access_role_user'
        ]));

        $data = $this->data(['record_status' => Helpdesk::RECORD_INACTIVE]);

        $model = new Helpdesk($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');

        \Yii::$app->user->logout();
    }

    public function testCreateNoData()
    {
        $model = new Helpdesk();
        expect_not($model->save());
    }

    public function testCreateInvalidRecordStatus()
    {
        $data = $this->data(['record_status' => 3]);

        $model = new Helpdesk($data);
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }

    public function testUpdateSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Helpdesk', [
            'record_status' => Helpdesk::RECORD_ACTIVE
        ]);
        $model->record_status = 1;
        expect_that($model->save());
    }

    public function testDeleteSuccess()
    {
        $model = $this->tester->grabRecord('app\models\Helpdesk', [
            'record_status' => Helpdesk::RECORD_ACTIVE
        ]);
        expect_that($model->delete());
    }

    public function testActivateData()
    {
        $model = $this->tester->grabRecord('app\models\Helpdesk', [
            'record_status' => Helpdesk::RECORD_INACTIVE
        ]);
        expect_that($model);

        $model->activate();
        expect_that($model->save());
    }

    public function testGuestDeactivateData()
    {
        $model = $this->tester->grabRecord('app\models\Helpdesk', [
            'record_status' => Helpdesk::RECORD_ACTIVE
        ]);
        expect_that($model);

        $model->inactivate();
        expect_not($model->save());
        expect($model->errors)->hasKey('record_status');
    }
}
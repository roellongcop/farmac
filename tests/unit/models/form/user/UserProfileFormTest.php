<?php

namespace tests\unit\models\form\user;

use app\helpers\App;
use app\models\form\user\UserProfileForm;

class UserProfileFormTest extends \Codeception\Test\Unit
{
    public function data($replace=[])
    {
        return array_replace([
            'user_id' => 2,
            'first_name' => 'John',
            'last_name' => 'Doe',

            'middle_name' => 'middle_name',
            'birthdate' => '1994-01-20',
            'sex' => 'Male',
            'contact_no' => '09384076957',
            'email' => 'email@email.com',
            'address' => 'address',
            'documents' => ['test'],
        ], $replace);
    }

    public function testFetch()
    {
        $model = new UserProfileForm(['user_id' => 1]);
        expect($model->first_name)->equals('admin_firstname');
        expect($model->last_name)->equals('admin_lastname');
    }

    public function testInvalidBirthDate()
    {
        $model = new UserProfileForm($this->data(['birthdate' => '5024-01-20']));
        expect_not($model->save());
        expect($model->errors)->hasKey('birthdate');
    }


    public function testInvalidSex()
    {
        $model = new UserProfileForm($this->data(['sex' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('sex');
    }

    public function testInvalidEmail()
    {
        $model = new UserProfileForm($this->data(['email' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('email');
    }

    public function testSuccess()
    {
        $model = new UserProfileForm($this->data());
        expect_that($model->save());
        expect($model->age)->equals(28);
    }

    public function testRequired()
    {
        $model = new UserProfileForm($this->data(['user_id' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');

        $model = new UserProfileForm($this->data(['first_name' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('first_name');

        $model = new UserProfileForm($this->data(['last_name' => NULL]));
        expect_not($model->save());
        expect($model->errors)->hasKey('last_name');
    }

    public function testInvalidUserId()
    {
        $model = new UserProfileForm($this->data(['user_id' => 'invalid']));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }

    public function testNotExistingUserId()
    {
        $model = new UserProfileForm($this->data(['user_id' => 9999]));
        expect_not($model->save());
        expect($model->errors)->hasKey('user_id');
    }
}
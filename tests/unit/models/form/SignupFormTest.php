<?php

namespace tests\unit\models\form;

use app\models\form\SignupForm;
use app\models\form\user\UserProfileForm;

class SignupFormTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'first_name' => 'first_name',
            'middle_name' => 'middle_name',
            'last_name' => 'last_name',
            'birthdate' => '1994-01-20',
            'sex' => 'Male',
            'contact_no' => '09384076957',
            'email' => 'email@test.com',
            'address' => 'address',
            'documents' => ['test'],
            'password' => 'password',
            'password_repeat' => 'password',
        ], $replace);
    }


    public function testInvalidBirthDate()
    {
        $model = new SignupForm($this->data(['birthdate' => '5024-01-20']));
        expect_not($model->signup());
        expect($model->errors)->hasKey('birthdate');
    }

    public function testExistingEmail()
    {
        $model = new SignupForm($this->data(['email' => 'developer@developer.com']));
        expect_not($model->signup());
        expect($model->errors)->hasKey('email');
    }


    public function testInvalidSex()
    {
        $model = new SignupForm($this->data(['sex' => 'invalid']));
        expect_not($model->signup());
        expect($model->errors)->hasKey('sex');
    }

    public function testInvalidEmail()
    {
        $model = new SignupForm($this->data(['email' => 'invalid']));
        expect_not($model->signup());
        expect($model->errors)->hasKey('email');
    }

    public function testSuccess()
    {
        $model = new SignupForm($this->data());

        $user = $model->signup();
        expect($model->age)->equals(28);

        expect_that($user);
        expect($user->email)->equals('email@test.com');
        expect($user->username)->equals('email');


        $model = new UserProfileForm(['user_id' => $user->id]);

        expect($model->first_name)->equals('first_name');
        expect($model->middle_name)->equals('middle_name');
        expect($model->last_name)->equals('last_name');
        expect($model->birthdate)->equals('1994-01-20');
        expect($model->sex)->equals('Male');
        expect($model->contact_no)->equals('09384076957');
        expect($model->email)->equals('email@test.com');
        expect($model->documents)->equals(['test']);

        $this->tester->seeRecord('app\models\Notification', [
            'type' => 'signup',
        ]);
    }


    public function testPasswordNotMatched()
    {
        $model = new SignupForm($this->data(['password' => 'invalid']));

        expect_not($model->signup());
        expect($model->errors)->hasKey('password_repeat');
    }
}
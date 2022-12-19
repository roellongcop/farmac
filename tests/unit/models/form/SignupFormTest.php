<?php

namespace tests\unit\models\form;

use app\models\form\SignupForm;

class SignupFormTest extends \Codeception\Test\Unit
{
    protected function data($replace=[])
    {
        return array_replace([
            'first_name' => 'first_name',
            'middle_name' => 'first_name',
            'last_name' => 'first_name',
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
        $model->signup();

        var_dump($model->errors) ;die;

        expect_that($model->signup());
        expect($model->age)->equals(28);
    }


    public function testPasswordNotMatched()
    {
        $model = new SignupForm($this->data(['password' => 'invalid']));

        expect_not($model->signup());
        expect($model->errors)->hasKey('password_repeat');
    }
}
<?php

namespace app\models\form;

class SignupForm extends \yii\base\Model
{
    public $first_name;
    public $middle_name;
    public $last_name;
    public $birthdate;
    public $age;
    public $sex;
    public $contact_no;
    public $email;
    public $address;
    public $documents;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'age', 'birthdate', 'sex', 'address', 'email', 'documents', 'password', 'password_repeat'], 'required'],
            [['first_name', 'last_name', 'age', 'birthdate', 'sex', 'contact_no', 'email', 'password', 'password_repeat'], 'string', 'max' => 225],
            [['email'], 'email'],
            [['email'], 'trim'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => "Passwords don't match"],
        ];
    }

    public function signup()
    {
        if (! $this->validate()) {
            return ;
        }



    }
}
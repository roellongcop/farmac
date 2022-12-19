<?php

namespace app\models\form;

use app\helpers\App;
use app\models\Role;
use app\models\User;

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
            [['first_name', 'last_name', 'birthdate', 'sex', 'contact_no', 'email', 'password', 'password_repeat'], 'string', 'max' => 225],
            [['age'], 'integer'],
            [['email'], 'email'],
            [['email'], 'trim'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => 'Passwords don\'t match'],
            ['birthdate', 'validateBirthDate'],
            ['email', 'email'],
            [['email'], 'trim'],
            ['sex', 'in', 'range' => [
                'Male', 'Female'
            ]],
        ];
    }

    public function validateBirthDate($attribute, $params)
    {
        $current_date = strtotime(App::formatter()->asDateToTimezone('', 'Y-m-d'));
        $birthdate = strtotime($this->birthdate);

        if ($birthdate > $current_date) {
            $this->addError('birthdate', 'Birthdate is greater than current date');
        }
    }


    public function signup()
    {
        if (! $this->validate()) {
            return ;
        }

        $explode = explode('@', $this->email);


        $user = new User([
            'role_id' => Role::CLIENT,
            'status' => User::STATUS_INACTIVE,
            'is_blocked' => User::UNBLOCKED
        ]);
        $user->password = $this->password;
        $user->username = $explode[0];
        $user->email = $this->email;

        if ($user->save()) {
            // code...

            return true;
        }

        $this->addError('user', $user->errors);

    }

    public function beforeValidate()
    {
        if (! parent::beforeValidate()) {
            return false;
        }

        $this->age = App::formatter()->asAge($this->birthdate);


        return true;
    }
}
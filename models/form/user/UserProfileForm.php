<?php

namespace app\models\form\user;

use app\helpers\App;
use app\helpers\Html;
use app\models\File;

class UserProfileForm extends UserForm
{
    const META_NAME = 'profile';

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

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return $this->setRules([
            [['first_name', 'last_name', 'birthdate', 'age', 'sex', 'documents'], 'required'],
            [['first_name', 'last_name', 'middle_name', 'birthdate', 'sex', 'contact_no', 'email', 'address'], 'string', 'max' => 225],
            [['age'], 'integer'],
            ['sex', 'in', 'range' => [
                'Male', 'Female'
            ]],
            ['email', 'email'],
            [['email'], 'trim'],
            ['birthdate', 'validateBirthDate'],
        ]);
    }

    public function validateBirthDate($attribute, $params)
    {
        $current_date = strtotime(App::formatter()->asDateToTimezone('', 'Y-m-d'));
        $birthdate = strtotime($this->birthdate);

        if ($birthdate > $current_date) {
            $this->addError('birthdate', 'Birthdate is greater than current date');
        }
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
        ];
    } 

    public function getDetailColumns()
    {
        return [
            'first_name:raw',
            'middle_name:raw',
            'last_name:raw',
            'birthdate:raw',
            'age:raw',
            'sex:raw',
            'contact_no:raw',
            'email:raw',
            'address:raw',
            // 'documentPreviews:raw',
        ];
    }

    public function getFiles()
    {
        return File::findAll(['token' => $this->documents]);
    }

    public function getDocumentPreviews()
    {
        return App::foreach(
            File::findAll(['token' => $this->documents]), 
            fn ($file) => Html::image($file->token, ['w' => 100], [
                'class' => 'symbol img-fluid'
            ])
        );
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
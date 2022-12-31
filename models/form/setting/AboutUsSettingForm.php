<?php

namespace app\models\form\setting;

class AboutUsSettingForm extends SettingForm
{
    const NAME = 'about-us-settings';

    public $map;
    public $mission;
    public $vision;
    public $description;

    public function rules()
    {
        return [
            [['map', 'mission', 'vision', 'description'], 'required'],
	        [['map', 'mission', 'vision', 'description'], 'string'],
        ];
    }

    public function default()
    {
        return [
            'map' => [
                'name' => 'map',
                'default' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d123698.69560743174!2d121.47848822493816!3d14.335566230249054!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397fa55884d8b05%3A0x22ecd503d6386005!2sKalayaan%2C%20Laguna!5e0!3m2!1sen!2sph!4v1671795776912!5m2!1sen!2sph" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'
            ],
            'mission' => [
                'name' => 'mission',
                'default' => 'To assist farmers in voicing their problems and requests'
            ],
            'vision' => [
                'name' => 'vision',
                'default' => 'To assist farmers in voicing their problems and requests'
            ],
            'description' => [
                'name' => 'description',
                'default' => 'Welcome to FARMA-C: an expert system for farmers in Kalayan equipped to assist farmers with their agricultural needs.We hope that end users will help in voicing their concerns to the Department of Agriculture. Please email us if you have any questions or comments.'
            ],
        ];
    }
}
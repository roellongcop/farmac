<?php

namespace app\models\form\setting;

use app\helpers\App;

class SystemSettingForm extends SettingForm
{
    const NAME = 'system-settings';
    const ASIA_MANILA = 'Asia/Manila';

    const OFF = 0;
    const ON = 1;

    public $timezone;
    public $pagination;
    public $auto_logout_timer;
    public $theme;
    public $whitelist_ip_only;
    public $enable_visitor;
    public $compensation_badge_threshold;
    public $compensation_badge_days_threshold;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['timezone', 'pagination', 'theme', 'auto_logout_timer', 'compensation_badge_threshold', 'compensation_badge_days_threshold'], 'required'],
	        [['timezone',], 'string'],
	        [['whitelist_ip_only', 'enable_visitor'], 'safe'],
	        [['pagination', 'auto_logout_timer', 'theme', 'whitelist_ip_only', 'enable_visitor', 'compensation_badge_threshold', 'compensation_badge_days_threshold'], 'integer'],

	        ['pagination', 'in', 'range' => array_keys(App::params('pagination'))],
	        ['whitelist_ip_only', 'in', 'range' => array_keys(App::params('whitelist_ip_only'))],
	        ['enable_visitor', 'in', 'range' => array_keys(App::params('enable_visitor'))],
	        ['theme', 'exist', 'targetClass' => 'app\models\Theme', 'targetAttribute' => 'id'],
	        ['timezone', 'in', 'range' => array_keys(App::component('general')->timezoneList())],
            [['compensation_badge_threshold', 'compensation_badge_days_threshold'], 'integer', 'min' => 1],
        ];
    }

    public function attributeLabels()
    {
        return [
            'compensation_badge_days_threshold' => 'Days Threshold',
            'compensation_badge_threshold' => 'Logs Counter Threshold'
        ];
    }

    public function default()
    {
        return [
            'timezone' => [
                'name' => 'timezone',
                'default' => self::ASIA_MANILA,
            ],
            'pagination' => [
                'name' => 'pagination',
                'default' => 10,
            ],
            'auto_logout_timer' => [
                'name' => 'auto_logout_timer',
                'default' => 1440
            ],
            'theme' => [
                'name' => 'theme',
                'default' => 1,
            ],
            'whitelist_ip_only' => [
                'name' => 'whitelist_ip_only',
                'default' => self::OFF,
            ],
            'enable_visitor' => [
                'name' => 'enable_visitor',
                'default' => self::OFF,
            ],
            'compensation_badge_threshold' => [
                'name' => 'compensation_badge_threshold',
                'default' => 100,
            ],

            'compensation_badge_days_threshold' => [
                'name' => 'compensation_badge_days_threshold',
                'default' => 7,
            ],
            
        ];
    }
}
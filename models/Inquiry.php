<?php

namespace app\models;

use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%inquiries}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $concern_id
 * @property string|null $name
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Inquiry extends ActiveRecord
{

    const SOLVED = 1;
    const UNSOLVED = 0;

    public $total = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%inquiries}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'inquiry',
            'mainAttribute' => 'inquiryId',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['user_id', 'concern_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            // ['concern_id', 'exist', 'targetRelation' => 'concern'],
            ['status', 'in', 'range' => [
                self::SOLVED,
                self::UNSOLVED,
            ]]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'user_id' => 'User ID',
            'concern_id' => 'Concern ID',
            'name' => 'Inquiry',
            'status' => 'Status',
        ]);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getUserFullname()
    {
        return App::if($this->user, fn ($user) => $user->fullname);
    }

    public function getConcern()
    {
        return $this->hasOne(Concern::class, ['id' => 'concern_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\InquiryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\InquiryQuery(get_called_class());
    }

    public function getInquiryId()
    {
        return strtotime($this->created_at) . $this->id;
    }
     
    public function gridColumns()
    {
        return [
            'id' => [
                'attribute' => 'id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->inquiryId,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'user' => ['attribute' => 'user_id', 'value' => 'userFullname', 'format' => 'raw', 'label' => 'User'],
            // 'concern_id' => ['attribute' => 'concern_id', 'format' => 'raw'],
            'name' => ['attribute' => 'name', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'inquiryId:raw',
            'userFullname:raw',
            'name:raw',
        ];
    }

    public static function addRecord($name='', $concern='', $identity='', $status=self::UNSOLVED)
    {
        if (App::isLogin()) {
            $identity = App::identity();
        }

        if ($identity) {
            $model = new self([
                'name' => $name,
                'user_id' => $identity->id,
                'status' => $status
            ]);

            if ($concern) {
                $model->concern_id = $concern->id;
                $model->name = $concern->name;
            }

            return $model->save();

        }
    }

    public static function addUnsolved($name='', $concern='', $identity='')
    {
        return self::addRecord($name, $concern, $identity, self::UNSOLVED);
    }


    public static function addSolved($name='', $concern='', $identity='')
    {
        return self::addRecord($name, $concern, $identity, self::SOLVED);
    }


    public static function unsolved()
    {
        return self::findAll(['status' => self::UNSOLVED]);
    }

    public static function top($status=null)
    {
        return self::find()
            ->select(['*', 'COUNT("*") AS total'])
            ->andFilterWhere(['status' => $status])
            ->groupBy('name')
            ->orderBy([
                'COUNT("*")' => SORT_DESC,
                'id' => SORT_DESC
            ])
            ->limit(5)
            ->all();
    }

    public static function topUnsolved()
    {
        return self::top(self::UNSOLVED);
    }

    public static function topSolved()
    {
        return self::top(self::SOLVED);
    }

    public function getIsCreatableConcern()
    {
        if (($concern = Concern::findOne(['name' => $this->name])) == null) {
            return true;
        }

        return false;
    }
}
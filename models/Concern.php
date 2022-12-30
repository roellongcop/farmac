<?php

namespace app\models;

use app\helpers\App;
use app\helpers\ArrayHelper;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%concerns}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $rules
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Concern extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%concerns}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'concern',
            'mainAttribute' => 'name',
            'paramName' => 'slug',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        $fields['totalRules'] = fn ($model) => $model->rules ? number_format(count($model->rules)): 0;

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['name'], 'required'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['rules', 'fallback_message'], 'safe']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'rules' => 'Rules',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ConcernQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ConcernQuery(get_called_class());
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'name',
            'description',
            'created_at',
            'last_updated',
            'active'
        ];
    }
     
    public function gridColumns()
    {
        return [
            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'description' => ['attribute' => 'description', 'format' => 'raw'],
            'rules' => ['attribute' => 'rules', 'format' => 'encode'],
        ];
    }

    public function getFormattedRules()
    {
        $arr = [];

        foreach ($this->rules as $rule) {
            $sub = [];
            if ($rule['sub'] ?? '') {
                $sub = array_values(ArrayHelper::map($rule['sub'], 'label', 'label'));
            }

            $arr[$rule['label']] = '('. implode(' | ', $sub) .')';
        }

        return $arr;
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'description:raw',
            [
                'label' => 'Rules',
                'format' => 'jsonEditor',
                'value' => fn ($model) => $model->formattedRules
            ]
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'rules', 
        ];
        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'name',
            'ensureUnique' => true,
        ];

        return $behaviors;
    }
}
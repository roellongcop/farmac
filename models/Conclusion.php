<?php

namespace app\models;

use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%conclusions}}".
 *
 * @property int $id
 * @property int $concern_id
 * @property string|null $conclusion
 * @property string|null $conditions
 * @property string|null $token
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Conclusion extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%conclusions}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'conclusion',
            'mainAttribute' => 'id',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['concern_id', 'conclusion', 'conditions'], 'required'],
            [['concern_id'], 'integer'],
            [['conclusion'], 'string'],
            [['conditions'], 'safe'],
            ['concern_id', 'exist', 'targetRelation' => 'concern'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'concern_id' => 'Concern',
            'conclusion' => 'Conclusion',
            'conditions' => 'Conditions',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ConclusionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ConclusionQuery(get_called_class());
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'conclusion',
            'concern_name',
            'created_at',
            'last_updated',
            'active'
        ];
    }

    public function getConcern()
    {
        return $this->hasOne(Concern::class, ['id' => 'concern_id']);
    }

    public function getConcernName()
    {
        return App::if($this->concern, fn ($concern) => $concern->name);
    }
     
     
    public function gridColumns()
    {
        return [
            'conclusion' => [
                'attribute' => 'conclusion', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->conclusion,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'concern_name' => [
                'attribute' => 'concernName', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->concernName,
                        'link' => App::if($model->concern, fn ($concern) => $concern->viewUrl),
                        'text' => true,
                        'options' => ['target' => '_blank']
                    ]);
                }
            ],
            'conditions' => ['attribute' => 'conditions', 'format' => 'encode'],
        ];
    }

    public function detailColumns()
    {
        return [
            'concernName:raw',
            'conclusion:raw',
            'conditions:jsonEditor',
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'conditions', 
        ];

        return $behaviors;
    }
}
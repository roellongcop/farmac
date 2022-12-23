<?php

namespace app\models;

use app\helpers\ArrayHelper;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $category
 * @property string $menu
 * @property string $title
 * @property string $photo
 * @property string|null $content
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends ActiveRecord
{
    const STEP_FORM = [
        [
            'counter' => 1,
            'state' => 'current',
            'step' => 'general',
            'title' => 'General Information',
            'description' => 'Fill up Primary Details'
        ],
        [
            'counter' => 2,
            'state' => 'pending',
            'step' => 'content',
            'title' => 'Content',
            'description' => 'Setup Article Content'
        ],
        [
            'counter' => 3,
            'state' => 'pending',
            'step' => 'sort',
            'title' => 'Content Sorting',
            'description' => 'Ordering Contents'
        ],
        [
            'counter' => 4,
            'state' => 'pending',
            'step' => 'completed',
            'title' => 'Completed',
            'description' => 'Review and Submit'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'article',
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
            [['parent_id', 'sort'], 'integer'],
            [['category', 'menu', 'title'], 'required'],
            [['content'], 'string'],
            [['category', 'menu', 'title', 'photo'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'category' => 'Category',
            'menu' => 'Menu',
            'title' => 'Title',
            'photo' => 'Photo',
            'content' => 'Content',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ArticleQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'parent_id' => [
                'attribute' => 'parent_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->parent_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'category' => ['attribute' => 'category', 'format' => 'raw'],
            'menu' => ['attribute' => 'menu', 'format' => 'raw'],
            'title' => ['attribute' => 'title', 'format' => 'raw'],
            'photo' => ['attribute' => 'photo', 'format' => 'raw'],
            'content' => ['attribute' => 'content', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'parent_id:raw',
            'category:raw',
            'menu:raw',
            'title:raw',
            'photo:raw',
            'content:raw',
        ];
    }

    public static function stepForms($step)
    {
        $stepForms = ArrayHelper::index(self::STEP_FORM, 'step');
        $activeStep = $stepForms[$step];

        foreach ($stepForms as &$stepForm) {
            if ($activeStep['counter'] == $stepForm['counter']) {
                $stepForm['state'] = 'current';
            }
            elseif ($activeStep['counter'] > $stepForm['counter']) {
                $stepForm['state'] = 'done';
            }
            elseif ($activeStep['counter'] < $stepForm['counter']) {
                $stepForm['state'] = 'pending';
            }
        }

        return $stepForms;
    }

    public function getPreviousStep($activeStep)
    {
        if ($activeStep['step'] == 'general') {
            return $activeStep;
        }

        $stepForms = ArrayHelper::index(self::STEP_FORM, 'counter');

        return $stepForms[$activeStep['counter'] - 1];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
       
        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'title',
            'ensureUnique' => true,
        ];

        return $behaviors;
    }

    public function getNewArticle()
    {
        return new self([
            'parent_id' => $this->id,
            'category' => $this->category,
            'menu' => $this->menu
        ]);
    }

    public function getContents()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }
}
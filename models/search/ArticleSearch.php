<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Article;
use app\helpers\App;

/**
 * ArticleSearch represents the model behind the search form of `app\models\Article`.
 */
class ArticleSearch extends Article
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'article/_search';
    public $searchAction = ['article/index'];
    public $searchLabel = 'Article';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'created_by', 'updated_by'], 'integer'],
            [['category', 'menu', 'title', 'photo', 'content', 'created_at', 'updated_at'], 'safe'],
            [['keywords', 'pagination', 'date_range', 'record_status'], 'safe'],
            [['keywords'], 'trim'],
        ];
    }

    public function init()
    {
        $this->pagination = App::setting('system')->pagination;
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return \yii\base\Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Article::find();

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'record_status' => $this->record_status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'menu', $this->menu])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'photo', $this->photo])
            ->andFilterWhere(['like', 'content', $this->content]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'parent_id', $this->keywords],  
            ['like', 'category', $this->keywords],  
            ['like', 'menu', $this->keywords],  
            ['like', 'title', $this->keywords],  
            ['like', 'photo', $this->keywords],  
            ['like', 'content', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}
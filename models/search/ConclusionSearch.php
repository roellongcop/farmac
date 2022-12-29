<?php

namespace app\models\search;

use yii\data\ActiveDataProvider;
use app\models\Conclusion;
use app\helpers\App;

/**
 * ConclusionSearch represents the model behind the search form of `app\models\Conclusion`.
 */
class ConclusionSearch extends Conclusion
{
    public $keywords;
    public $date_range;
    public $pagination;

    public $searchTemplate = 'conclusion/_search';
    public $searchAction = ['conclusion/index'];
    public $searchLabel = 'Conclusion';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'concern_id', 'created_by', 'updated_by'], 'integer'],
            [['conclusion', 'conditions', 'token', 'created_at', 'updated_at'], 'safe'],
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
        $query = Conclusion::find()
            ->alias('c')
            ->joinWith('concern cen')
            ->groupBy('c.id');

        // add conditions that should always apply here
        $this->load($params);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => [
                'pageSize' => $this->pagination
            ]
        ]);

        $dataProvider->sort->attributes['concernName'] = [
            'asc' => ['cen.name' => SORT_ASC],
            'desc' => ['cen.name' => SORT_DESC],
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'c.id' => $this->id,
            'c.concern_id' => $this->concern_id,
            'c.record_status' => $this->record_status,
            'c.created_by' => $this->created_by,
            'c.updated_by' => $this->updated_by,
            'c.created_at' => $this->created_at,
            'c.updated_at' => $this->updated_at,
        ]);
        
        $query->andFilterWhere(['like', 'c.conclusion', $this->conclusion])
            ->andFilterWhere(['like', 'c.conditions', $this->conditions])
            ->andFilterWhere(['like', 'c.token', $this->token]);
        
                
        $query->andFilterWhere(['or', 
            ['like', 'cen.name', $this->keywords],  
            ['like', 'c.conclusion', $this->keywords],  
            ['like', 'c.conditions', $this->keywords],  
        ]);

        $query->daterange($this->date_range);

        return $dataProvider;
    }
}
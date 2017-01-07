<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Movies;

/**
 * MoviesSearch represents the model behind the search form about `backend\models\Movies`.
 */
class MoviesSearch extends Movies
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'view_amount'], 'integer'],
            [['title', 'description', 'poster_small', 'poster_big', 'episode_shot', 'poster_left', 'poster_middle', 'poster_right', 'gradient_start_color', 'gradient_end_color', 'type', 'level', 'duration', 'issue_date', 'src', 'trailer_src', 'ted_original', 'subtitle', 'add_datetime', 'is_blocked', 'is_deleted'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Movies::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'issue_date' => $this->issue_date,
            'add_datetime' => $this->add_datetime,
            'view_amount' => $this->view_amount,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'poster_small', $this->poster_small])
            ->andFilterWhere(['like', 'poster_big', $this->poster_big])
            ->andFilterWhere(['like', 'episode_shot', $this->episode_shot])
            ->andFilterWhere(['like', 'poster_left', $this->poster_left])
            ->andFilterWhere(['like', 'poster_middle', $this->poster_middle])
            ->andFilterWhere(['like', 'poster_right', $this->poster_right])
            ->andFilterWhere(['like', 'gradient_start_color', $this->gradient_start_color])
            ->andFilterWhere(['like', 'gradient_end_color', $this->gradient_end_color])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'duration', $this->duration])
            ->andFilterWhere(['like', 'src', $this->src])
            ->andFilterWhere(['like', 'trailer_src', $this->trailer_src])
            ->andFilterWhere(['like', 'ted_original', $this->ted_original])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'is_blocked', $this->is_blocked])
            ->andFilterWhere(['like', 'is_deleted', $this->is_deleted]);

        return $dataProvider;
    }
}

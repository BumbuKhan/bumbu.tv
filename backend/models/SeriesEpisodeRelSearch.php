<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\SeriesEpisodeRel;

/**
 * SeriesEpisodeRelSearch represents the model behind the search form about `backend\models\SeriesEpisodeRel`.
 */
class SeriesEpisodeRelSearch extends SeriesEpisodeRel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'season', 'episode'], 'integer'],
            [['movie_id', 'episode_id'], 'safe']
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
        $query = SeriesEpisodeRel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith('movie');
        $query->joinWith('episode0 m');

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'season' => $this->season,
            'episode' => $this->episode,
        ])
            ->andFilterWhere(['like', 'movies.title', $this->movie_id])
            ->andFilterWhere(['like', 'm.title', $this->episode_id])
        ;

        return $dataProvider;
    }
}

<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Recommendations;

/**
 * RecommendationsSearch represents the model behind the search form about `app\modules\v1\models\Recommendations`.
 */
class RecommendationsSearch extends Recommendations
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'kindid', 'created_at'], 'integer'],
            [['title', 'location', 'sellerphone', 'reason', 'pictures'], 'safe'],
            [['longitude', 'latitude'], 'number'],
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
        $query = Recommendations::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'kindid' => $this->kindid,
            'created_at' => $this->created_at,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'sellerphone', $this->sellerphone])
            ->andFilterWhere(['like', 'reason', $this->reason])
            ->andFilterWhere(['like', 'pictures', $this->pictures]);

        return $dataProvider;
    }
}

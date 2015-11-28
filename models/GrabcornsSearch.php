<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Grabcorns;

/**
 * GrabcornsSearch represents the model behind the search form about `app\modules\v1\models\Grabcorns`.
 */
class GrabcornsSearch extends Grabcorns
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'needed', 'remain', 'created_at', 'date', 'end_at', 'islotteried', 'winneruserid', 'winnerrecordid', 'winnernumber', 'foruser', 'kind', 'worth'], 'integer'],
            [['picture', 'title', 'version', 'pictures'], 'safe'],
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
        $query = Grabcorns::find();

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
            'needed' => $this->needed,
            'remain' => $this->remain,
            'created_at' => $this->created_at,
            'date' => $this->date,
            'end_at' => $this->end_at,
            'islotteried' => $this->islotteried,
            'winneruserid' => $this->winneruserid,
            'winnerrecordid' => $this->winnerrecordid,
            'winnernumber' => $this->winnernumber,
            'foruser' => $this->foruser,
            'kind' => $this->kind,
            'worth' => $this->worth,
        ]);

        $query->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'pictures', $this->pictures]);

        return $dataProvider;
    }
}

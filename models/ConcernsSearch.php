<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Concerns;

/**
 * ConcernsSearch represents the model behind the search form about `app\modules\v1\models\Concerns`.
 */
class ConcernsSearch extends Concerns
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'myid', 'concernid', 'created_at'], 'integer'],
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
        $query = Concerns::find();

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
            'myid' => $this->myid,
            'concernid' => $this->concernid,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}

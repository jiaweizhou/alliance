<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Friends;

/**
 * FriendsSearch represents the model behind the search form about `app\modules\v1\models\Friends`.
 */
class FriendsSearch extends Friends
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'myid', 'friendid', 'created_at'], 'integer'],
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
        $query = Friends::find();

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
            'friendid' => $this->friendid,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}

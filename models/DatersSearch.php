<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Daters;

/**
 * DatersSearch represents the model behind the search form about `app\modules\v1\models\Daters`.
 */
class DatersSearch extends Daters
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'sex', 'age', 'hobbyid', 'created_at'], 'integer'],
            [['picture', 'content'], 'safe'],
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
        $query = Daters::find();

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
            'sex' => $this->sex,
            'age' => $this->age,
            'hobbyid' => $this->hobbyid,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}

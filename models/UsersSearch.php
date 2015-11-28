<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\v1\models\Users;

/**
 * UsersSearch represents the model behind the search form about `app\modules\v1\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'directalliancecount', 'allalliancecount', 'corns', 'money', 'envelope', 'cornsforgrab', 'alliancerewards', 'gender', 'created_at', 'updated_at', 'friendcount', 'concerncount', 'isdraw'], 'integer'],
            [['phone', 'pwd', 'authKey', 'fatherid', 'nickname', 'thumb', 'area', 'job', 'hobby', 'signature', 'channel', 'platform'], 'safe'],
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
        $query = Users::find();

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
            'directalliancecount' => $this->directalliancecount,
            'allalliancecount' => $this->allalliancecount,
            'corns' => $this->corns,
            'money' => $this->money,
            'envelope' => $this->envelope,
            'cornsforgrab' => $this->cornsforgrab,
            'alliancerewards' => $this->alliancerewards,
            'gender' => $this->gender,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'friendcount' => $this->friendcount,
            'concerncount' => $this->concerncount,
            'isdraw' => $this->isdraw,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'pwd', $this->pwd])
            ->andFilterWhere(['like', 'authKey', $this->authKey])
            ->andFilterWhere(['like', 'fatherid', $this->fatherid])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'job', $this->job])
            ->andFilterWhere(['like', 'hobby', $this->hobby])
            ->andFilterWhere(['like', 'signature', $this->signature])
            ->andFilterWhere(['like', 'channel', $this->channel])
            ->andFilterWhere(['like', 'platform', $this->platform]);

        return $dataProvider;
    }
}

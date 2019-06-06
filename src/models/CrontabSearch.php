<?php

namespace wowthink\crond\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use wowthink\crond\models\Crontab;

/**
 * CrontabSearch represents the model behind the search form of `wowthink\crond\models\Crontab`.
 */
class CrontabSearch extends Crontab
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['crontab_id', 'switch', 'status', 'last_time', 'next_time'], 'integer'],
            [['name', 'route', 'crontab_str'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Crontab::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['crontab_id'=> SORT_ASC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
             $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'crontab_id' => $this->crontab_id,
            'switch' => $this->switch,
            'status' => $this->status,
            'last_time' => $this->last_time,
            'next_time' => $this->next_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'route', $this->route]);

        return $dataProvider;
    }

}

<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Group;

/**
 * GroupSearch represents the model behind the search form about `common\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @inheritdoc
     */
    public $specialityName;


    public function rules()
    {
        return [
            [['id', 'speciality_id', 'steward_student_id'], 'integer'],
            [['name','specialityName','speciality_id'], 'safe'],
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
        $query = Group::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10,],
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'specialityName' => [
                    'asc' => ['speciality.name' => SORT_ASC],
                    'desc' => ['speciality.name' => SORT_DESC],
                ],   
                'group.name',
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'speciality_id' => $this->speciality_id,
            'steward_student_id' => $this->steward_student_id,
        ]);

        $query->andFilterWhere(['like', 'group.name', $this->name]);

        $query->joinWith(['speciality' => function($q){
            $q->where('speciality.name LIKE "%'.$this->specialityName.'%"');
        }]);
        
        return $dataProvider;
    }
}

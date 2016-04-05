<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Student;

/**
 * StudentSearch represents the model behind the search form about `common\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * @inheritdoc
     */
    public $fullname;
    public $groupName;


    public function rules()
    {
        return [
            [['id', 'user_id', 'group_id'], 'integer'],
            [['education_start_date', 'education_end_date','fullname','groupName'], 'safe'],
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
        $query = Student::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [                
                'fullname' => [
                    'asc' => ['user.last_name' => SORT_ASC],
                    'desc' => ['user.last_name' => SORT_DESC],                   
                ],  
                'groupName' => [
                    'asc' => ['group.name' => SORT_ASC],
                    'desc' => ['group.name' => SORT_DESC],                   
                ]
                
            ]
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
            'user_id' => $this->user_id,
            'group_id' => $this->group_id,
            'education_start_date' => $this->education_start_date,
            'education_end_date' => $this->education_end_date,
        ]);
        
        $query->joinWith(['user' => function($q){
            $q->where('user.first_name LIKE "%' . $this->fullname . '%" ' .
            'OR user.last_name LIKE "%' . $this->fullname . '%"'.
            'OR user.middle_name LIKE "%' . $this->fullname . '%"'
            );
        }]);
        $query->joinWith(['group' => function($q){
            $q->where('group.name LIKE "%' . $this->groupName . '%" ');            
        }]);

        return $dataProvider;
    }
}

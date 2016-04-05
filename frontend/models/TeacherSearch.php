<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Teacher;

/**
 * TeacherSearch represents the model behind the search form about `common\models\Teacher`.
 */
class TeacherSearch extends Teacher
{
    /**
     * @inheritdoc
     */
    
    public $fullname; 
    
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['post', 'academic_degree','fullname'], 'safe'],
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
        $query = Teacher::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'fullname' => [
                    'asc' => ['user.last_name' => SORT_ASC],
                    'desc' => ['user.last_name' => SORT_DESC],                   
                ],  
                'academic_degree',
                'post'
                
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
        ]);

        $query->andFilterWhere(['like', 'post', $this->post])
            ->andFilterWhere(['like', 'academic_degree', $this->academic_degree]);
        
        $query->joinWith(['user' => function ($q) {
                $q->where('user.first_name LIKE "%' . $this->fullname . '%" ' .
            'OR user.last_name LIKE "%' . $this->fullname . '%"'.
            'OR user.middle_name LIKE "%' . $this->fullname . '%"'
            );
       }]);

        return $dataProvider;
    }
}

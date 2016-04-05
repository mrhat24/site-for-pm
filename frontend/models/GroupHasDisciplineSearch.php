<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GroupHasDiscipline;

/**
 * GroupHasDisciplineSearch represents the model behind the search form about `common\models\GroupHasDiscipline`.
 */
class GroupHasDisciplineSearch extends GroupHasDiscipline
{
    
    public $semesterNumber;
    public $groupName;
    public $disciplineName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'discipline_id', 'group_id', 'semestr_number'], 'integer'],
            [['semesterNumber','groupName','disciplineName'],'safe'],
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
        $query = GroupHasDiscipline::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'semesterNumber' => [
                    'asc' => ['group_semesters.semester_number' => SORT_ASC],
                    'desc' => ['group_semesters.semester_number' => SORT_DESC],                    
                ],  
                'groupName' => [
                    'asc' => ['group.name' => SORT_ASC],
                    'desc' => ['group.namer' => SORT_DESC],                    
                ], 
                'disciplineName' => [
                    'asc' => ['discipline.name' => SORT_ASC],
                    'desc' => ['discipline.name' => SORT_DESC],
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
            'discipline_id' => $this->discipline_id,
            'group_id' => $this->group_id,
            'semestr_semester' => $this->semestr_number,
        ]);
        
        $query->joinWith(['semester' => function ($q) {
                $q->where('group_semesters.semester_number LIKE "%' . $this->semesterNumber . '%" ');
       }]);
       
       $query->joinWith(['group' => function ($q) {
                $q->where('group.name LIKE "%' . $this->groupName . '%" ');
       }]);
       
       $query->joinWith(['discipline' => function ($q) {
                $q->where('discipline.name LIKE "%' . $this->disciplineName . '%" ');
       }]);
        
        return $dataProvider;
    }
}
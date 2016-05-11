<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\TeacherHasDiscipline;

/**
 * TeacherHasDisciplineSearch represents the model behind the search form about `common\models\TeacherHasDiscipline`.
 */
class TeacherHasDisciplineSearch extends TeacherHasDiscipline
{
    public $disciplineName;
    public $groupName;
    public $semester;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'teacher_id', 'ghd_id', 'begin_date', 'end_date'], 'integer'],
            [['disciplineName','groupName','semester'],'safe'],
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
    public function search($params,$query2 = null)
    {
        $query = TeacherHasDiscipline::find();

        // add conditions that should always apply here
        if($query2)
            $query = $query2;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'groupName' => [
                    'asc' => ['groupHasDiscipline.group.name' => SORT_ASC],
                    'desc' => ['groupHasDiscipline.group.name' => SORT_DESC],                    
                ],  
                'disciplineName' => [
                    'asc' => ['groupHasDiscipline.discipline.name' => SORT_ASC],
                    'desc' => ['groupHasDiscipline.discipline.name' => SORT_DESC],
                ],
                'semester' => [
                    'asc' => ['groupHasDiscipline.semester_number' => SORT_ASC],
                    'desc' => ['groupHasDiscipline.semester_number' => SORT_DESC],
                ],
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
            'teacher_id' => $this->teacher_id,
            'ghd_id' => $this->ghd_id,
            'begin_date' => $this->begin_date,
            'end_date' => $this->end_date,
        ]);
        
        $query->joinWith('groupHasDiscipline')->joinWith(['groupHasDiscipline.discipline' => function ($q) {
                $q->where('discipline.name LIKE "%' . $this->disciplineName . '%" ');
        }]);
        
        $query->joinWith('groupHasDiscipline')->joinWith(['groupHasDiscipline.group' => function ($q) {
                $q->where('group.name LIKE "%' . $this->groupName . '%" ');
        }]);
        
        $query->joinWith(['groupHasDiscipline' => function ($q) {
                $q->where('group_has_discipline.semester_number LIKE "%' . $this->semester . '%" ');
        }]);
                
        return $dataProvider;
    }
}

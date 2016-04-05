<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Work;

/**
 * WorkSearch represents the model behind the search form about `common\models\Work`.
 */
class WorkSearch extends Work
{
    /**
     * @inheritdoc
     * 
     */
    public $studentFullname;
    public $groupName;    


    public function rules()
    {
        return [
            [['id', 'work_type_id', 'name', 'student_id', 'teacher_id', 'date', 'approve_status'], 'integer'],
            [['studentFullname','groupName'],'safe']
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
        $query = Work::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'studentFullname' => [
                    'asc' => ['user.last_name' => SORT_ASC],
                    'desc' => ['user.last_name' => SORT_DESC],
                    'label' => 'studentFullname'
                ],
                'groupName' => [
                    'asc' => ['student.group.name' => SORT_ASC],
                    'desc' => ['student.group.name' => SORT_DESC],
                    'label' => 'groupName'
                ],
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
            'work_type_id' => $this->work_type_id,
            'name' => $this->name,
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
            'date' => $this->date,
            'approve_status' => $this->approve_status,
        ]);
        
        $query->joinWith('teacher')->joinWith(['teacher.user' => function ($q) {
                $q->where('user.first_name LIKE "%' . $this->studentFullname . '%" ' .
            'OR user.last_name LIKE "%' . $this->studentFullname . '%"'.
            'OR user.middle_name LIKE "%' . $this->studentFullname . '%"'
            );
       }]);
        
        $query->joinWith('student')->joinWith(['student.group' => function ($q) {
                $q->where('group.name LIKE "%' . $this->groupName . '%" ');
       }]);
        
        return $dataProvider;
    }
}

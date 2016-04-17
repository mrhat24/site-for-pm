<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GivenTask;

/**
 * GivenTaskSearch represents the model behind the search form about `common\models\GivenTask`.
 */
class GivenTaskSearch extends GivenTask
{
    /*
     * var
     */
    public $teacherFullname;
    public $studentFullname;
    public $taskName;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'given_date', 'teacher_id', 'status', 'result', 'complete_date'], 'integer'],
            [['task_id', 'discipline_id', 'student_id', 'comment', 'group_key','teacherFullname','studentFullname','taskName'], 'safe'],
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
        $query = GivenTask::find()
                ->where(['given_task.teacher_id' => Yii::$app->user->identity->teacher->id]);
        
        //$query->joinWith('user');
        $query->joinWith('discipline');        
        $query->joinWith('task');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['status' => SORT_ASC, 'given_date' => SORT_DESC]]
        ]);
          
        $dataProvider->setSort([
            'attributes' => [                
                'teacherFullname' => [
                    'asc' => ['user.last_name' => SORT_ASC,'user.middle_name' => SORT_ASC,'user.first_name' => SORT_ASC],
                    'desc' => ['user.last_name' => SORT_DESC,'user.middle_name' => SORT_DESC,'user.first_name' => SORT_DESC],                   
                ],
                'id',
                'status'
                
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
            'given_task.given_date' => $this->given_date,            
            'given_task.teacher_id' => $this->teacher_id,
            //'task_id' => $this->task_id,            
            'given_task.status' => $this->status,
            'given_task.result' => $this->result,
            'given_task.complete_date' => $this->complete_date,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'group_key', $this->group_key])
            ->andFilterWhere(['like','discipline.name', $this->discipline_id])
            ->andFilterWhere(['like','task.name',$this->task_id]);
            //->andFilterWhere(['like','user.last_name',$this->student_id]);
        
        $query->joinWith(['task' => function($q){
            $q->where('task.name LIKE "%' . $this->taskName . '%" ');
        }]);
        
        $query->joinWith('student')->joinWith(['student.user as suser' => function($q){
            $q->where('suser.first_name LIKE "%' . $this->studentFullname . '%" ' .
            'OR suser.last_name LIKE "%' . $this->studentFullname . '%"'.
            'OR suser.middle_name LIKE "%' . $this->studentFullname . '%"'
            );
        }]);
        $query->joinWith('teacher')->joinWith(['teacher.user as tuser' => function($q){
            $q->where('tuser.first_name LIKE "%' . $this->teacherFullname . '%" ' .
            'OR tuser.last_name LIKE "%' . $this->teacherFullname . '%"'.
            'OR tuser.middle_name LIKE "%' . $this->teacherFullname . '%"'
            );
        }]);

        return $dataProvider;
    }
}

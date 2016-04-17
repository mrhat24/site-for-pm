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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'given_date', 'teacher_id', 'status', 'result', 'complete_date'], 'integer'],
            [['task_id', 'discipline_id', 'student_id', 'comment', 'group_key'], 'safe'],
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
        
        $query->joinWith('user');
        $query->joinWith('discipline');        
        $query->joinWith('task');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['status' => SORT_ASC, 'given_date' => SORT_DESC]]
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
        $query->andWhere('user.first_name LIKE "%' . $this->student_id . '%" ' .
        'OR user.last_name LIKE "%' . $this->student_id . '%"'.
        'OR user.middle_name LIKE "%' . $this->student_id . '%"'
    );   

        return $dataProvider;
    }
}

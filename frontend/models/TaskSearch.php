<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * TaskSearch represents the model behind the search form about `common\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'teacher_id'], 'integer'],
            [['name', 'text', 'type_id'], 'safe'],
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
        $query = Task::find()->where(['task.teacher_id' => Yii::$app->user->identity->teacher->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
             
        $query->joinWith('taskType');
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'teacher_id' => $this->teacher_id,
            //'type_id' => $this->type_id,
        ]);

        $query->andFilterWhere(['like', 'task.name', $this->name])
            ->andFilterWhere(['like', 'task.text', $this->text])
            ->andFilterWhere(['like', 'task_type.name', $this->type_id]);
        return $dataProvider;
    }
}

<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Exercise;

/**
 * ExerciseSearch represents the model behind the search form about `common\models\Exercise`.
 */
class ExerciseSearch extends Exercise
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'teacher_id'], 'integer'],
            [['text', 'name', 'subject_id'], 'safe'],
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
        $query = Exercise::find()->where(['exercise.teacher_id' => Yii::$app->user
                ->identity->teacher->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->joinWith('subject');
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'teacher_id' => $this->teacher_id,
            //'subject_id' => $this->subject_id,
        ]);

        $query->andFilterWhere(['like', 'exercise.text', $this->text])
            ->andFilterWhere(['like', 'exercise.name', $this->name])
            ->andFilterWhere(['like', 'exercise_subject.name', $this->subject_id]);

        return $dataProvider;
    }
}

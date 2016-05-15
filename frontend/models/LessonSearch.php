<?php

namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Lesson;
/**
* LessonSearch represents the model behind the search form about `common\models\Lesson`.
*/
class LessonSearch extends Lesson 
{ 
   /** 
    * @inheritdoc 
    */ 
   public $groupName;
   public $disciplineName;
   public $teacherFullname;
   public $lessonTypeName;

   public function rules() 
   { 
       return [ 
           [['id', 'ghd_id', 'lesson_type_id', 'week', 'day', 'date'], 'integer'], 
           [['time', 'auditory','groupName','disciplineName','teacherFullname','lessonTypeName'], 'safe'], 
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
       $query = Lesson::find(); 
 
       // add conditions that should always apply here 
 
       $dataProvider = new ActiveDataProvider([ 
           'query' => $query, 
       ]); 
 
       $dataProvider->setSort([
           'attributes' => [
                'id',
                'groupName' => [
                    'asc' => ['group.name' => SORT_ASC],
                    'desc' => ['group.name' => SORT_DESC],        
                    'label' => 'groupName'
                ],  
               'disciplineName' => [
                    'asc' => ['discipline.name' => SORT_ASC],
                    'desc' => ['discipline.name' => SORT_DESC],
                    'label' => 'disciplineName'
                ],
               'teacherFullname' => [
                    'asc' => ['user.last_name' => SORT_ASC,'user.first_name' => SORT_ASC,'user.middle_name' => SORT_ASC,],
                    'desc' => ['user.last_name' => SORT_DESC,'user.first_name' => SORT_DESC,'user.middle_name' => SORT_DESC,],
                    'label' => 'teacherFullname'
                ],
               'lessonTypeName' => [
                    'asc' => ['lesson_type.name' => SORT_ASC],
                    'desc' => ['lesson_type.name' => SORT_DESC],
                    'label' => 'lessonTypeName'
                ],  
               'week',
               'day',
               'time',
               'auditory'
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
           'ghd_id' => $this->ghd_id, 
           'lesson_type_id' => $this->lesson_type_id, 
           'teacher_id' => $this->teacher->id, 
           'week' => $this->week, 
           'day' => $this->day, 
           'time' => $this->time, 
           'date' => $this->date, 
       ]); 
 
       $query->andFilterWhere(['like', 'auditory', $this->auditory]); 
       
       $query->joinWith('groupHasDiscipline')->joinWith(['groupHasDiscipline.group' => function ($q) {
                $q->where('group.name LIKE "%' . $this->groupName . '%" ');
       }]);
       
       $query->joinWith('groupHasDiscipline')->joinWith(['groupHasDiscipline.discipline' => function ($q) {
                $q->where('discipline.name LIKE "%' . $this->disciplineName . '%" ');
       }]);
       
        $query->joinWith('teacherHasDiscipline')->joinWith('teacherHasDiscipline.teacher')->joinWith(['teacherHasDiscipline.teacher.user' => function ($q) {
                $q->where('user.first_name LIKE "%' . $this->teacherFullname . '%" ' .
            'OR user.last_name LIKE "%' . $this->teacherFullname . '%"'.
            'OR user.middle_name LIKE "%' . $this->teacherFullname . '%"'
            );
       }]);
       
       $query->joinWith(['lessonType' => function ($q) {
                $q->where('lesson_type.name LIKE "%' . $this->lessonTypeName . '%" ');
       }]);
       
       
       return $dataProvider; 
   } 
} 
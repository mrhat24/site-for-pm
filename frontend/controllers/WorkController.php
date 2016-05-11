<?php

namespace frontend\controllers;

use Yii;
use common\models\Work;
use frontend\models\WorkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\filters\AccessControl;
use common\models\Group;
/**
 * WorkController implements the CRUD actions for Work model.
 */
class WorkController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['index', 'view', 'create','update','graduate','term','teacher-graduate','delete'],
                'rules' => [
                    [   
                        'actions' =>  ['create','teacher-graduate','delete'],
                        'allow' => true,
                        'roles' => ['teacher'],
                    ],
                    [
                        'actions' =>  ['graduate','term','update','index','view'],
                        'allow' => true,
                        'roles' => ['student'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Work models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Work models.
     * @return mixed
     */
    public function actionTerm()
    {        
        $query = Work::find()->where(['work_type_id' => Work::TYPE_TERM,
            'student_id' => Yii::$app->user->identity->student->id])->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('term', [            
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Work models.
     * @return mixed
     */
    public function actionGraduate()
    {
        $model = Work::find()
                ->where(['student_id' => Yii::$app->user->identity->student->id])
                ->andWhere(['work_type_id' => Work::TYPE_GRADUATE])
                ->one();

        return $this->render('graduate', [
            'model' => $model ,
        ]);
    }    

    public function actionBeginGraduate()
    {
        if(Yii::$app->request->isAjax){
            $workModel = new Work();
            $workModel->scenario = Work::SCENARIO_GRADUATE;
            if((Yii::$app->request->post()))
            {
                $nowDate = date("U");
                $workHistory = new \common\models\WorkHistory();      
                if(isset(Yii::$app->request->post()['newWorkCheckbox'])&&
                        (Yii::$app->request->post()['newWorkCheckbox']==true)){
                   $teacher = Yii::$app->request->post()['newWorkTeacher'];
                   $stringName = Yii::$app->request->post()['newWorkName'];
                   $work_list_id = null;
                }
                else{
                    $workFromList = \common\models\WorkList::findOne(Yii::$app->request->post()['workList']);
                    $teacher = $workFromList->teacher_id;
                    $stringName = $workFromList->name;
                    $work_list_id = $workFromList->id;
                }
                    $workModel->work_type_id = 1;
                    $workModel->teacher_id = $teacher;
                    $workModel->student_id = Yii::$app->user->identity->student->id;
                    $workModel->date = $nowDate;
                    $workModel->reserved_id = $workFromList->id;
                    if($workModel->validate()){
                        $workModel->save();
                        $workHistory->work_id = $workModel->getPrimaryKey();
                        $workHistory->name = $stringName;
                        $workHistory->creation_date = $nowDate;
                        if($workHistory->save()){   
                            $workModel->name = $workHistory->getPrimaryKey();
                            $iterator = $workModel->name;
                            $workModel->save();
                            if(isset($workFromList)){
                            $workFromList->save();
                            }
                            return $this->redirect(['graduate']);   
                        }
                    }                                                         
            }
            $workList = \common\models\WorkList::find()->all();
            $teachers = \common\models\Teacher::find()->all();
            return $this->renderAjax('begin_graduate',
                    [
                        'workModel' => $workModel,
                        'workList' => $workList,
                        'teachers' => $teachers
                    ]);
        }else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionEditGraduate()
    {        
        $workModel = Work::find()
                ->where(['student_id' => Yii::$app->user->identity->student->id])
                ->andWhere(['work_type_id' => Work::TYPE_GRADUATE])
                ->one();
        if(Yii::$app->request->post()){
            $workModel->editGraduate(Yii::$app->request->post());
            return $this->redirect(['graduate']);
        } 
       
        $workList = \common\models\WorkList::find()->where(['teacher_id' => $workModel->teacher_id,'work_type_id' => Work::TYPE_GRADUATE])->all();
        $teachers = \common\models\Teacher::find()->all();
        return $this->renderAjax('edit_graduate',
                [
                    'workModel' => $workModel,
                    'workList' => $workList,
                    'teachers' => $teachers
                ]);
    }
    
    
    public function actionAssingTerm()
    {
        $model = new Work();
        $model2 = new \yii\base\DynamicModel(['group','discipline']);
        $model2->addRule(['student_id'], 'integer');
        $model->scenario = Work::SCENARIO_TERM;
        $model->work_type_id = 2;       
        $model->teacher_id = Yii::$app->user->identity->teacher->id;
        $model->date = date('U');
        if ($model->load(Yii::$app->request->post()) && $model->save())
            $this->redirect(['teacher-term']);
        return $this->renderAjax('assing_term',['model' => $model, 'model2' => $model2]);
    }
    
   /* public function actionGroupfromdiscipline()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $discipline = \common\models\GroupHasDiscipline::findOne($cat_id)->discipline_id;
                $ghd = \common\models\Discipline::find()->where(['id' => $discipline])->one()->groupHasDisciplines;
                $out = \yii\helpers\ArrayHelper::map($ghd,'group.id','group.name');
                $arr = array();
                foreach ($out as $key => $o){
                    $arr[$key]['id'] = $key;
                    $arr[$key]['name']= $o;
                }               
                echo Json::encode(['output'=>$arr, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }*/
    
    public function actionStudentfromghd()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $ghd = \common\models\GroupHasDiscipline::find()->where(['id' => $cat_id])->one();
                $students = $ghd->group->students;
                $out = \yii\helpers\ArrayHelper::map($students,'id','user.fullname');
                $arr = array();
                foreach ($out as $key => $o){
                    $arr[$key]['id'] = $key;
                    $arr[$key]['name']= $o;
                }           
                echo Json::encode(['output'=>$arr, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }
    
    public function actionStudentfromgroup()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $ghd = \common\models\Student::find()->where(['group_id' => $cat_id])->all();
                $out = \yii\helpers\ArrayHelper::map($ghd,'id','user.fullname');
                $arr = array();
                foreach ($out as $key => $o){
                    $arr[$key]['id'] = $key;
                    $arr[$key]['name']= $o;
                }           
                echo Json::encode(['output'=>$arr, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

        public function actionEditTerm($id)
    {                
       
        if($model = Work::find()->where(['id' => $id, 'student_id' => Yii::$app->user->identity->student->id])->one()){
            if(Yii::$app->request->post()){
                $model->editTerm(Yii::$app->request->post());
            }
            return $this->renderAjax('edit_term',['model' => $model]);
    
        }
        else 
            throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    /*
     * teacher graduate
     */
    public function actionTeacherGraduate()
    {  
        $searchModel = new WorkSearch((['teacher_id' => Yii::$app->user->identity->teacher->id,
            'work_type_id' => Work::TYPE_GRADUATE]));
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('teacher_graduate',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel]);
    }
    
    public function actionTeacherTerm()
    {
        $searchModel = new WorkSearch((['teacher_id' => Yii::$app->user->identity->teacher->id,
            'work_type_id' => Work::TYPE_TERM]));//->find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('teacher_term',[
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel]);
    }

    /**
     * Displays a single Work model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Work model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Work();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionTermCreateGroup($group = null, $discipline = null)
    {
        if(($group)&&($discipline)&&(Yii::$app->user->can('teacher'))){                        
            if(Yii::$app->user->identity->teacher->isTeacherHasDiscipline($discipline)){
                $groupModel = Group::findOne($group);
                $disciplineModel = \common\models\GroupHasDiscipline::findOne($discipline);
                $errors = false;
                foreach($groupModel->students as $student){
                    $model = new Work();
                    $model->scenario = Work::SCENARIO_TERM;
                    $model->ghd_id = $disciplineModel->discipline_id;
                    $model->student_id = $student->id;
                    $model->teacher_id = Yii::$app->user->identity->teacher->id;
                    $model->work_type_id = Work::TYPE_TERM;
                    if($model->validate()){
                        $model->save(); 
                        $model->id = $model->getPrimaryKey();
                    }
                    else{
                        $errors = true;                        
                    }
                }
                if(!$errors)
                    return 'Создано';
                else 
                    return 'Произошла ошибка';
            }
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    


    /**
     * Updates an existing Work model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Work model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }
    
    
    /**     
     * @delete graduate
     */
    public function actionDeleteGraduate($id)
    {
        if(Work::find()->where(['id' => $id,'student_id' => Yii::$app->user->identity->student->id])->count())
            $this->findModel($id)->delete();
        return $this->redirect(['graduate']);
    }
    
    public function actionSendGraduate()
    {
        if(Work::changeStatus(Yii::$app->user->identity->student->id,
                Work::STATUS_SENDED,
                Work::TYPE_GRADUATE))
            return $this->redirect(['graduate']); 
        
    }
    /**
     * Finds the Work model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Work the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Work::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    
}

<?php

namespace frontend\controllers;

use Yii;
use common\models\Task;
use frontend\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\GivenTask;
use yii\web\ForbiddenHttpException;
use common\models\GivenExercise;
use kartik\mpdf;
/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['index', 'view', 'create','update','taken'],
                'rules' => [
                    [   
                        'actions' =>  ['create','update','give','control','given-list'],
                        'allow' => true,
                        'roles' => ['teacher'],
                    ],
                    [
                        'actions' =>  ['taken', 'view', 'index','complete-task'],
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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
   

    /**
     * Displays a single Task model.
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
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Task();
        $model->teacher_id = Yii::$app->user->identity->teacher->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['control']); 
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    
    
    
    public function actionListbytype($id)
    {
        $tasks = Task::find()->where(['type_id' => $id])->andWhere(['teacher_id' => Yii::$app->user->identity->teacher->id])->all();
        return $this->renderAjax('_listbytype',['tasks' => $tasks]);
    }
        
    public function actionGivepreview($id)
    {
        $task = Task::find()->where(['id' => $id])->one();
        return $this->renderAjax('_givepreview',['task' => $task]);
    }
    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['control']); 
    }
    
    /**
     * @task control
     */
    
    public function actionControl()
    {
        $searchModel = new TaskSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->get());        
        return $this->render('control',['dataProvider' => $dataProvider, 
            'searchModel' => $searchModel]);
    }
    
    public function actionExersicespreview($list)
    {
        $list = GivenTask::listToArray($list);
        $exersices = \common\models\Exercise::findAll($list);
        return $this->renderAjax('_exersicespreview',['exersices' => $exersices]);
    }
    
    /**
     * @task control
     */
    
    public function actionGivenList()
    {
        $gTask = GivenTask::find()->where(['teacher_id' => Yii::$app->user->identity->teacher->id])
                //->joinWith('completeTask')
                ->orderBy('status ASC, given_date DESC');                
        
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $gTask,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('given_task_list',['dataProvider' => $dataProvider]);
    }
    
     /**
     * @task control
     */
    
    public function actionCompleteTask($id)
    {        
        
       // $this->checkCompleteTask($id);
        return $this->renderAjax('_complete_task',['result' => $this->CTask($id)]);   
    }
    
    
    public function CTask($id)
    {
        $gtask = GivenTask::findOne($id);
        if(!GivenExercise::find()->where(['given_task_id' => $gtask->id])->andWhere(['solution' => ''])->all()){
        $gtask->status = 1;
        $gtask->save();
        return false;
        }                
        return true;
    }

    /**
     * @taken tasks
     */
    public function actionTaken($id = NULL)
    {
        if(Yii::$app->request->isAjax)
        {
            $takenTask = GivenTask::find($id)->one();             
            if(isset(Yii::$app->request->post()['close'])){
                return $this->render('taken_task', ['takenTask' => $takenTask, 'openform' => false]);                
            }
            elseif(isset(Yii::$app->request->post()['submit'])){
                $cEx = new \common\models\CompleteExercise();
                $cEx->text = Yii::$app->request->post()['textarea'];
                $cEx->save();
                return $this->render('taken_task', ['takenTask' => $takenTask, 'complete' => true]);
            } 
            else{
                return $this->render('taken_task', ['takenTask' => $takenTask, 'openform' => true]);
            }
        }
        if(($id == NULL)||(!GivenTask::findOne($id))){
            $gTask = GivenTask::find()->where(['student_id' => Yii::$app->user->identity->student->id])
                //->joinWith('completeTask')->//where(['>=', 'complete_task.status', 1])->
               ->orderBy('status ASC, given_date DESC');                
        
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $gTask,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            $takenTasks = GivenTask::find()->where(['student_id' => Yii::$app->user->identity->student->id])->orderBy('id DESC')->all();
        return $this->render('taken_tasks_list', ['dataProvider' => $dataProvider]);         
        }
        else{
            $takenTask = GivenTask::findOne($id);            
            if($takenTask->student_id != Yii::$app->user->identity->student->id)
              throw new ForbiddenHttpException('У вас нет доступа к этому заданию.');
            return $this->render('taken_task', ['takenTask' => $takenTask]);
        }
    }  
    
    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModel($id)
    {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}

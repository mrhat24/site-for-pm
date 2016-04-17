<?php
namespace frontend\controllers;
 
use Yii;
use common\models\Exercise;
use common\models\GivenTask;
use frontend\models\ExerciseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
* ExerciseController implements the CRUD actions for Exercise model.
*/
class ExerciseController extends Controller
{
   public function behaviors() 
   { 
       return [ 
           'access' => [
                'class' => AccessControl::className(),                
                'only' => ['control','exersicelistbytype', 'view', 'create','update','delete'],
                'rules' => [
                    [   
                        'actions' =>  ['control','exersicelistbytype', 'view', 'create','update','delete'],
                        'allow' => true,
                        'roles' => ['teacher'],
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
    * Lists all Exercise models. 
    * @return mixed 
    */ 
   public function actionControl()
   {
       $searchModel = new ExerciseSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       return $this->render('control', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
       ]);
   }
   
   public function actionExersicelistbytype($id)
    {
        $arr = GivenTask::listToArray($id);
        $exersices = Exercise::find()->where(['subject_id' => $arr])->all();
        return $this->renderAjax('_exersicelistbytype',['exersices' => $exersices]);
    }
    
   /** 
    * Displays a single Exercise model. 
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
    * Creates a new Exercise model. 
    * If creation is successful, the browser will be redirected to the 'view' page. 
    * @return mixed 
    */ 
   public function actionCreate() 
   { 
       $model = new Exercise(); 
 
       if ($model->load(Yii::$app->request->post()) && $model->save()) { 
           return $this->redirect(['control']); 
       } else { 
           return $this->renderAjax('create', [ 
               'model' => $model, 
           ]); 
       } 
   } 
 
   /** 
    * Updates an existing Exercise model. 
    * If update is successful, the browser will be redirected to the 'view' page. 
    * @param integer $id 
    * @return mixed 
    */ 
   public function actionUpdate($id) 
   { 
       $model = $this->findModel($id); 
 
       if ($model->load(Yii::$app->request->post()) && $model->save()) { 
           return $this->redirect(['control']); 
       } else { 
           return $this->renderAjax('update', [ 
               'model' => $model, 
           ]); 
       } 
   } 
 
   /** 
    * Deletes an existing Exercise model. 
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
    * Finds the Exercise model based on its primary key value. 
    * If the model is not found, a 404 HTTP exception will be thrown. 
    * @param integer $id 
    * @return Exercise the loaded model 
    * @throws NotFoundHttpException if the model cannot be found 
    */ 
   protected function findModel($id) 
   { 
       if (($model = Exercise::findOne($id)) !== null) { 
           return $model; 
       } else { 
           throw new NotFoundHttpException('The requested page does not exist.'); 
       } 
   } 
}
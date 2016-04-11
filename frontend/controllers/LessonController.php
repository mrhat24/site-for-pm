<?php

namespace frontend\controllers;

use Yii;
use common\models\Lesson;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\LessonSearch;
/**
 * LessonController implements the CRUD actions for Lesson model.
 */
class LessonController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['teacher', 'index', 'group','archive','create','update','view','delete'],
                'rules' => [
                    [
                        'actions' => ['teacher','index','group','archive'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                    [
                        'actions' => ['create','update','delete','view'],
                        'allow' => true,
                        'roles' => ['chief'],
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
     * Lists all Lesson models.
     * @return mixed
     */
    public function actionIndex()
    {              
        if(isset(Yii::$app->request->get()['group'])){
           $group = Yii::$app->request->get()['group'];
            return $this->render('group', [
                'group' => $group]);            
        };
        
        if(isset(Yii::$app->request->get()['teacher'])){
            $teacher = Yii::$app->request->get()['teacher'];
            return $this->render('teacher', [
                'teacher' => $teacher]); 
        };
        $teachers = \common\models\Teacher::find()->all();
        $groups = \common\models\Group::find()->all();
        $teacherRequest = null;
        $groupRequest = null;
        if(Yii::$app->request->isAjax){
            //$teacher = Yii::$app->request->post()['teacher_name'];
            if(isset(Yii::$app->request->post()['teacher_fullname'])){
            $searchTeacher = new \frontend\models\TeacherSearch();
            $teacherRequest = Yii::$app->request->post()['teacher_fullname'];
            $dataProviderTeacher = $searchTeacher->search(['TeacherSearch' => ['fullname' => $teacherRequest]]);            
            $teachers = $dataProviderTeacher->getModels();
            }
            if(isset(Yii::$app->request->post()['group_name'])){
            $searchGroup = new \frontend\models\GroupSearch();
            $groupRequest = Yii::$app->request->post()['group_name'];
            $dataProviderGroup = $searchGroup->search(['GroupSearch' => ['name' => $groupRequest]]);
            $groups = $dataProviderGroup->getModels();
            }
            
            
            //$teachers = json_encode();
            //return $this->render('index',['teachers' => $teachers, 'groups' => $groups]);
        }        
        return $this->render('index',
    [   
        'teachers' => $teachers,
        'groups' => $groups,
        'teacherRequest' => $teacherRequest,
        'groupRequest' => $groupRequest,
    ]);
    }
    
    public function actionArchive($group = null, $semester = null)
    {
        if(($group==null)||($semester==null))
            throw new NotFoundHttpException('The requested page does not exist.');               
       return $this->render('archive', [           
           'group' => $group, 'semester' => $semester
       ]);       
    }
    
    public function actionManage()
    {
        $searchModel = new LessonSearch();
       $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       return $this->render('manage', [
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
       ]);       
    }

    /**
     * Displays a single Lesson model.
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
     * Creates a new Lesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing Lesson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Lesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['manage']);
    }

    /**
     * Finds the Lesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

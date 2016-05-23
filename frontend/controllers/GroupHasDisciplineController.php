<?php

namespace frontend\controllers;

use Yii;
use common\models\GroupHasDiscipline;
use yii\data\ActiveDataProvider;
use frontend\models\GroupHasDisciplineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use common\models\TeacherHasDiscipline;
/**
 * GroupHasDisciplineController implements the CRUD actions for GroupHasDiscipline model.
 */
class GroupHasDisciplineController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['manage','index', 'view', 'create','update','delete'],
                'rules' => [
                    [   
                        'actions' =>  ['manage','view', 'create','update','delete'],
                        'allow' => true,
                        'roles' => ['chief'],
                    ],    
                    [   
                        'actions' =>  ['index'],
                        'allow' => true,
                        'roles' => ['student'],
                    ],  
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all GroupHasDiscipline models.
     * @return mixed
     */
    public function actionIndex($id)
    {        
        $model = GroupHasDiscipline::findOne($id);        

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * manage GroupHasDiscipline models.
     * @return mixed
     */
    public function actionManage()
    {
        $searchModel = new GroupHasDisciplineSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('manage', [
            'searchModel' => $searchModel, 
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionSemlist($id)
    {
        $arr = \common\models\GroupSemesters::find()->where(['group_id' => $id])->all();
        return $this->renderAjax('semlist',['arr' => $arr]);
    }

        /**
     * Displays a single GroupHasDiscipline model.
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
     * Creates a new GroupHasDiscipline model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GroupHasDiscipline();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //\common\models\TeacherHasDiscipline::find()->where('ghd_id' => '')
            foreach(Yii::$app->request->post()['GroupHasDiscipline']['teacherHasDiscipline']['teacher_id'] as $teacher){
                $modelTHD = new TeacherHasDiscipline();
                $modelTHD->teacher_id = $teacher;
                $modelTHD->ghd_id = $model->getPrimaryKey();
                $modelTHD->save();
            }   
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,                
            ]);
        }
    }
    
    public function actionSemesters(){
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $cat_id = $parents[0];
                $semesters = \common\models\GroupSemesters::find()->where(['group_id' => $cat_id])->all();
                foreach ($semesters as $sem){
                    $out[] = ['id' => $sem->semester_number, 'name' => 
                        $sem->semester_number." - (".Yii::$app->formatter->asDate($sem->begin_date)
                            .":".Yii::$app->formatter->asDate($sem->end_date).")"];
                }                 
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                //    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                //    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    /**
     * Updates an existing GroupHasDiscipline model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            foreach(Yii::$app->request->post()['GroupHasDiscipline']['teacherHasDiscipline']['teacher_id'] as $teacher){
                if(!TeacherHasDiscipline::find()->where(['ghd_id' => $model->id])->andWhere(['teacher_id' => $teacher])->count()){
                    $modelTHD = new TeacherHasDiscipline();
                    $modelTHD->teacher_id = $teacher;
                    $modelTHD->ghd_id = $model->id;
                    $modelTHD->save();
                }                                
            }   
            $thd_old = TeacherHasDiscipline::find()
                ->where(['ghd_id' => $model->id])
                ->andWhere(['not in','teacher_id',Yii::$app->request->post()['GroupHasDiscipline']['teacherHasDiscipline']['teacher_id']])
                ->all();
            foreach($thd_old as $thd){
                $thd->delete();
            }
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
    
     public function actionUpdateInfo($id)
    {
        $model = $this->findModel($id);
        if(!Yii::$app->user->can('teacher')){
            return 'У вас недостаточно прав!';
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'Обновлено';
        } else {
            return $this->renderAjax('_update_info', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GroupHasDiscipline model.
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
     * Finds the GroupHasDiscipline model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GroupHasDiscipline the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GroupHasDiscipline::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

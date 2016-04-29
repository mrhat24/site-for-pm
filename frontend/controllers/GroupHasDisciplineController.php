<?php

namespace frontend\controllers;

use Yii;
use common\models\GroupHasDiscipline;
use yii\data\ActiveDataProvider;
use frontend\models\GroupHasDisciplineSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


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
                        'actions' =>  ['manage','index', 'view', 'create','update','delete'],
                        'allow' => true,
                        'roles' => ['chief'],
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
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => GroupHasDiscipline::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
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
        $tModel = new \common\models\TeacherHasDiscipline();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return '2';
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
                'tModel' => $tModel,
            ]);
        }
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
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('update', [
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

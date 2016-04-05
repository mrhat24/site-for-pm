<?php

namespace frontend\controllers;

use Yii;
use common\models\TaskType;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * TaskTypeController implements the CRUD actions for TaskType model.
 */
class TaskTypeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['index', 'view', 'create','update','delete'],
                'rules' => [
                    [
                        'actions' =>  ['index', 'view', 'create','update','delete'],
                        'allow' => true,
                        'roles' => ['teacher'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TaskType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => TaskType::find()
                ->where(['teacher_id' => Yii::$app->user->identity->teacher->id]),
        ]);

        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskType model.
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
     * Creates a new TaskType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskType();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dataProvider = new ActiveDataProvider([
            'query' => TaskType::find()
                    ->where(['teacher_id' => Yii::$app->user->identity->teacher->id]),
            ]);

            return $this->renderAjax('index', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing TaskType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $dataProvider = new ActiveDataProvider([
            'query' => TaskType::find()
                ->where(['teacher_id' => Yii::$app->user->identity->teacher->id]),
            ]);

            return $this->renderAjax('index', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TaskType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())        
        {
            $dataProvider = new ActiveDataProvider([
            'query' => TaskType::find()
                    ->where(['teacher_id' => Yii::$app->user->identity->teacher->id]),
        ]);

        return $this->renderAjax('index', [
            'dataProvider' => $dataProvider,
        ]);
        }
    }

    /**
     * Finds the TaskType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

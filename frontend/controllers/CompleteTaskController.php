<?php

namespace frontend\controllers;

use Yii;
use common\models\CompleteTask;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\CompleteExercise;
use yii\base\Model;
/**
 * CompleteTaskController implements the CRUD actions for CompleteTask model.
 */
class CompleteTaskController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all CompleteTask models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CompleteTask::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompleteTask model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CompleteTask model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CompleteTask();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    
    /**
     * 
     */
    public function actionCheck($id)
    {   
        $model = $this->findModel($id);
        $givenTask = $model->givenTask;
        if ($model->load(Yii::$app->request->post()) && $model->save() && $givenTask->load(Yii::$app->request->post()) && $givenTask->save()) {
           // return $this->redirect(['view', 'id' => $givenTask->status]);            
        }
        
        $exersices_all = CompleteExercise::find()->indexBy('id')->all();

        if (Model::loadMultiple($exersices_all, Yii::$app->request->post()) && Model::validateMultiple($exersices_all)) {
            foreach ($exersices_all as $exersice) {
                if($givenTask->status == 3)
                    $exersice->remake = 0;
                $exersice->save(false);
            }
            return $this->redirect('given-list');
        }
        
        $model = CompleteTask::findOne($id);
        $exersices = $model->completeExersices;
        return $this->renderAjax('_check_form', ['model' => $model,'exersices' => $exersices ,'givenTask' => $givenTask]);
    }      
    /**
     * Updates an existing CompleteTask model.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CompleteTask model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CompleteTask model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompleteTask the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompleteTask::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

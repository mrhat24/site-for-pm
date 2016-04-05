<?php

namespace frontend\controllers;

use Yii;
use common\models\CompleteExercise;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompleteExerciseController implements the CRUD actions for CompleteExercise model.
 */
class CompleteExerciseController extends Controller
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
     * Lists all CompleteExercise models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CompleteExercise::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CompleteExercise model.
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
     * Creates a new CompleteExercise model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionEdit($id = null, $gid = null)
    {
        
        if(Yii::$app->request->isAjax){
            if($model = $this->findModelByExercise($id, $gid)){
                
            }
            else{
                $model = new CompleteExercise();
                $model->exercise_id = $id;
                $model->given_task_id = $gid;
            }    
            $date = new \DateTime();
            $model->date = $date->getTimestamp();
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['task/taken', 'id' => $gid] );
        }
        //$exercise = \common\models\Exercise::findOne($id);
        return $this->renderAjax('edit',
            ['model' => $model]
                );
        }        
    }

    /**
     * Updates an existing CompleteExercise model.
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
     * Deletes an existing CompleteExercise model.
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
     * Finds the CompleteExercise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CompleteExercise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CompleteExercise::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelByExercise($id,$gid)
    {
        if (($model = CompleteExercise::find()->where(['exercise_id' => $id])->andWhere(['given_task_id' => $gid])->one()) !== null) {
            return $model;
        } else {
            return false;
        }
    }
}

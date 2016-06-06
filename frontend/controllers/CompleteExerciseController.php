<?php

namespace frontend\controllers;

use Yii;
use common\models\CompleteExercise;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class CompleteExerciseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['index', 'view', 'edit','update','delete'],
                'rules' => [
                    [   
                        'actions' =>  ['index', 'view', 'edit','update','delete'],
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CompleteExercise::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

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

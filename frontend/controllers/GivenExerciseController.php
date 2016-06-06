<?php

namespace frontend\controllers;

use Yii;
use common\models\GivenExercise;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\GivenExerciseTestAnswers;
/**
 * GivenExerciseController implements the CRUD actions for GivenExercise model.
 */
class GivenExerciseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['index','edit', 'view', 'create','update','delete'],
                'rules' => [
                    [   
                        'actions' =>  ['index','edit', 'view', 'create','update','delete'],
                        'allow' => true,
                        'roles' => ['teacher'],
                    ], 
                    [   
                        'actions' =>  ['edit'],
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
     * Lists all GivenExercise models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => GivenExercise::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionEdit($id = null, $gid = null)
    {
        $model = $this->findModel($id);
        if(isset(Yii::$app->request->post()['answers']))
            $model->checkAndSetAnswers(Yii::$app->request->post()['answers']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {            
            
            return $this->redirect(['given-task/taken-view', 'id' => $gid] );
        }
        return $this->renderAjax('edit',
            ['model' => $model]
                );
        
    
    }
    
    /**
     * Displays a single GivenExercise model.
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
     * Creates a new GivenExercise model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GivenExercise();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GivenExercise model.
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
     * Deletes an existing GivenExercise model.
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
     * Finds the GivenExercise model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GivenExercise the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GivenExercise::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelByExercise($id,$gid)
    {
        if (($model = GivenExercise::find()->where(['exercise_id' => $id])->andWhere(['given_task_id' => $gid])->one()) !== null) {
            return $model;
        } else {
            return false;
        }
    }
}

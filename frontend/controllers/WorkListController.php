<?php

namespace frontend\controllers;

use Yii;
use common\models\WorkList;
use frontend\models\WorkListSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Work;

/**
 * WorkListController implements the CRUD actions for WorkList model.
 */
class WorkListController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    
                ],
            ],
        ];
    }

    /**
     * Lists all WorkList models.
     * @return mixed
     */
    public function actionIndex($type = null)
    {
        if(($type != null)&&isset(Yii::$app->user->identity->teacher)){
            $teacher = Yii::$app->user->identity->teacher->id;
            $searchModel = new WorkListSearch();
            $query =  WorkList::find()->where(['work_type_id' => $type,'teacher_id' => $teacher]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $query);

            return $this->renderAjax('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'type' => $type
            ]);
        }
    }

    /**
     * Displays a single WorkList model.
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
     * Creates a new WorkList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($type)
    {        
        $model = new WorkList();
        if($type == Work::TYPE_GRADUATE)
            $model->work_type_id = Work::TYPE_GRADUATE;
        elseif($type == Work::TYPE_TERM)
            $model->work_type_id = Work::TYPE_TERM;
        else
            throw new NotFoundHttpException('The requested page does not exist.');
        
        if(isset(Yii::$app->user->identity->teacher))
            $model->teacher_id = Yii::$app->user->identity->teacher->id;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->actionIndex($type);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->actionIndex($model->work_type_id);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WorkList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $type = $this->findModel($id)->work_type_id;
        $this->findModel($id)->delete();

        return $this->actionIndex($type);
    }

    /**
     * Finds the WorkList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

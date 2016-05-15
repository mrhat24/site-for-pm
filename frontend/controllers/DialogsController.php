<?php

namespace frontend\controllers;

use Yii;
use common\models\Dialogs;
use frontend\models\DialogsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Message;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
/**
 * DialogsController implements the CRUD actions for Dialogs model.
 */
class DialogsController extends Controller
{
    public function behaviors()
    {
        
        return [ 
            
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['user'],
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
     * Lists all Dialogs models.
     * @return mixed
     */
    public function actionIndex($usr = null, $id = null)
    { 
        $searchModel = new DialogsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if($usr != null){
            $user = \common\models\User::findOne($usr);
            if(!$user)
                throw new NotFoundHttpException('The requested page does not exist.');
            $model = new Message();
            $model->user_id = Yii::$app->user->id;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $model->text = "";
            }
            $query = Message::find()->where(['user_id' => $usr])
                    ->orWhere(['user_id' => Yii::$app->user->id])
                    ->orderBy('id DESC');
            $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'pagination' => [
                        'pageSize' => 10,
                    ],                    
                ]);       
            return $this->render('view',[
                'dataProvider' => $dataProvider,
                'user' => $user,
                'model' => $model,
                ]);             
        }
        //elseif($id == null)
       //     return $this->render('view',['id' => $id]);
        else
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dialogs model.
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
     * Creates a new Dialogs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dialogs();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Dialogs model.
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
     * Deletes an existing Dialogs model.
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
     * Finds the Dialogs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dialogs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dialogs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

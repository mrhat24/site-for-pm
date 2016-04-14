<?php

namespace frontend\controllers;

use Yii;
use common\models\Message;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index','create'],
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
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex($usr = null)
    {
               
        if($usr == null) {
            return $this->render('index');
        }
        
        $model = new Message();
        $model->recipient_id = Yii::$app->request->get()['usr'];
        $model->sender_id = Yii::$app->user->id;
        
        $userto = Yii::$app->request->get()['usr'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $model->text = "";
        }
        unset(Yii::$app->request->post()['text']);
        $dataProvider = new ActiveDataProvider([
            'query' => Message::find()->where(['and','sender_id='.Yii::$app->user->id, 'recipient_id='.Yii::$app->request->get()['usr']])
                ->orWhere(['and','recipient_id='.Yii::$app->user->id, 'sender_id='.Yii::$app->request->get()['usr']])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10, 
            ],
        ]); 
        

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'userto' => $userto,
        ]);
        
    }

    /**
     * Displays a single Message model.
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
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Message();
        $model->recipient_id = $id;
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
        } 
        return $this->renderAjax('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     
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

    
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    */   

   /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

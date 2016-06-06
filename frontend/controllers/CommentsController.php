<?php

namespace frontend\controllers;

use Yii;
use common\models\Comments;
use frontend\models\CommentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class CommentsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['update','delete'],
                'rules' => [
                    [   
                        'actions' =>  ['update','delete'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],                  
                ],
            ],
        ];
    }
   
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if($model->user_id !== Yii::$app->user->id)
            return 'У вас недостаточно прав чтобы выполнять это действие!';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           return true; // return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }
   
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->user_id !== Yii::$app->user->id)
            return 'У вас недостаточно прав чтобы выполнять это действие!';
        $this->findModel($id)->delete();
    }
    
    protected function findModel($id)
    {
        if (($model = Comments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

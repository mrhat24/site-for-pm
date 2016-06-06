<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;
use common\models\AuthAssignment;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','view','update','manage','update-user'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['manage', 'update-user'],
                        'roles' => ['chief','manager','admin'],
                    ], 
                    [
                        'allow' => true,
                        'actions' => ['index','view','update'],
                        'roles' => ['user'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                /*    'delete' => ['post'], */
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionManage()
    {
        $searchModel = new UserSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id = null)
    {
        if($id != null){
            if(Yii::$app->request->isAjax)
                return $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]);
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        else{
            return $this->render('profile', [
            'model' => $this->findModel(Yii::$app->user->id),
        ]);
        }
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
        
    
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateUser($id)
    {
        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post())){
            $model->save();  
            //return $model->id;
            //return json_encode(Yii::$app->request->post()['User']['authAssignments']['item_name']['0']);\
            Yii::$app->authManager->revokeAll($model->id);
            foreach(Yii::$app->request->post()['User']['authAssignments']['item_name'] as $roleName)
            {                
                $role = Yii::$app->authManager->getRole($roleName);
                Yii::$app->authManager->assign($role, $model->id);
            }     
            return $this->redirect(Yii::$app->request->referrer);
        }
         return $this->renderAjax('update_user', [
                'model' => $model,
            ]);
    }


    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->id);
        
        $dir = Yii::getAlias('@frontend/web/uploads/');
        $uploaded = false;        
        
        if ($model->load($_POST)) {                        
            $file = UploadedFile::getInstance($model, 'imageFile');            
            $model->imageFile = $file;            
            if ($file&&$model->validate()) {                
                $filename = md5(date('U')).".".$file->extension;                
                $uploaded = $file->saveAs( $dir . $filename);                               
                $img = Image::getImagine()->open($dir . $filename);

                $size = $img->getSize();
                $ratio = $size->getWidth()/$size->getHeight();

                $width = 200;
                $height = round($width/$ratio);

                $box = new Box($width, $height);
                $img->resize($box)->save($dir . $filename);
                $model->image = '@web/uploads/' . $filename;
            }
            
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view']);
            }
        else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    /**
   
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

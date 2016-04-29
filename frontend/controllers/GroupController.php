<?php

namespace frontend\controllers;

use Yii;
use common\models\Group;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\GroupSearch;
use common\models\GroupSemesters;
use yii\helpers\Url;
use common\models\GroupAnounces;
/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),                
                'only' => ['index', 'view', 'my','create',
                    'update','delete','manage','preview','create-anounce'],
                'rules' => [
                    [
                        'actions' =>  ['view','index','create-anounce'],
                        'allow' => true,
                        'roles' => ['user'],
                    ],
                    [
                        'actions' =>  ['my'],
                        'allow' => true,
                        'roles' => ['student'],
                    ],
                    [
                        'actions' =>  ['create','update','delete','manage','preview'],
                        'allow' => true,
                        'roles' => ['chief'],
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
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {        
        $searchModel = new GroupSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionManage()
    {
        $searchModel = new GroupSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('manage', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionCreateAnounce($id)
    {
        if(Yii::$app->request->isAjax) {
        $model = new \common\models\GroupAnounces();
        if($id != null) $model->group_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return "Добавлено";//$this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create-anounce',[
                'model' => $model,
            ]);
        }
        }
        else {
             throw new NotFoundHttpException('Страница не существует.');
        }
    }
    
    public function actionDeleteAnounce($id)
    {
        $model = \common\models\GroupAnounces::findOne($id);
        if($model->user_id == Yii::$app->user->id)
            {   $model->delete(); }
       return $this->redirect(Url::to(['//teacher/cabinet']));
    }

        public function actionUpdateAnounce($id)
    {
        if(Yii::$app->request->isAjax) {
        $model = \common\models\GroupAnounces::findOne($id);
        if($model->user_id !== Yii::$app->user->id)
            throw new NotFoundHttpException('Страница не существует.');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return "Сохранено";//$this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->renderAjax('create-anounce',[
                'model' => $model,
            ]);
        }
        }
        else {
             throw new NotFoundHttpException('Страница не существует.');
        }
    }

        /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionPreview($id)
    {
        if(Yii::$app->request->isAjax) {
        return $this->renderAjax('preview', [
            'model' => $this->findModel($id),
        ]);
        }
    }
    
    /**
     * Displays a single Group model.
     * @param integer $id
     * @return mixed
     */
    public function actionMy()
    {
        if(Yii::$app->user->identity->isStudent)
        return $this->render('mygroup', [
            'model' => $this->findModel(Yii::$app->user->identity->student->group_id),
        ]);
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionLists($id)
    {
         $groups = Group::find()->select('group.*')
                 ->leftJoin('group_has_discipline','group_has_discipline.group_id = group.id')
                 ->where(['group_has_discipline.discipline_id' => $id])
                 ->all();
         $groupsCount = Group::find()->select('group.*')
                 //->leftJoin('group_has_discipline','group_has_discipline.group_id = group.id')
                // ->where(['group_has_discipline.discipline_id' => $id])
                 ->count();
         return $this->renderAjax('lists',['groups' => $groups]);                  
    }
    /**
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       // if(Yii::$app->request->isAjax) {
        $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            GroupSemesters::createSemestersForGroup($model->getPrimaryKey(), 
                    Yii::$app->request->post()['sem_count'],
                    Yii::$app->request->post()['begin_year']);
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
        //}
       // else {
       //      throw new NotFoundHttpException('Страница не существует.');
       // }
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelGS = GroupSemesters::find()->where(['group_id' => $id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['manage']);
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
                'modelGS' => $modelGS,
            ]);
        }
    }
    /*
    
     * Deletes an existing Group model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['manage']);
    }

    /*
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

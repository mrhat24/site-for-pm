<?php
namespace common\widgets;
use Yii;
use common\models\Comments;
use yii\bootstrap\Widget;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CommentsWidget extends Widget
{
    public $class_name = null;
    public $item_id = null; 

    public function init()
    {
        parent::init();
        $model = new Comments();
        if($this->class_name != null){
            $model->class_name = $this->class_name;
        }
        if($this->item_id != null){
            $model->item_id = $this->item_id;
        }
        if($model->load(Yii::$app->request->post()) && $model->save()){
            
        } 
    }
    
    public function run()
    {
        $model = new Comments();
        $query = Comments::find()->where(['class_name' => $this->class_name, 'item_id' => $this->item_id])->orderBy('id DESC');
        $dataProvider = new ActiveDataProvider(['query' => $query, 'pagination' => ['pageSize' => 10]]);
        echo $this->render('commentsWidget/view',['dataProvider' => $dataProvider]);        
        echo $this->render('commentsWidget/_form',['model' => $model]);
    }
}

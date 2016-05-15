<?php
use yii\helpers\Html;
use yii\helpers\Url;


$text = Html::encode($model->text);
//$text = Html::tag('div',$text,['class' => 'well']);
$edit = '';
$delete = '';
if(Yii::$app->user->id === $model->user_id){
    $edit = Html::button('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>',
            ['value' => Url::to(['//comments/update','id' => $model->id]),
                'class' => 'btn btn-sm btn-primary modalButton pull-right']);
    $delete = Html::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>',
            ['value' => Url::to(['//comments/delete','id' => $model->id]),
                'class' => 'btn btn-sm btn-primary deleteCommentButton pull-right']);
}

$text = Html::tag('div',$text,['class' => 'panel-body']);
$date = Html::tag('span',Yii::$app->formatter->asDateTime($model->datetime));
$author = Html::tag('span',Html::button($model->user->fullname,
        ['value' => Url::to(['//user/view',
            'id' => $model->user_id]),'class' => 'btn-link modalButton']));
$info = Html::tag('li',$author.$date.$delete.$edit,['class' => 'list-group-item']);
$info = Html::tag('ul',$info,['class' => 'list-group']);
$header = Html::tag('div','Коментарии',['class' => 'panel-heading']);
echo Html::tag('div',$text.$info,['class' => 'panel panel-default']);


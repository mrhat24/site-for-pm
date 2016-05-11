<?php
use yii\helpers\Html;
use yii\helpers\Markdown;
use yii\helpers\ArrayHelper;
foreach($exersices as $l)
{
echo "Упражнение#".$l->id." ".$l->name;
if($l->exerciseTests){
    $checkboxes = Html::checkboxList('answers',$l->exerciseTestsTrue,ArrayHelper::map($l->exerciseTests, 'id','value'),['separator' => '<br>','itemOptions' => ['disabled' => true]]);           
    echo Html::tag('div',$checkboxes,['class' => 'well well-sm']);
}
else
echo Markdown::process($l->text);
}
<?php
use yii\helpers\Html;
use common\components\DateHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
?>  
<tr class="<?=$model->statusIdentity['ident']?>">
    <td><?= Html::tag('span',$model->task->name)?></td>
    <td><?= Html::tag('span',$model->student->user->fullname)?></td>
    <td><?= Html::tag('span',$model->student->group->name)?></td>    
    <td><?= Html::tag('span',DateHelper::getDateByUserTimezone($model->given_date))?></td>    
    <td><?= Html::button('Открыть',['value'=> Url::to(['given-task/check',
        'id' => $model->id]),
        'class' => 'btn btn-success modalButton']);?></td>
</tr>

<?php
Modal::begin([
            'header' => '<h2>Решение задачи</h2>',
            //'toggleButton' => ['label' => 'Решить' , 'class' => 'btn btn-success'],
            'id' => 'modal',
            'size' => 'modal-lg',                      
        ]);        
    echo "<div id='modalContent'></div>";
    Modal::end();
?>
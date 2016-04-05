<?php
use yii\helpers\Html;
use common\components\DateHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
?>  
<tr class="<?=$model->statusIdentity['ident'];?>">
    <td><?= $model->task->name?><br><?= $model->discipline->name?></td>
    
    <td><?= $model->teacher->user->fullname?></td>    
    <td><?= DateHelper::getDateByUserTimezone($model->given_date)?></td>    
    <td><?= Html::a('Открыть',Url::to(['task/taken',
        'id' => $model->id]),
        ['class' => 'btn btn-success modalButton']);?></td>
</tr>


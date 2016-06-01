<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\GivenTask */
$this->title = 'Редактирование выданного задания';

?>
<div class="given-task-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <div>
        <?php
        $html_tag = 'h6';        
        echo Html::tag($html_tag,'Задание: '.$model->task->name,['class' => 'date', 'style'=> "text-align: right;"]);
        echo Html::tag($html_tag,'Студент: '.$model->student->user->fullname,['class' => 'date', 'style'=> "text-align: right;"]);
        echo Html::tag($html_tag,'Группа: '.$model->student->group->name,['class' => 'date', 'style'=> "text-align: right;"]);
        ?>
    </div>
    

    <?= $this->render('_update_form', [
        'model' => $model,
        'result' => $result,
    ]) ?>

</div>
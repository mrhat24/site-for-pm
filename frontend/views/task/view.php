<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php Pjax::begin(['id' => 'pjax-view', 'enablePushState' => false]); ?>

<div class="task-view">
    <script>
        //
        //  Use a closure to hide the local variables from the
        //  global namespace
        //
        (function () {
          var QUEUE = MathJax.Hub.queue;  // shorthand for the queue
          var math = null;                // the element jax for the math output.

          //
          //  Get the element jax when MathJax has produced it.
          //
          QUEUE.Push(function () {
            math = MathJax.Hub.getAllJax("math-tex")[0];
          });

          //
          //  The onchange event handler that typesets the
          //  math entered by the user
          //
          window.UpdateMath = function (TeX) {
            QUEUE.Push(["Text",math,"\\displaystyle{"+TeX+"}"]);
          }
        })();
      </script>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'name',
           // 'teacher_id',
            [ 
                'attribute' => 'type_id',
                'value' => $model->taskType->name,
            ],
            [
                'attribute' => 'text',
                'value' => Markdown::process($model->text),
                'format' => 'html'
            ],
        ],
    ]) ?>
    

</div>
<?php Pjax::end(); ?>
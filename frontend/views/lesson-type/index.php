<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\LessonTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы лекций';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Pjax::begin(['id' => 'modalContent','enablePushState' => false]); ?>
<div class="lesson-type-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Добавить новый тип', ['value' => Url::to(['//lesson-type/create']),'class' => 'btn btn-primary modalButton']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',

            ['class' => 'common\components\ActionColumn'],
        ],
    ]); ?>
</div>

<?php Pjax::end(); ?>
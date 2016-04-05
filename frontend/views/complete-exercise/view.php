<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
$parser = new \Netcarver\Textile\Parser();
/* @var $this yii\web\View */
/* @var $model common\models\CompleteExercise 

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Complete Exercises', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
    <?php echo $parser->textileThis($model->text); ?>

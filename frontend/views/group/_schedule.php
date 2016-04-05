<?php

use common\widgets\Schedule;
use common\models\Lesson;
use yii\bootstrap\Tabs;
use yii\bootstrap\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo Html::tag('br');  
$lessons = Lesson::getLessonsList(['group' => $model->id]);
        
        echo Tabs::widget([
            'items' => [
                [
                'label' => 'Неделя - 1',
                'content' => Schedule::widget([
                    'scenario' => 'group',
                    'lessons' => $lessons,
                    'week' => 1]),
                ],
                [
                'label' => 'Неделя - 2',
                'content' => Schedule::widget([
                    'scenario' => 'group',
                    'lessons' => $lessons,
                    'week' => 2]),            
                ]
            ]
        ]);
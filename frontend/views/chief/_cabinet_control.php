<?php
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\helpers\Url;
use yii\grid\GridView;



$tabs = Tabs::widget([    
    'options' => [
      'class' => 'nav nav-pills nav-justified'
    ],
    'itemOptions' => ['tag' => 'div','class' => 'well'],
    'items' => [
        [
            'label' => 'Группы',
            'content' => $this->render('_groups'),
        ],
        [
            'label' => 'Преподаватели',
            'content' => $this->render('_teachers'),
        ],
        [
            'label' => 'Студенты',
            'content' => $this->render('_students'),
        ]
    ]
]);

echo $tabs;
<?php
namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;
class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //удаляем старые данные
        //Создадим для примера права для доступа к админке
        //$dashboard = $auth->createPermission('dashboard');
        //$dashboard->description = 'Админ панель';
        //$auth->add($dashboard);
        //Включаем наш обработчик
        $rule = new UserRoleRule();
        $auth->add($rule);
        //Добавляем роли
        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $user->ruleName = $rule->name;
        $auth->add($user);
        $student = $auth->createRole('student');
        $student->description = 'Студент';
        $student->ruleName = $rule->name;
        $auth->add($student);
        //Добавляем потомков
        $auth->addChild($student, $user);
        //$auth->addChild($moder, $dashboard);
        
        $teacher = $auth->createRole('teacher');
        $teacher->description = 'Преподаватель';
        $teacher->ruleName = $rule->name;
        $auth->add($teacher);
        $auth->addChild($teacher, $student);
        
        $chief = $auth->createRole('chief');
        $chief->description = 'Заведующий кафедрой';
        $chief->ruleName = $rule->name;
        $auth->add($chief);
        $auth->addChild($chief, $teacher);
        
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';
        $admin->ruleName = $rule->name;
        $auth->add($admin);
        $auth->addChild($admin, $chief);
    }
}
<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $createPost = $auth->createPermission('createUser');
        $createPost->description = 'Create user';
        $auth->add($createPost);

        $updatePost = $auth->createPermission('updateUser');
        $updatePost->description = 'Update user';
        $auth->add($updatePost);

// добавляем роль "admin" и даём роли разрешение "updatePost"
// а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $createPost);

    }
}
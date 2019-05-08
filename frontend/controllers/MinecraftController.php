<?php
namespace frontend\controllers;

use yii\rest\ActiveController;
use yii\filters\AccessControl;
use yii\filters\auth\QueryParamAuth;
use yii;
use common\models\User;
use yii\web\ForbiddenHttpException;

class MinecraftController extends ActiveController
{
    public function init()
    {
        Yii::$app->user->enableSession=false;
    }
    public $modelClass = 'common\models\User';
    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => QueryParamAuth::className(),
            ],
        ];
    }

    /**
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionLogin()
    {
        $this->checkAccess("login");
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $postarr = json_decode(Yii::$app->getRequest()->getRawBody(), true);
        if(!$postarr) return array('status' => 'ERROR','error' => "request incorrect");
        $login = $postarr["username"];
        $pass = $postarr["password"];
        $model = User::findByUsername($login);
        if($model == null)
        {
            return array('status' => 'ERROR','error' => "username or password incorrect");
        }
        if($model->validatePassword($pass))
        {
            if($model->status == User::STATUS_BANNED) return array('status' => 'ERROR','error' => "You Banned");
            return array('status' => 'OK', "username" => $login);
        }
        else
            return array('status' => 'ERROR','error' => "username or password incorrect");
    }
    public function checkAccess($action, $model = null, $params = [])
    {
        if (!\Yii::$app->user->can('checkuser'))
            throw new ForbiddenHttpException('You can only MinecraftBot');
    }
}

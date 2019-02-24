<?php
/**
 * Created by PhpStorm.
 * User: gravit
 * Date: 23.02.19
 * Time: 19:21
 */

namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class WikiController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param $page
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionPage($page)
    {
        if(preg_match("#^[aA-zZ0-9\-_]+$#", $page /* Валидация */) && file_exists(Yii::getAlias('@frontend').'/views/wiki/'.$page.'.php'))
        return $this->render($page);
        else throw new NotFoundHttpException('Страница не найдена');
    }
}
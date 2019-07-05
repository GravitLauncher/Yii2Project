<?php
namespace frontend\controllers;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use frontend\models\UploadSkinForm;
use yii\web\UploadedFile;

class CabinetController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['uploadskin', 'uploadcloak'],
                'rules' => [
                    [
                        'actions' => ['uploadskin', 'uploadcloak'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'uploadskin' => ['post'],
                    'uploadcloak' => ['post'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $modelSkin = new UploadSkinForm();
        $modelCloak = new UploadSkinForm();
        return $this->render('index', ['uploadSkin' => $modelSkin, 'uploadCloak' => $modelCloak]);
    }
    public function actionUploadskin()
    {

        $model = new UploadSkinForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload(Yii::$app->user->identity->username, false)) {
                // file is uploaded successfully
                return $this->redirect(['cabinet/index']);
            }
        }
    }
    public function actionUploadcloak()
    {

        $model = new UploadSkinForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload(Yii::$app->user->identity->username, true)) {
                // file is uploaded successfully
                return $this->redirect(['cabinet/index']);
            }
        }
    }

}

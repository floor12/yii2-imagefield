<?php

namespace floor12\imagefield;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;
use Yii;

class ImagefieldController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'create' => ['post'],
                ],
            ],
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionDelete() {

        $id = (int) Yii::$app->request->post('id');
        $image = Image::findOne($id);
        if ($image->delete())
            echo 1;
        else
            echo 0;
    }

    public function actionCreate() {
        $files = UploadedFile::getInstancesByName('image');
        $className = Yii::$app->request->post('class');
        if ((sizeof($files) > 0) && ($className)) {
            $ret = '';
            foreach ($files as $fileInstance) {
                if (array_search($fileInstance->type, Image::getAllowed()) === false)
                    continue;
                $fileName = md5(time() . $fileInstance->tempName) . "." . $fileInstance->extension;
                $fileInstance->saveAs(Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . Image::IMAGEFIELD_DIR . DIRECTORY_SEPARATOR . $fileName);
                $image = new Image();
                $image->file = $fileName;
                $image->class = $className;
                if ($image->save())
                    $ret .= Yii::$app->view->renderFile('@vendor/floor12/imagefield/views/_form.php', ['image' => $image, 'class' => $className, 'hidden' => 1]);
            }
            echo $ret;
        } else {
            throw new BadRequestHttpException();
        }
    }

}

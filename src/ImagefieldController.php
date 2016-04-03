<?php

namespace floor12\imagefield;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\web\BadRequestHttpException;
use Yii;

class ImagefieldController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'create' => ['post'],
                    'crop' => ['post'],
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

    public function actionCrop()
    {
        $image = Image::findOne(Yii::$app->request->post('id'));
        if (!$image)
            throw new BadRequestHttpException();
        $src = self::imageCreateFromAny($image->realPath);
        $dest = imagecreatetruecolor(Yii::$app->request->post('width'), Yii::$app->request->post('height'));
        imagecopy($dest, $src, 0, 0, Yii::$app->request->post('left'), Yii::$app->request->post('top'), Yii::$app->request->post('width'), Yii::$app->request->post('height'));

        $newName = md5(time() . rand(0, 1000)) . ".jpeg";
        imagejpeg($dest, Yii::getAlias('@webroot') . '/' . Image::IMAGEFIELD_DIR . '/' . $newName, 80);
        imagedestroy($dest);
        imagedestroy($src);

        if (Yii::$app->request->post('createNew')) {
            $newImage = new Image;
            $newImage->class = $image->class;
            $newImage->file = $newName;
            $newImage->save();
            echo Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/_form.php', ['image' => $newImage, 'class' => $newImage->class, 'hidden' => 1]);
        } else {
            unlink(Yii::getAlias('@webroot') . '/' . Image::IMAGEFIELD_DIR . '/' . $image->file);
            $image->file = $newName;
            $image->save();
            echo Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/_form.php', ['image' => $image, 'class' => $image->class]);
        }
    }

    public function actionDelete()
    {

        $id = (int)Yii::$app->request->post('id');
        $image = Image::findOne($id);
        if ($image->delete())
            echo 1;
        else
            echo 0;
    }

    public function actionCreate()
    {
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
                    $ret .= Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/_form.php', ['image' => $image, 'class' => $className, 'hidden' => 1]);
            }
            echo $ret;
        } else {
            throw new BadRequestHttpException();
        }
    }

    public function actionPreview()
    {
        $images = Image::find()->all();
        if ($images) foreach ($images as $image) {
            $image->updatePreview();
            echo "updating {$image->id} <br>";

        }
    }

    public static function imageCreateFromAny($filepath)
    {
        $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize() 
        $allowedTypes = array(
            1, // [] gif 
            2, // [] jpg 
            3, // [] png 
            6   // [] bmp 
        );
        if (!in_array($type, $allowedTypes)) {
            return false;
        }
        switch ($type) {
            case 1 :
                $im = imageCreateFromGif($filepath);
                break;
            case 2 :
                $im = imageCreateFromJpeg($filepath);
                break;
            case 3 :
                $im = imageCreateFromPng($filepath);
                break;
            case 6 :
                $im = imageCreateFromBmp($filepath);
                break;
        }
        return $im;
    }

}

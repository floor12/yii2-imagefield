<?php

namespace floor12\imagefield;

use yii\base\Behavior;
use yii;
use yii\validators\Validator;
use yii\db\ActiveRecord;

/**
 * Description of ImageBehavior
 *
 * @author floor12
 */
class ImageBehavior extends Behavior
{

    public $imageArray;

    public function getImageArray()
    {
        $ret = [];
        if ($this->images)
            foreach ($this->images as $image)
                $ret[] = $image->id;
        return $ret;
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'imagesUpdate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'imagesUpdate'
        ];
    }

    public function imagesUpdate()
    {
        $order = 0;
        if ($this->imageArray)
            foreach ($this->imageArray as $id) {
                $img = Image::findOne($id);
                $img->object_id = $this->owner->id;
                $img->order = $order;
                $img->save();
                $order++;
                if (!$img->save()) {
                    print_r($img->getErrors());
                }
            }
    }

    function __construct()
    {
        parent::__construct();
        self::checkImageDir();
    }

    public function attach($owner)
    {
        parent::attach($owner);
        $validators = $owner->validators;
        $validator = Validator::createValidator('safe', $owner, ['imageArray']);
        $validators->append($validator);
    }

    public function checkImageDir()
    {
        $imagePath = Yii::getAlias('@webroot') . '/' . Image::IMAGEFIELD_DIR;
        if (!file_exists($imagePath)) {
            if (mkdir($imagePath))
                return true;
        }
        return true;
        die();
    }

    public function getImages()
    {
        if ($this->owner->id)
            return Image::find()->orderBy('order')->where(['object_id' => $this->owner->id, 'class' => \yii\helpers\StringHelper::basename(get_class($this->owner))])->all();
    }

    public function imageForm()
    {
        ImageFieldAsset::register(\Yii::$app->view);
        CropperAsset::register(\Yii::$app->view);
        $content = '';
        if ($this->images)
            foreach ($this->images as $image)
                $content .= \Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/_form.php', ['image' => $image, 'class' => \yii\helpers\StringHelper::basename(get_class($this->owner))]);
        return \Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/form.php', ['images' => $content, 'className' => \yii\helpers\StringHelper::basename(get_class($this->owner))]);
    }

    public function slider($param)
    {
        PgwSliderAsset::register(\Yii::$app->view);
        $content = '';
        $paramsSting = '';

        if (isset($param['pgwParams']))
            foreach ($param['pgwParams'] as $key => $parametr) {
                if ($parametr === false)
                    $parametr = 'false';
                $paramsSting .= "{$key} : " . $parametr . ", ";
            }

        if ($this->images)
            foreach ($this->images as $key => $image) {
                if (isset($param['showFirstImage']) && $param['showFirstImage'] == false && ($key == 0))
                    continue;
                $content .= \Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/_slider.php', ['image' => $image]);
            }
        return \Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/slider.php', ['images' => $content, 'pgwParams' => $paramsSting]);
    }

    public function lightbox($skipfirst = true)
    {
        LightboxAsset::register(\Yii::$app->view);
        $content = '';
        if ($this->images)
            foreach ($this->images as $key => $image) {
                if ($skipfirst && !$key)
                    continue;

                if (isset($param['showFirstImage']) && $param['showFirstImage'] == false && ($key == 0))
                    continue;
                $content .= \Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/_lightbox.php', ['image' => $image]);
            }
        return \Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/lightbox.php', ['images' => $content]);
    }

}

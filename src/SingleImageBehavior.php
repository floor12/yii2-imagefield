<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 31.05.2016
 * Time: 11:19
 */

namespace floor12\imagefield;

use yii\base\Behavior;
use yii\validators\Validator;
use yii\db\ActiveRecord;


class SingleImageBehavior extends Behavior
{

    public $singleImageArray = [];
    public $fields = [];

    public function getSingleImage()
    {
        $ret = [];
        if ($this->fields) foreach ($this->fields as $field => $fieldName) {
            $ret[$field] = Image::find()->orderBy('order')->where(['field' => $field, 'object_id' => $this->owner->id, 'class' => \yii\helpers\StringHelper::basename(get_class($this->owner))])->one();
        }
        return $ret;
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'singleImagesUpdate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'singleImagesUpdate'
        ];
    }

    public function singleImagesUpdate()
    {
        $order = 0;
        if ($this->singleImageArray)
            foreach ($this->singleImageArray as $field => $id) {

                $oldImages = Image::find()->where([
                    'class' => \yii\helpers\StringHelper::basename(get_class($this->owner)),
                    'object_id' => $this->owner->id,
                    'field' => $field,
                ])->all();
                if ($oldImages) foreach ($oldImages as $oldImage)
                    $oldImage->unsetit();

                $img = Image::findOne($id);
                $img->object_id = $this->owner->id;
                $img->order = $order;
                $img->field = $field;
                $img->save();
                if (!$img->save()) {
                    print_r($img->getErrors());
                }
            }
    }

    public function singleImageForm($field)
    {
        SimpleImageFieldAsset::register(\Yii::$app->view);
        CropperAsset::register(\Yii::$app->view);
        return \Yii::$app->view->renderFile('@vendor/floor12/yii2-imagefield/views/singleForm.php', ['attributeName' => $this->fields[$field], 'field' => $field, 'image' => $this->singleImage[$field], 'class' => \yii\helpers\StringHelper::basename(get_class($this->owner))]);
    }

    public function attach($owner)
    {
        parent::attach($owner);
        $validators = $owner->validators;
        $validator = Validator::createValidator('safe', $owner, ['singleImageArray']);
        $validators->append($validator);
    }

}
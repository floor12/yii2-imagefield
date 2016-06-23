<?php

namespace floor12\imagefield;

use yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $file
 * @property string $class
 * @property string $field
 * @property integer $object_id
 * @property integer $order
 */
class Image extends \yii\db\ActiveRecord
{

    const IMAGEFIELD_DIR = 'images';

    public static function getAllowed()
    {
        return [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['object_id', 'order'], 'integer'],
            [['file', 'class', 'field'], 'string', 'max' => 255]
        ];
    }


    public function getPath()
    {
        return Yii::getAlias('@web') . '/' . Image::IMAGEFIELD_DIR . '/' . $this->file;
    }

    public function getRealPath()
    {
        return Yii::getAlias('@webroot') . '/' . Image::IMAGEFIELD_DIR . '/' . $this->file;
    }

    public function getPreviewPath()
    {
        return Yii::getAlias('@web') . '/' . Image::IMAGEFIELD_DIR . '/preview_' . $this->file;
    }

    public function getRealPreviewPath()
    {
        return Yii::getAlias('@webroot') . '/' . Image::IMAGEFIELD_DIR . '/preview_' . $this->file;
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->updatePreview();
        parent::afterSave($insert, $changedAttributes); 
    }

    public function updatePreview()
    {
        if (file_exists($this->realPath)) {
            $image = new SimpleImage();
            $image->load($this->realPath);
            $image->resizeToWidth(350);
            $image->save($this->realPreviewPath);
        }
    }

    public function afterDelete()
    {
        @unlink($this->realPath);
        @unlink($this->realPreviewPath);
        parent::afterDelete();
    }

}

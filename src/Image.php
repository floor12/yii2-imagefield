<?php

namespace floor12\imagefield;

use yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $file
 * @property string $class
 * @property integer $object_id
 * @property integer $order
 */
class Image extends \yii\db\ActiveRecord {

    const IMAGEFIELD_DIR = 'images';

    public static function getAllowed() {
        return [
            'image/jpeg',
            'image/png',
            'image/gif'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'image';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['object_id', 'order'], 'integer'],
            [['file', 'class'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'file' => 'File',
            'class' => 'Class',
            'object_id' => 'Object ID',
            'order' => 'Order',
        ];
    }

    public function getPath() {
        return Yii::getAlias('@web') . '/' . Image::IMAGEFIELD_DIR . '/' . $this->file;
    }

    public function afterDelete() {
        unlink(Yii::getAlias('@webroot') . '/' . Image::IMAGEFIELD_DIR . '/' . $this->file);
        parent::afterDelete();
    }

}

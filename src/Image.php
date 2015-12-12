<?php

namespace floor12\imageField;

use Yii;

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

}

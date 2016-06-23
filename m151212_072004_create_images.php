<?php

use yii\db\Schema;
use yii\db\Migration;

class m151212_072004_create_images extends Migration {

    public function up() {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'file' => $this->string(255),
            'class' => $this->string(255),
            'field' => $this->string(255),
            'object_id' => $this->integer(),
            'order' => $this->integer(),
                ], $tableOptions);
    }

    public function down() {
        $this->dropTable('image');
    }

}

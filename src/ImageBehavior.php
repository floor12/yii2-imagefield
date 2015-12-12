<?php

namespace floor12\imageField;

use yii\base\Behavior;
use Yii;

/**
 * Description of ImageBehavior
 *
 * @author floor12
 */
class ImageBehavior extends Behavior {

    public $imageArray = array();

    public function getImages() {
        return 1;
    }

    public function imageForm() {
        return \Yii::$app->view->renderFile('@app/views/image/form.php');
    }

}

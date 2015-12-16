<?php
$script = <<< JS
$(document).ready(function() {
    $('.imagefield-pgwslider').pgwSlider({
        $pgwParams
        });
});
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_READY);
?>

<ul class='imagefield-pgwslider'>
    <?= $images ?>
</ul>
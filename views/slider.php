<?php
$script = <<< JS
$(document).ready(function() {
    $('.imagefield-pgwslider').pgwSlider({
        $pgwParams
        });
});
JS;
//������ ����� ������, ����������� �����, ��� �������� � ���������
$this->registerJs($script, yii\web\View::POS_READY);
?>

<ul class='imagefield-pgwslider'>
    <?= $images ?>
</ul>
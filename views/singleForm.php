<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 31.05.2016
 * Time: 13:03
 */

?>

<script>
    var className = '<?= $class ?>';
    var csrfToken = '<?= Yii::$app->request->csrfToken; ?>';
    var csrfParam = '<?= Yii::$app->request->csrfParam; ?>';
</script>

<?= $this->render('cropper') ?>


<div class="form-group">
    <label class="control-label" for="organization-description">
        <?= $attributeName ?>
        <a href="" class="btn btn-xs btn-default singleFieldUpload" data-field="<?= $field ?>"
           id="singleFieldUploadButton_<?= $field ?>" onclick="return false;">
            <span class="glyphicon glyphicon-upload"></span> Загрузить изображение
        </a>
    </label>
    <div id="singleImage_<?= $field ?>">
        <?php if ($image) echo $this->render('_singleForm', ['field' => $field, 'image' => $image, 'class' => $class]); ?>
    </div>
</div>


<?php

$this->registerJs("

    var className = '{$class}';
    var csrfToken = '" . Yii::$app->request->csrfToken . "';
    var csrfParam = '" . Yii::$app->request->csrfParam . "';

    new ss.SimpleUpload({
        button: $('#singleFieldUploadButton_{$field}'), // HTML element used as upload button
        url: '/imagefield/create/', // URL of server-side upload handler
        name: 'image[]',
        noParams: true,
        multiple: false,
        multipart: true,
        data: {
    '_csrf': csrfToken, class: className, field: '{$field}'},
        onSubmit: function (filename, extension) {
    //     $('#process').show();
    //     this.setProgressBar($('#progressBar')); // designate as progress bar
},
        onComplete: function (filename, response) {
    $('#process') . hide();
    if (!response) {
        alert(filename + ' upload failed');
        return false;
    }

    $('#singleImage_{$field}') . html(response);
}
    });


", yii\web\View::POS_END, 'uploader_' . $field);


?>

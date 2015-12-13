<script>
    var className = '<?= $className ?>';
    var csrfToken = '<?= Yii::$app->request->csrfToken; ?>';
    var csrfParam = '<?= Yii::$app->request->csrfParam; ?>';
</script>
<div class="form-group">
    <div class="btn btn-success" id="image-field-add" >Добавить изображение</div>
    <div id='loadingZ'>Идет загрузка...</div>
    <div class='row' id='imagefield-images'>
        <?= $images ?>
    </div>
</div>
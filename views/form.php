<script>
    var className = '<?= $className ?>';
    var csrfToken = '<?= Yii::$app->request->csrfToken; ?>';
    var csrfParam = '<?= Yii::$app->request->csrfParam; ?>';
</script>

<?= $this->render('cropper')?>

<div class="form-group">
    <div class="row">
        <div class="col-sm-3">
            <div class="btn btn-success" id="image-field-add" ><span class='glyphicon glyphicon-plus'></span> Добавить изображение</div>
        </div>
        <div class="col-sm-9">
            <div id="process">
                <div class="progress uploaderProgress" id="uploaderProgress">
                    <div id="progressBar" class="progress-bar progress-bar-striped active progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
    <div class='row' id='imagefield-images'>
        <?= $images ?>
    </div>
</div>
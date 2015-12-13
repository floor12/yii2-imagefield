<div class="col-md-2 col-sm-4 col-xs-6 imagefield-image <?php if (isset($hidden)) echo "myhidden"; ?> " id="field_<?= $image->file ?>">
    <div class='imagefield-control'>
        <div class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-remove-circle imagefield-delete " data-id='<?= $image->id ?>'></span></div>
        <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-scissors imagefield-crop" data-id='<?= $image->id ?>'></span></div>
    </div>
    <img data-name="<?= $image->file ?>" data-src="<?= $image->path ?>" src="<?= $image->path ?>" class="img-responsive img-thumbnail partPhoto">
    <input type="hidden" value="<?= $image->id ?>" name="<?= $class ?>[imageArray][]">
</div>
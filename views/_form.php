<div class="col-md-2 col-sm-4 col-xs-6 imagefield-image <?php if (isset($hidden)) echo "myhidden"; ?> " id="field_<?= $image->file ?>">
    <span class="glyphicon glyphicon-remove-circle imagefield-delete" data-id='<?= $image->id ?>'></span>
    <img data-name="<?= $image->file ?>" data-src="<?= $image->path ?>" src="<?= $image->path ?>" class="img-responsive img-thumbnail partPhoto">
    <input type="hidden" value="<?= $image->id ?>" name="<?= $class ?>[imageArray][]">
</div>
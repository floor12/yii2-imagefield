<div class="col-md-2 col-sm-4 col-xs-6 imagefield-image <?php if (isset($hidden)) echo "myhidden"; ?> " id="imagefield_<?= $image->id ?>">
    <div class='imagefield-control'>
        <div class="btn btn-danger btn-sm imagefield-delete" data-id='<?= $image->id ?>'><span class="glyphicon glyphicon-remove-circle"></span></div>
        <div class="btn btn-default btn-sm imagefield-crop" data-id='<?= $image->id ?>'><span class="glyphicon glyphicon-scissors "></span></div>
    </div>
    <img data-name="<?= $image->file ?>" data-src="<?= $image->path ?>" src="<?= $image->path ?>" class="img-responsive img-thumbnail partPhoto">
    <input type="hidden" value="<?= $image->id ?>" name="<?= $class ?>[imageArray][]">
</div>
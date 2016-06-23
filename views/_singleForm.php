<div class="imagefield-image imagefield-image-single"
     id="imagefield_<?= $image->id ?>">
    <div class='imagefield-control'>
        <div class="btn btn-danger btn-sm imagefield-delete" data-id='<?= $image->id ?>'
             data-field='<?= $field ?>'><span
                class="glyphicon glyphicon-remove-circle"></span></div>
        <div class="btn btn-default btn-sm imagefield-crop" data-id='<?= $image->id ?>' data-field='<?= $field ?>'><span
                class="glyphicon glyphicon-scissors "></span></div>
    </div>
    <img data-name="<?= $image->file ?>" data-src="<?= $image->path ?>" src="<?= $image->path ?>"
         class="img-responsive img-thumbnail partPhoto">
    <input type="hidden" value="<?= $image->id ?>" name="<?= $class ?>[singleImageArray][<?= $field ?>]">
</div>
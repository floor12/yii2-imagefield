<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 31.05.2016
 * Time: 12:42
 */

?>


<div class="modal fade bs-example-modal-lg" id="editorModal" tabindex="-1" role="dialog" aria-labelledby="editorModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Кадрирование изображения</h4>
            </div>
            <div class="modal-body" id='imagefield-editor-aria'>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-6 text-left">
                        <button type="button" class="btn btn-primary" id='imagefield-control-01'>1/1</button>
                        <button type="button" class="btn btn-primary" id='imagefield-control-02'>3/4</button>
                        <button type="button" class="btn btn-primary" id='imagefield-control-03'>4/3</button>
                        <button type="button" class="btn btn-primary" id='imagefield-control-04'>16/9</button>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="hidden" id="cropField"></div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                        <button type="button" class="btn btn-warning" onclick="imagefieldCrop(0)">Сохранить текущее
                        </button>
                        <button type="button" class="btn btn-success" onclick="imagefieldCrop(1)">Создать новое</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

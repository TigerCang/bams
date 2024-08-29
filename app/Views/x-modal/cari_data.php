<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMlampir') ?>">
                <h4 class="modal-title"><?= lang('app.cari') ?></h4>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>

            <?= form_open_multipart('', ['class' => 'formlampiran']) ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <div class="form-group row">
                                <div class="col-sm-12"><input type="text" class="form-control" id="xdata" name="xdata" autocomplete="off" autofocus></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>
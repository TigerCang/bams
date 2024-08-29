<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMdetil'); ?>">
                <h4 class="modal-title"><?= lang('app.detildata'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-block">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-6">
                                    <img src="/assets/fileimg/barang/<?= ($barang[0]->gambar ?? 'default.png') ?>" class="img-thumbnail img-preview mx-auto my-auto d-block">
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.kode'); ?></label>
                                <label class="col-sm-4 col-form-label">: <?= ($barang[0]->kode ?? '') ?></label>
                                <div class="col-sm-1"></div>
                                <label class="col-sm-2 col-form-label"><?= lang('app.partnumber'); ?></label>
                                <label class="col-sm-3 col-form-label">: <?= ($barang[0]->partnumber ?? '') ?></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.deskripsi'); ?></label>
                                <label class="col-sm-10 col-form-label">: <?= ($barang[0]->nama ?? '') ?></label>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"><?= lang('app.kategori'); ?></label>
                                <label class="col-sm-4 col-form-label">: <?= ($barang[0]->kategori ?? '') ?></label>
                                <div class="col-sm-1"></div>
                                <label class="col-sm-2 col-form-label"><?= lang('app.merk'); ?></label>
                                <label class="col-sm-3 col-form-label">: <?= ($barang[0]->merk ?? '') ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page-body start -->
<div class="page-body">
    <form action="/atributgaji/update/<?= $atribut['0']->id; ?>" id="myForm" method="POST">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= lang('app.bgDetil'); ?>">
                        <h5><?= lang('app.ubahdata'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <input type="hidden" class="form-control" id="id_unik" name="id_unik" value="<?= $atribut['0']->id_unik ?>">
                        <input type="hidden" class="form-control" id="aktif" name="aktif" value="<?= (old('is_aktif')) ? old('is_aktif') : $atribut['0']->is_aktif ?>">

                        <div class="form-group row">
                            <label for="nourut" class="col-sm-2 col-form-label"><?= lang('app.urutan'); ?></label>
                            <div class="col-sm-4">
                                <input type="number" harusisi class="form-control <?= ($validation->hasError('nourut')) ? 'is-invalid' : ''; ?>" id="nourut" name="nourut" value="<?= $atribut['0']->nourut; ?>" min="1" max="100">
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('nourut'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="konstanta" class="col-sm-2 col-form-label"><?= lang('app.konstanta'); ?></label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="konstanta" name="konstanta" value="<?= $atribut['0']->nilaikonstanta; ?>" min="0" max="99">
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="satuan" class="col-sm-1 col-form-label"><?= lang('app.satuan'); ?></label>
                            <div class="col-sm-4">
                                <select id="satuan" class="js-example-basic-single <?= ($validation->hasError('satuan')) ? 'is-invalid' : ''; ?>" name="satuan">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih'); ?></option>
                                    <?php foreach ($satuan as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= ($atribut['0']->satuan == $db->nama) ? 'selected' : '' ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('satuan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label"><?= lang('app.deskripsi'); ?></label>
                            <div class="col-sm-10">
                                <input type="text" harusisi class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= $atribut['0']->nama; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('nama'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pemisah" class="col-sm-2 col-form-label"><?= lang('app.pemisah'); ?></label>
                            <div class="col-sm-4">
                                <select id="pemisah" class="js-example-basic-single" name="pemisah">
                                    <option value="+" <?= ($atribut['0']->separator == "+") ? 'selected' : '' ?>> + ( Penambahan )</option>
                                    <option value="-" <?= ($atribut['0']->separator == "-") ? 'selected' : '' ?>> - ( Pengurangan )</option>
                                    <option value="=" <?= ($atribut['0']->separator == "=") ? 'selected' : '' ?>> = ( Hasil )</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="status" class="col-sm-2 col-form-label"><?= lang('app.status'); ?></label>
                            <div class="col-sm-10 d-inline">
                                <input class="switch bs-switch" data="aktif" type="checkbox" <?= ($atribut['0']->is_aktif == '1') ? 'checked' : '' ?> data-on-text="<?= lang('app.aktif'); ?>" data-off-text="<?= lang('app.noaktif'); ?>" data-on-color="success" data-off-color="danger">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div></div>
                            <div>
                                <a href="/atributgaji/confirm/<?= $atribut['0']->id_unik; ?>" class="btn <?= lang('app.btnConfirm'); ?> <?= (session()->user['act_confirm'] == '0') ? 'disabled' : '' ?> <?= ($atribut['0']->is_confirm == '1') ? 'disabled' : '' ?> "><?= lang('app.btn_pasti'); ?></a>
                                <button type="button" class="btn <?= lang('app.btnDel'); ?>" <?= (session()->user['act_delete'] == '0') ? 'disabled' : '' ?> data-toggle="modal" data-target="#modal-delete"><?= lang('app.btn_hapus'); ?></button>
                                <button type="submit" class="btn btnSubmit <?= lang('app.btnUpdate'); ?>" <?= (session()->user['act_edit'] == '0') ? 'disabled' : '' ?>><?= lang('app.btn_update'); ?></button>
                            </div>
                        </div>
                    </div>
                </div><!-- end card-->

            </div>
        </div>
    </form>
</div><!-- body end -->

<div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMdel'); ?>">
                <h4 class="modal-title"><?= lang('app.titlekonfdelete'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?= lang('app.tanyadelete'); ?>&hellip; ?</p>
                <p><?= lang('app.infodel2'); ?></p>
            </div>
            <div class="modal-footer">
                <form action="/atributgaji/delete/<?= $atribut['0']->id; ?>" method="POST" class="d-inline">
                    <?= csrf_field(); ?>
                    <!-- HTTP method smoothing -->
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn <?= lang('app.btnOKmodal'); ?>" data-toggle="modal" data-target="#modal-delete" name="delete"><?= lang('app.btn_yesyakin'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>
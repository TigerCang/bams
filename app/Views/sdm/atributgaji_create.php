<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page-body start -->
<div class="page-body">
    <form action="/atributgaji/save" id="myForm" method="POST">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.createnew'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="nourut" class="col-sm-2 col-form-label"><?= lang('app.urutan'); ?></label>
                            <div class="col-sm-4">
                                <input type="number" harusisi class="form-control <?= ($validation->hasError('nourut')) ? 'is-invalid' : ''; ?>" id="nourut" name="nourut" value="<?= old('nourut'); ?>" min="1" max="100" autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('nourut'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="konstanta" class="col-sm-2 col-form-label"><?= lang('app.konstanta'); ?></label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="konstanta" name="konstanta" value="<?= old('konstanta'); ?>" min="0" max="99" autocomplete="off">
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="satuan" class="col-sm-1 col-form-label"><?= lang('app.satuan'); ?></label>
                            <div class="col-sm-4">
                                <select id="satuan" class="js-example-basic-single <?= ($validation->hasError('satuan')) ? 'is-invalid' : ''; ?>" name="satuan">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih'); ?></option>
                                    <?php foreach ($satuan as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= (old('satuan') == $db->nama) ? 'selected' : '' ?>><?= $db->nama; ?></option>
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
                                <input type="text" harusisi class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= old('nama'); ?>" autocomplete="off">
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('nama'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pemisah" class="col-sm-2 col-form-label"><?= lang('app.pemisah'); ?></label>
                            <div class="col-sm-4">
                                <select id="pemisah" class="js-example-basic-single" name="pemisah">
                                    <option value="+"> + ( Penambahan )</option>
                                    <option value="-"> - ( Pengurangan )</option>
                                    <option value="="> = ( Hasil )</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div></div>
                            <div>
                                <button type="reset" class="btn <?= lang('app.btnReset'); ?>"><?= lang('app.btn_reset'); ?></button>
                                <button type="submit" class="btn btnSubmit <?= lang('app.btnOK'); ?> <?= (session()->user['act_create'] == '0') ? 'disabled' : '' ?>"><?= lang('app.btn_create'); ?></button>
                            </div>
                        </div>
                    </div>
                </div><!-- end card-->

            </div>
        </div>
    </form>
</div><!-- body end -->

<?= $this->endSection(); ?>
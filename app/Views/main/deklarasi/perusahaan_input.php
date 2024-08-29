<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'formmain']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">

        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= ($perusahaan[0]->idunik ?? '') ?>" />
                <input type="hidden" name="namagambar" value="<?= ($perusahaan[0]->gambar ?? 'default.png') ?>">

                <div class="row g-2">
                    <div class="col-12 col-md-9 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($perusahaan[0]->kondisi[0]) && $perusahaan[0]->kondisi[0] == '1') ? 'readonly' : '' ?> class="form-control" id="kode" name="kode" placeholder="<?= lang('app.harus') ?>" value="<?= ($perusahaan[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="inisial" name="inisial" <?= ((isset($perusahaan[0]->kondisi[0]) && $perusahaan[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> maxlength="3" placeholder="<?= lang('app.harus') ?>" value="<?= ($perusahaan[0]->inisial ?? '') ?>" />
                            <label for="inisial"><?= lang('app.inisial') ?></label>
                            <div id="error" class="invalid-feedback errinisial"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" <?= ((isset($perusahaan[0]->kondisi[0]) && $perusahaan[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($perusahaan[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="alamat" name="alamat" placeholder=""><?= ($perusahaan[0]->alamat ?? '') ?></textarea>
                            <label for="alamat"><?= lang('app.alamat') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="telp" name="telp" placeholder="" value="<?= ($perusahaan[0]->telepon ?? '') ?>" />
                            <label for="telp"><?= lang('app.telp') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="kota" name="kota" placeholder="" value="<?= ($perusahaan[0]->kota ?? '') ?>" />
                            <label for="kota"><?= lang('app.kota') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="direktur" name="direktur" placeholder="" value="<?= ($perusahaan[0]->direktur ?? '') ?>" />
                            <label for="direktur"><?= lang('app.direktur') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($perusahaan[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($perusahaan[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($perusahaan[0]->aktifby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btnsubmit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btnsave" <?= $button['save'] ?>><?= lang('app.btn save') ?></button></li>
                                <li><button type="button" name="action" value="confirm" class="dropdown-item d-flex align-items-center btnsave" <?= $button['conf'] ?>><?= lang('app.btn konf') ?></button></li>
                                <li><button type="button" name="action" value="hapus" class="dropdown-item d-flex align-items-center btnsave" <?= $button['del'] ?>><?= lang('app.btn hapus') ?></button></li>
                                <li><button type="button" name="action" value="aktif" class="dropdown-item d-flex align-items-center btnsave" <?= $button['aktif'] ?>><?= $btnaktif ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card Footer -->
        </div> <!--/ Card awal -->
    </div> <!--/ Coloum kanan -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <img class="img-fluid img-preview" src="/assets/gambar/perusahaan/<?= ($perusahaan ? $perusahaan[0]->gambar : 'default.png') ?>">
                    </div>
                    <div class="col-12 mb-2">
                        <input type="file" class="form-control" id="gambar" name="gambar" onchange="previewImage()" />
                        <div id="error" class="invalid-feedback errgambar"></div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card aksi -->
    </div> <!--/ Column -->
</div> <!--/ Row-->
<?= form_close() ?>

<script>
    $('.btnsave').click(function(e) {
        e.preventDefault();
        var form = $('.formmain')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '<?= $link ?>/save';
        formData.append('postaction', getAction);
        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btnsubmit').attr('disabled', 'disabled');
                $('.btnsubmit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btnsubmit').removeAttr('disabled');
                $('.btnsubmit').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                $('#kode, #inisial, #deskripsi, #gambar').removeClass('is-invalid');
                $('.errkode, .errinisial, .errdeskripsi, .errgambar').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('inisial', response.error.inisial);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('gambar', response.error.gambar);
                } else {
                    window.location.href = response.redirect;
                }

                function handleFieldError(field, error) {
                    if (error) {
                        $('#' + field).addClass('is-invalid');
                        $('.err' + field).html(error);
                    } else {
                        $('#' + field).removeClass('is-invalid');
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    })
</script>

<?= $this->endSection() ?>
<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'formmain']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= ($penerima[0]->idunik ?? '') ?>" />

                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="kode" name="kode" <?= (isset($penerima[0]->kondisi[0]) && ($penerima[0]->kondisi[0] == '1' || $penerima[0]->is_alias[3] == '1')  ? 'readonly' : '') ?> maxlength="16" placeholder="<?= lang('app.harus') ?>" value="<?= ($penerima[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="kategori" name="kategori" data-allow-clear="true" data-placeholder="<?= lang('app.pilihcr') ?>">
                                <option value="" <?= (isset($penerima[0]->kategori) && $penerima[0]->kategori == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($kategori as $db) : ?>
                                    <option value="<?= $db->kategori ?>" <?= (isset($penerima[0]->kategori) && $penerima[0]->kategori == $db->kategori ? 'selected' : '') ?>><?= $db->kategori ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback errkategori"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-7 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($penerima[0]->kondisi[0]) && ($penerima[0]->kondisi[0] == '1' || $penerima[0]->is_alias[3] == '1') ? 'readonly' : '') ?> class="form-control" id="deskripsi" name="deskripsi" placeholder="<?= lang('app.harus') ?>" value="<?= ($penerima[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-5 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($penerima[0]->kondisi[0]) && $penerima[0]->is_alias[3] == '1' ? 'readonly' : '') ?> class="form-control" id="surel" name="surel" placeholder="" value="<?= ($penerima[0]->email ?? '') ?>" />
                            <label for="surel"><?= lang('app.surel') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" <?= (isset($penerima[0]->kondisi[0]) && $penerima[0]->is_alias[3] == '1' ? 'readonly' : '') ?> id="alamat" name="alamat" placeholder=""><?= ($penerima[0]->alamat ?? '') ?></textarea>
                            <label for="alamat"><?= lang('app.alamat') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" <?= (isset($penerima[0]->kondisi[0]) && $penerima[0]->is_alias[3] == '1' ? 'readonly' : '') ?> id="kontak" name="kontak" placeholder=""><?= ($penerima[0]->kontak ?? '') ?></textarea>
                            <label for="kontak"><?= lang('app.kontak') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-2 mb-4">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="pelanggan" name="pelanggan" data-toggle="toggle" data-width="90%" <?= (isset($penerima[0]->is_alias) && $penerima[0]->is_alias[0] == '1' ? 'checked' : '') ?>>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kelakun1" name="kelakun1" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($penerima[0]->kakun_pelanggan) && $penerima[0]->kakun_pelanggan == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($kelakun1 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($penerima[0]->kakun_pelanggan) && $penerima[0]->kakun_pelanggan == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kelakun1"><?= lang('app.noakun') ?></label>
                            <div id="error" class="invalid-feedback errkelakun1"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 mb-4">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="lain" name="lain" data-toggle="toggle" data-width="90%" <?= (isset($penerima[0]->is_alias) && $penerima[0]->is_alias[2] == '1' ? 'checked' : '') ?>>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kelakun2" name="kelakun2" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($penerima[0]->kakun_lain) && $penerima[0]->kakun_lain == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($kelakun2 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($penerima[0]->kakun_lain) && $penerima[0]->kakun_lain == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kelakun2"><?= lang('app.noakun') ?></label>
                            <div id="error" class="invalid-feedback errkelakun2"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-2 mb-4">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="suplier" name="suplier" data-toggle="toggle" data-width="90%" <?= (isset($penerima[0]->is_alias) && $penerima[0]->is_alias[1] == '1' ? 'checked' : '') ?>>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kelakun3" name="kelakun3" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($penerima[0]->kakun_suplier) && $penerima[0]->kakun_suplier == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($kelakun3 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($penerima[0]->kakun_suplier) && $penerima[0]->kakun_suplier == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kelakun3"><?= lang('app.noakun') ?></label>
                            <div id="error" class="invalid-feedback errkelakun3"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2 mb-4">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="pegawai" name="pegawai" data-toggle="toggle" data-width="90%" <?= (isset($penerima[0]->is_alias) && $penerima[0]->is_alias[3] == '1' ? 'checked' : '') ?> disabled>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kelakun4" name="kelakun4" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>" disabled>
                                <option value="" <?= (isset($penerima[0]->kakun_pegawai) && $penerima[0]->kakun_pegawai == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($kelakun4 as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($penerima[0]->kakun_pegawai) && $penerima[0]->kakun_pegawai == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kelakun4"><?= lang('app.noakun') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" <?= (isset($penerima[0]->kondisi[0]) && $penerima[0]->is_alias[3] == '1' ? 'readonly' : '') ?> id="catatan" name="catatan" placeholder=""><?= ($penerima[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($penerima[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($penerima[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($penerima[0]->aktifby ?? '') ?></div>
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
            </div> <!--/ Modal Footer -->
            <?= form_close() ?>

        </div> <!--/ Modal Content -->
    </div> <!--/ Modal Dialog -->
</div> <!--/ Modal fade -->

<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script>
    $("#param").on("change", () => $("#xparam").val($("#param").val()));

    function initializeBsToggle(selector, onLabel, offLabel, onStyle) {
        $(selector).bootstrapToggle({
            onlabel: onLabel,
            offlabel: offLabel,
            onstyle: onStyle
        });
    }

    $('#modal-input').on('shown.bs.modal', function() {
        initializeBsToggle('#pelanggan', '<?= lang('app.pelanggan') ?>', '<?= lang('app.no') ?>', 'primary');
        initializeBsToggle('#suplier', '<?= lang('app.suplier') ?>', '<?= lang('app.no') ?>', 'primary');
        initializeBsToggle('#lain', '<?= lang('app.subkon') ?>', '<?= lang('app.no') ?>', 'primary');
        initializeBsToggle('#pegawai', '<?= lang('app.pegawai') ?>', '<?= lang('app.no') ?>', 'primary');
    });

    $('.btnsave').click(function(e) {
        e.preventDefault();
        var form = $('.formmain')[0];
        var formData = new FormData(form);
        var getAction = $(this).val();
        var url = '<?= $link ?>/save';
        formData.append('postaction', getAction);
        $.ajax({
            type: 'POST',
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
                $('#kode, #deskripsi, #kategori, #kelakun1, #kelakun2, #kelakun3').removeClass('is-invalid');
                $('.errkode, .errdeskripsi, .errkategori, .errkelakun1, .errkelakun2, .errkelakun3').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('kategori', response.error.kategori);
                    handleFieldError('kelakun1', response.error.kelakun1);
                    handleFieldError('kelakun2', response.error.kelakun2);
                    handleFieldError('kelakun3', response.error.kelakun3);
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
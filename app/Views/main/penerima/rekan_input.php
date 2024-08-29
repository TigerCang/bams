<div class="modal fade" id="modal-input" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= json('modal input') ?>">
                <h4 class="modal-title judul-modal"><?= ($t_modal ?? '') ?></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?= form_open('', ['class' => 'formmain']) ?>
            <?= csrf_field() ?>
            <div class="modal-body">
                <input type="hidden" id="idunik" name="idunik" value="<?= ($alat[0]->idunik ?? '') ?>" />

                <div class="row g-2">
                    <div class="col-12 col-md-8 col-lg-9 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="penerima" name="penerima" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($penerima1) : ?> <option value="<?= $penerima1[0]->id ?>" selected data-subtext="<?= $penerima1[0]->nama ?>"><?= $penerima1[0]->kode ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback errpenerima"></div>
                            <label for="penerima"><?= lang('app.subkon') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="nomor" name="nomor" <?= (isset($alat[0]->kondisi[0]) && $alat[0]->kondisi[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.harus') ?>" maxlength="12" value="<?= ($alat[0]->nomor ?? '') ?>" />
                            <label for="nomor"><?= lang('app.nomor') ?></label>
                            <div id="error" class="invalid-feedback errnomor"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="model" name="model">
                                <?php foreach ($selbentuk as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($alat[0]->model) && $alat[0]->model == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="model"><?= lang('app.model') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="kategori" name="kategori" data-allow-clear="true" data-placeholder="<?= lang('app.pilihcr') ?>">
                                <option value="" <?= (isset($alat[0]->kategori) && $alat[0]->kategori == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selkategori as $db) : ?>
                                    <option value="<?= $db->kategori ?>" <?= (isset($alat[0]->kategori) && $alat[0]->kategori == $db->kategori ? 'selected' : '') ?>><?= $db->kategori ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kategori"><?= lang('app.kategori') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($alat[0]->kondisi[0]) && $alat[0]->kondisi[0] == '1' ? 'readonly' : '') ?> class="form-control" id="deskripsi" name="deskripsi" placeholder="<?= lang('app.harus') ?>" value="<?= ($alat[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($alat[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($alat[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($alat[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($alat[0]->aktifby ?? '') ?></div>
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
    $('.modal').on('shown.bs.modal', function() {
        $('#penerima').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "<?= $link ?>/penerima",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '00100',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });
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
                $('#penerima, #nomor, #deskripsi').removeClass('is-invalid');
                $('.errpenerima, .errnomor, .errdeskripsi').html('');
                if (response.error) {
                    handleFieldError('penerima', response.error.penerima);
                    handleFieldError('nomor', response.error.nomor);
                    handleFieldError('deskripsi', response.error.deskripsi);
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
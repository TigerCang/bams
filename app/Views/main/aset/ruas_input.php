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
                <input type="hidden" id="idunik" name="idunik" value="<?= ($ruas[0]->idunik ?? '') ?>" />
                <input type="hidden" id="idproyek" name="idproyek" value="<?= ($ruas[0]->proyek_id ?? '') ?>" />

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="proyek" name="proyek" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>" onchange="klikProyek()">
                                <?php if ($proyek1) : ?> <option value="<?= $proyek1[0]->id ?>" selected data-subtext="<?= $proyek1[0]->paket ?>"><?= $proyek1[0]->kode ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback errproyek"></div>
                            <label for="proyek"><?= lang('app.proyek') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="perusahaan" name="perusahaan" placeholder="" />
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="wilayah" name="wilayah" placeholder="" />
                            <label for="wilayah"><?= lang('app.wilayah') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($ruas[0]->kondisi[0]) && $ruas[0]->kondisi[0] == '1' ? 'readonly' : '') ?> class="form-control text-uppercase" id="kode" name="kode" maxlength="4" placeholder="<?= lang('app.harus') ?>" value="<?= ($ruas[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-9 col-lg-9 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($ruas[0]->kondisi[0]) && $ruas[0]->kondisi[0] == '1' ? 'readonly' : '') ?> class="form-control" id="deskripsi" name="deskripsi" placeholder="<?= lang('app.harus') ?>" value="<?= ($ruas[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($ruas[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($ruas[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($ruas[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($ruas[0]->aktifby ?? '') ?></div>
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
    $("#proyek").on("change", () => $("#idproyek").val($("#proyek").val()));

    $(document).ready(function() {
        $("#proyek").change();
    });

    function klikProyek() {
        var getProyek = $("#proyek").val();
        $.ajax({
            url: "<?= $link ?>/klikproyek",
            type: "POST",
            data: {
                proyek: getProyek,
            },
            dataType: "json",
            success: function(response) {
                if (Object.keys(response.perusahaan).length !== 0) {
                    $("#perusahaan").val(response.perusahaan);
                    $("#wilayah").val(response.wilayah);
                } else {
                    $("#perusahaan").val('');
                    $("#wilayah").val('');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $('.modal').on('shown.bs.modal', function() {
        $('#proyek').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "<?= $link ?>/proyek",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
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
                $('#proyek, #kode, #deskripsi').removeClass('is-invalid');
                $('.errproyek, .errkode, .errdeskripsi').html('');
                if (response.error) {
                    handleFieldError('proyek', response.error.proyek);
                    handleFieldError('kode', response.error.kode);
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
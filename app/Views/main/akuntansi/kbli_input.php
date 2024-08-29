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
                <input type="hidden" id="idunik" name="idunik" value="<?= ($kbli[0]->idunik ?? '') ?>" />
                <input type="hidden" id="xkategori" name="xkategori" value="<?= ($kbli[0]->param ?? 'dokumen ref') ?>">

                <div class="row g-2">
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kategori" name="kategori" <?= (isset($kbli[0]->kondisi[0]) && $kbli[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selkategori as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($kbli[0]->param) && $kbli[0]->param == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kategori"><?= lang('app.kategori') ?></label>
                        </div>
                    </div>
                    <div class="col-3 mb-4" id="zpilih1">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" <?= ((isset($kbli[0]->kondisi[0]) && $kbli[0]->kondisi[0] == '1') ? 'readonly' : '') ?> id="kode" name="kode" placeholder="" maxlength="5" value="<?= ($kbli[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-3 mb-4" id="zpilih2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control obpajak" <?= ((isset($kbli[0]->kondisi[0]) && $kbli[0]->kondisi[0] == '1') ? 'readonly' : '') ?> id="kode2" name="kode2" placeholder="" value="<?= ($kbli[0]->kode ?? '') ?>" data-mask="99-999-99" />
                            <label for="kode2"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode2"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" <?= ((isset($kbli[0]->kondisi[0]) && $kbli[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="" value="<?= ($kbli[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row" id="zpilih3">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="pajak" name="pajak" />
                            <?php foreach ($pajak as $db) : ?>
                                <option value="<?= $db->id ?>" <?= (isset($kbli[0]->pajak_id) && $kbli[0]->pajak_id == $db->id ? 'selected' : '') ?> data-subtext="<?= $db->nilai ?> %"><?= $db->nama ?></option>
                            <?php endforeach ?>
                            </select>
                            <label for="pajak"><?= lang('app.pajak') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($kbli[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($kbli[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($kbli[0]->aktifby ?? '') ?></div>
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

<script src="<?= base_url('libraries') ?>/cang/form-masking/form-mask.js"></script>
<script src="<?= base_url('libraries') ?>/cang/js/select2.js"></script>
<script>
    $("#kategori").change(function() {
        $("#xkategori").val($(this).val());
        $('#zpilih1, #zpilih2, #zpilih3').removeAttr('hidden');
        if ($("#xkategori").val() == '' || $("#xkategori").val() == 'dokumen ref') {
            $('#zpilih1, #zpilih2, #zpilih3').attr('hidden', 'hidden');
        } else if ($("#xkategori").val() == 'objek pajak') {
            $('#zpilih1').attr('hidden', 'hidden');
        } else if ($("#xkategori").val() == 'kode baku') {
            $('#zpilih2, #zpilih3').attr('hidden', 'hidden');
        }
    });

    $(document).ready(function() {
        $("#kategori").trigger("change");
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
                $('#kode, #kode2, #deskripsi').removeClass('is-invalid');
                $('.errkode, .errkode2, .errdeskripsi').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('kode2', response.error.kode2);
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
    $(document).ready(function() {

    });
</script>
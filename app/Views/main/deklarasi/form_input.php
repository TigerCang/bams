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
                <input type="hidden" id="idunik" name="idunik" value="<?= ($form[0]->idunik ?? '') ?>" />

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="param" name="param" placeholder="" value="<?= lang('app.' . $param) ?>" />
                            <label for="param"><?= lang('app.kategori') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="form" name="form" <?= (isset($form[0]->kondisi[0]) && $form[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selkel as $db1) : ?>
                                    <optgroup label="<?= lang('app.' . $db1->kelompok) ?>">
                                        <?php foreach ($selnama as $db) : ?>
                                            <?php if ($db->kelompok == $db1->kelompok) : ?><option value="<?= $db->nama ?>" <?= (isset($form[0]->sub_param) && $form[0]->sub_param == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option><?php endif ?>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback errform"></div>
                            <label for="form"><?= lang('app.form') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="kode" name="kode" <?= ((isset($form[0]->kondisi[0]) && $form[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($form[0]->nama ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                </div>
                <div class="row" <?= $phid ?>>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="perusahaan" name="perusahaan">
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($form[0]->perusahaan_id) && $form[0]->perusahaan_id == $db->id ? 'selected' : '') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($form[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($form[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($form[0]->aktifby ?? '') ?></div>
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
                $('#form, #kode').removeClass('is-invalid');
                $('.errform, .errkode').html('');
                if (response.error) {
                    handleFieldError('form', response.error.form);
                    handleFieldError('kode', response.error.kode);
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
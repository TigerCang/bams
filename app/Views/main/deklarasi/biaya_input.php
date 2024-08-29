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
                <input type="hidden" id="idunik" name="idunik" value="<?= ($biaya[0]->idunik ?? '') ?>" />
                <input type="hidden" id="xakun" name="xakun" value="<?= ($biaya[0]->akun_id ?? '') ?>" />

                <div class="row g-2">
                    <div class="col-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($biaya[0]->kondisi[0]) && $biaya[0]->kondisi[0] == '1') ? 'readonly' : '' ?> class="form-control text-uppercase" id="kode" name="kode" maxlength="8" placeholder="<?= lang('app.harus') ?>" value="<?= ($biaya[0]->kode ?? '') ?>" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-6 mb-4" <?= $mphid ?>>
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="matabayar" name="matabayar" placeholder="" value="<?= ($biaya[0]->matabayar ?? '') ?>" />
                            <label for="matabayar"><?= lang('app.mata bayar') ?></label>
                        </div>
                    </div>
                    <div class="col-3 mb-4" <?= $jlhid ?>>
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="voljl" name="voljl" data-toggle="toggle" <?= (isset($biaya[0]->is_jumlah) && $biaya[0]->is_jumlah == '1' ? 'checked' : '') ?>>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" <?= ((isset($biaya[0]->kondisi[0]) && $biaya[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($biaya[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-7 col-lg-8 mb-4" <?= $khid ?>>
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kategori" name="kategori">
                                <?php foreach ($kategori as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($biaya[0]->kate_id) && $biaya[0]->kate_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kategori"><?= lang('app.kategori') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="satuan" name="satuan" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <option value="" <?= (isset($biaya[0]->satuan) && $biaya[0]->satuan == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($satuan as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($biaya[0]->satuan) && $biaya[0]->satuan == $db->nama ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="satuan"><?= lang('app.satuan') ?></label>
                            <div id="error" class="invalid-feedback errsatuan"></div>
                        </div>
                    </div>
                </div>
                <div class="row" <?= $ahid ?>>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="akun" name="akun" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>" <?= ((isset($biaya[0]->kondisi[0]) && $biaya[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php if ($akun1) : ?> <option value="<?= $akun1[0]->id ?>" selected data-subtext="<?= $akun1[0]->nama ?>"><?= $akun1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="akun"><?= lang('app.noakun') ?></label>
                            <div id="error" class="invalid-feedback errakun"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($biaya[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($biaya[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($biaya[0]->aktifby ?? '') ?></div>
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
    $("#akun").on("change", () => $("#xakun").val($("#akun").val()));
    $('.modal').on('shown.bs.modal', function() {
        $('#voljl').bootstrapToggle({
            onlabel: '<?= lang('app.vol+') ?>',
            offlabel: '<?= lang('app.no') ?>',
            onstyle: 'success',
        });

        $('#akun').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "<?= $link ?>/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        awal: '6',
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
                $('#kode, #deskripsi, #satuan, #akun').removeClass('is-invalid');
                $('.errkode, .errdeskripsi, .errsatuan, .errakun').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('satuan', response.error.satuan);
                    handleFieldError('akun', response.error.akun);
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
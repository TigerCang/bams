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
                <input type="hidden" id="idunik" name="idunik" value="<?= ($kelakun[0]->idunik ?? '') ?>" />
                <input type="hidden" id="xparam" name="xparam" value="<?= ($kelakun[0]->param ?? '') ?>">
                <input type="hidden" id="xsubparam" name="xsubparam" value="<?= ($kelakun[0]->sub_param ?? '') ?>">

                <div class="row g-2">
                    <div class="col-12 col-md-12 col-lg-8 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kelompok" name="kelompok" <?= (isset($kelakun[0]->kondisi[0]) && $kelakun[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selkel as $db1) : ?>
                                    <optgroup label="<?= lang('app.' . $db1->kelompok) ?>">
                                        <?php foreach ($selnama as $db) : ?>
                                            <?php if ($db->kelompok == $db1->kelompok) : ?><option value="<?= $db->nama ?>" data-param="<?= $db1->kelompok ?>" <?= (isset($kelakun[0]->sub_param) && $kelakun[0]->sub_param == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option><?php endif ?>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback errkelompok"></div>
                            <label for="kelompok"><?= lang('app.kelompok') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 mb-4" id="znilai">
                        <div class="form-floating form-floating-outline">
                            <input type="number" step="0.01" class="form-control" id="nilai" name="nilai" placeholder="" value="<?= ($kelakun[0]->nilai ?? '0') ?>" min="0" max="1000" />
                            <label for="nilai" id="zumur"><?= lang('app.umur') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($kelakun[0]->kondisi[0]) && $kelakun[0]->kondisi[0] == '1' ? 'readonly' : '') ?> class="form-control" id="deskripsi" name="deskripsi" placeholder="<?= lang('app.harus') ?>" value="<?= ($kelakun[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row" id="zperusahaan">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="perusahaan" name="perusahaan">
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($kelakun[0]->perusahaan_id) && $kelakun[0]->perusahaan_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][0] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback errperusahaan"></div>
                            <label for="perusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2" id="zwilayah">
                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="wilayah" name="wilayah">
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($kelakun[0]->wilayah_id) && $kelakun[0]->wilayah_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][1] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback errwilayah"></div>
                            <label for="wilayah"><?= lang('app.wilayah') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="divisi" name="divisi">
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($kelakun[0]->divisi_id) && $kelakun[0]->divisi_id == $db->id ? 'selected' : '') . ($tuser['act_akses'][2] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach ?>
                            </select>
                            <div id="error" class="invalid-feedback errdivisi"></div>
                            <label for="divisi"><?= lang('app.divisi') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="akun1" name="akun1" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($akun1) : ?> <option value="<?= $akun1[0]->id ?>" selected data-subtext="<?= $akun1[0]->nama ?>"><?= $akun1[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="akun1" id="zlabel1"><?= lang('app.noakun') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 mb-4" id="zakun2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="akun2" name="akun2" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($akun2) : ?> <option value="<?= $akun2[0]->id ?>" selected data-subtext="<?= $akun2[0]->nama ?>"><?= $akun2[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="akun2" id="zlabel2"><?= lang('app.noakun') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-12 col-md-12 col-lg-6 mb-4" id="zakun3">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="akun3" name="akun3" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($akun3) : ?> <option value="<?= $akun3[0]->id ?>" selected data-subtext="<?= $akun3[0]->nama ?>"><?= $akun3[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="akun3" id="zlabel3"><?= lang('app.uang jalan') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline" id="zakun4">
                            <select class="select2-subtext form-select" id="akun4" name="akun4" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if ($akun4) : ?> <option value="<?= $akun4[0]->id ?>" selected data-subtext="<?= $akun4[0]->nama ?>"><?= $akun4[0]->kode ?></option><?php endif ?>
                            </select>
                            <label for="akun4" id="zlabel4"><?= lang('app.kasbon') ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($kelakun[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($kelakun[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($kelakun[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($kelakun[0]->aktifby ?? '') ?></div>
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
    $("#kelompok").change(function() {
        $("#xsubparam").val($("#kelompok").val());
        var menu = "<?= $link ?>";
        var param = $("#kelompok").find(':selected').data('param');
        $("#xparam").val(param);

        if (menu == '/akungrup') {
            switch (param) {
                case 'aset':
                    $('#znilai, #zakun2').removeAttr('hidden');
                    $('#zakun3, #zakun4').attr('hidden', 'hidden');
                    $('#zlabel1').text('<?= lang('app.aset') ?>');
                    $('#zlabel2').text('<?= lang('app.susut') ?>');
                    break;
                case 'penerima':
                    $('#znilai').attr('hidden', 'hidden');
                    $('#zakun2, #zakun3, #zakun4').removeAttr('hidden');
                    $('#zlabel1').text('<?= lang('app.uang muka') ?>');
                    $('#zlabel2').text('<?= lang('app.uang masuk') ?>');
                    break;
                case 'stok':
                    $('#znilai, #zakun2, #zakun3, #zakun4').attr('hidden', 'hidden');
                    $('#zlabel1').text('<?= lang('app.stok') ?>');
                    break;
                default:
                    break;
            }
            $('#zumur').text('<?= lang('app.umur') ?>');
        } else if (menu == '/akunpajak') {
            $('#zumur').text('<?= lang('app.nilai') ?> (%)');
        }
    });

    function loadsubmenu() {
        var menu = "<?= $link ?>";
        switch (menu) {
            case '/akunpajak':
                $('#zperusahaan, #zwilayah, #zakun2, #zakun3, #zakun4').attr('hidden', 'hidden');
                $('#znilai').removeAttr('hidden');
                break;
            case '/akunkas':
                $('#zperusahaan, #zwilayah').removeAttr('hidden');
                $('#znilai, #zakun2, #zakun3, #zakun4').attr('hidden', 'hidden');
                break;
            case '/akungrup':
                $('#zperusahaan, #zwilayah, #znilai, #zakun2, #zakun3, #zakun4').attr('hidden', 'hidden');
                break;
            default:
                break;
        }
    }

    $(document).ready(function() {
        loadsubmenu();
        $("#kelompok").trigger("change");
    });

    $('.modal').on('shown.bs.modal', function() {
        $('#akun1, #akun2, #akun3, #akun4').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "<?= $link ?>/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        awal: '',
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
                $('#deskripsi').removeClass('is-invalid');
                $('.errdeskripsi').html('');
                if (response.error) {
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
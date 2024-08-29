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
                <input type="hidden" id="idunik" name="idunik" value="<?= ($akun[0]->idunik ?? '') ?>" />
                <input type="hidden" id="xkategori" name="xkategori" value="<?= ($akun[0]->kategori ?? '1-harta') ?>">

                <div class="row g-2">
                    <div class="col-6 col-md-5 col-lg-5 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($akun[0]->kondisi[0]) && $akun[0]->kondisi[0] == '1') ? 'readonly' : '' ?> class="form-control noakun" id="kode" name="kode" placeholder="" value="<?= (empty($akun) ? '' : substr($akun[0]->kode, -7)) ?>" data-mask="999.9999" />
                            <label for="kode"><?= lang('app.kode') ?></label>
                            <div id="error" class="invalid-feedback errkode"></div>
                        </div>
                    </div>
                    <div class="col-6 col-md-5 col-lg-6 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="noakun" name="noakun" placeholder="" value="<?= ($akun[0]->kode ?? '') ?>" />
                            <label for="noakun"><?= lang('app.noakun') ?></label>
                        </div>
                    </div>
                    <div class="col-3 col-md-2 col-lg-1 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="level" name="level" value="<?= ($akun[0]->level ?? '') ?>" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" <?= ((isset($akun[0]->kondisi[0]) && $akun[0]->kondisi[0] == '1') ? ($tuser['act_akses'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="" value="<?= ($akun[0]->nama ?? '') ?>" />
                            <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                            <div id="error" class="invalid-feedback errdeskripsi"></div>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-9 mb-4">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="kategori" name="kategori" <?= (isset($akun[0]->kondisi[0]) && $akun[0]->kondisi[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($selkategori as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (isset($akun[0]->kategori) && $akun[0]->kategori == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="kategori"><?= lang('app.kategori') ?></label>
                        </div>
                    </div>
                    <div class="col-3 mb-4">
                        <div class="d-flex align-items-center">
                            <input type="checkbox" id="posisi" name="posisi" data-toggle="toggle" <?= (isset($akun[0]->posisi) && $akun[0]->posisi == 'kredit' ? '' : 'checked') ?>>
                        </div>
                    </div>
                </div>
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($akun[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($akun[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($akun[0]->aktifby ?? '') ?></div>
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
    $("#kode").on("change", () => $("#noakun").val($("#kategori").val().charAt(0) + $("#kode").val()));
    $('#modal-input').on('shown.bs.modal', function() {
        $('#posisi').bootstrapToggle({
            onlabel: '<?= lang('app.debit') ?>',
            offlabel: '<?= lang('app.kredit') ?>',
            onstyle: 'success',
            offstyle: 'warning'
        });
    });

    $('#kategori').change(function() {
        $("#kode").change();
        $('#xkategori').val($(this).val());
        var angka = $(this).val().charAt(0); // ambil satu huruf dari kategori yang dipilih
        if (angka == '1' || angka == '3' || angka == '5' || angka == '6' || angka == '8') {
            $('#posisi').bootstrapToggle('on'); // Menyalakan checkbox
        } else {
            $('#posisi').bootstrapToggle('off');
        }
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
                $('#kode, #deskripsi').removeClass('is-invalid');
                $('.errkode, .errdeskripsi').html('');
                if (response.error) {
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
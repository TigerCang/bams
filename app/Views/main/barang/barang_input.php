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
                <input type="hidden" id="idunik" name="idunik" value="<?= ($barang[0]->idunik ?? '') ?>" />
                <input type="hidden" name="namagambar" value="<?= ($barang[0]->gambar ?? 'default.png') ?>">

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8">
                        <div class="row g-2">
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control text-uppercase barang" id="kode" name="kode" <?= (isset($barang[0]->kondisi[0]) && $barang[0]->kondisi[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.harus') ?>" value="<?= ($barang[0]->kode ?? '') ?>" data-mask="aaaa-aaaa.999" />
                                    <label for="kode"><?= lang('app.kode') ?></label>
                                    <div id="error" class="invalid-feedback errkode"></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="partnumber" name="partnumber" placeholder="" value="<?= ($barang[0]->partnumber ?? '') ?>" />
                                    <label for="partnumber"><?= lang('app.part number') ?></label>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg-4 mb-4">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" id="serial" name="serial" data-toggle="toggle" data-width="100%" <?= (isset($barang[0]->sebes) && $barang[0]->sebes[0] == '1' ? 'checked' : '') ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="<?= lang('app.harus') ?>" value="<?= ($barang[0]->nama ?? '') ?>" />
                                    <label for="deskripsi"><?= lang('app.deskripsi') ?></label>
                                    <div id="error" class="invalid-feedback errdeskripsi"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-md-12 col-lg-6 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-tokenizer form-select" id="kategori" name="kategori" data-placeholder="<?= lang('app.pilihcr') ?>">
                                        <option value="" <?= (isset($barang[0]->kategori) && $barang[0]->kategori == '' ? 'selected' : '') ?>></option>
                                        <?php foreach ($kategori as $db) : ?>
                                            <option value="<?= $db->kategori ?>" <?= (isset($barang[0]->kategori) && $barang[0]->kategori == $db->kategori ? 'selected' : '') ?>><?= $db->kategori ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <div id="error" class="invalid-feedback errkategori"></div>
                                    <label for="kategori"><?= lang('app.kategori') ?></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-tokenizer form-select" id="merk" name="merk" data-allow-clear="true" data-placeholder="<?= lang('app.pilihcr') ?>">
                                        <option value="" <?= (isset($barang[0]->merk) && $barang[0]->merk == '' ? 'selected' : '') ?>></option>
                                        <?php foreach ($merk as $db) : ?>
                                            <option value="<?= $db->merk ?>" <?= (isset($barang[0]->merk) && $barang[0]->merk == $db->merk ? 'selected' : '') ?>><?= $db->merk ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="merk"><?= lang('app.merk') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6 col-md-6 col-lg-3 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-non form-select" id="satuan" name="satuan">
                                        <?php foreach ($satuan as $db) : ?>
                                            <option value="<?= $db->nama ?>" <?= (isset($barang[0]->satuan) && $barang[0]->satuan == $db->nama ? 'selected' : '') ?>><?= $db->nama ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="satuan"><?= lang('app.satuan') ?></label>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" class="form-control" id="stokmin" name="stokmin" placeholder="" value="<?= $barang[0]->stokmin ?? '0' ?>" min="0" max="100" />
                                    <label for="stokmin"><?= lang('app.stok min') ?></label>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 mb-4">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" id="stok" name="stok" data-toggle="toggle" data-width="100%" <?= (isset($barang[0]->sebes) && $barang[0]->sebes[2] == '1' ? 'checked' : '') ?>>
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-3 mb-4">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" id="bekas" name="bekas" data-toggle="toggle" data-width="100%" <?= (isset($barang[0]->sebes) && $barang[0]->sebes[1] == '1' ? 'checked' : '') ?>>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="zakun">
                            <div class="col-12 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-non form-select" id="kelakun" name="kelakun">
                                        <?php foreach ($kelakun as $db) : ?>
                                            <option value="<?= $db->id ?>" <?= (isset($barang[0]->kakun_id) && $barang[0]->kakun_id == $db->id ? 'selected' : '') ?>><?= $db->nama ?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="kelakun"><?= lang('app.kelompok akun') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                        </div>
                    </div> <!--/ End awal kiri-->

                    <div class="col-12 col-md-12 col-lg-4">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <img class="img-fluid img-preview" src="/assets/gambar/barang/<?= ($barang ? $barang[0]->gambar : 'default.png') ?>">
                            </div>
                            <div class="col-12 mb-2">
                                <input type="file" class="form-control" id="gambar" name="gambar" onchange="previewImage()" />
                                <div id="error" class="invalid-feedback errgambar"></div>
                            </div>
                        </div>
                    </div> <!--/ End Gambar-->
                </div> <!--/ End awal -->

                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="catatan" name="catatan" placeholder=""><?= ($barang[0]->catatan ?? '') ?></textarea>
                            <label for="catatan"><?= lang('app.catatan') ?></label>
                        </div>
                    </div>
                </div> <!--/ End catatan-->
            </div> <!--/ Modal Body -->

            <div class="modal-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.saby") ?> :</small>
                        <div class="form-text"><?= ($barang[0]->saveby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.coby") ?> :</small>
                        <div class="form-text"><?= ($barang[0]->confby ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $acby ?> :</small>
                        <div class="form-text"><?= ($barang[0]->aktifby ?? '') ?></div>
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
    $('#stok').change(function() {
        if ($(this).prop('checked')) {
            $('#zakun').removeAttr('hidden');
        } else {
            $('#zakun').attr('hidden', 'hidden');
        }
    });

    function initializeBsToggle(selector, onLabel, offLabel, onStyle) {
        $(selector).bootstrapToggle({
            onlabel: onLabel,
            offlabel: offLabel,
            onstyle: onStyle
        });
    }

    $('#modal-input').on('shown.bs.modal', function() {
        initializeBsToggle('#serial', '<?= lang('app.noseri') ?>', '<?= lang('app.no') ?>', 'success');
        initializeBsToggle('#bekas', '<?= lang('app.bekas') ?>', '<?= lang('app.no') ?>', 'warning');
        initializeBsToggle('#stok', '<?= lang('app.stok') ?>', '<?= lang('app.no') ?>', 'primary');
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
                $('#kode, #deskripsi, #kategori, #gambar').removeClass('is-invalid');
                $('.errkode, .errdeskripsi, .errkategori, .errgambar').html('');
                if (response.error) {
                    handleFieldError('kode', response.error.kode);
                    handleFieldError('deskripsi', response.error.deskripsi);
                    handleFieldError('kategori', response.error.kategori);
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
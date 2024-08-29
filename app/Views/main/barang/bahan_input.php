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
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <select class="select2-subtext form-select" id="biaya" name="biaya" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>" onchange="loadSatuan()">
                                        <?php if ($biaya1) : ?> <option value="<?= $biaya1[0]->id ?>" selected data-subtext="<?= $biaya1[0]->nama ?>"><?= $biaya1[0]->kode ?></option><?php endif ?>
                                    </select>
                                    <div id="error" class="invalid-feedback errbiaya"></div>
                                    <label for="biaya"><?= lang('app.sumber daya') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-md-8 col-lg-8 mb-4">
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
                            <div class="col-6 col-md-4 col-lg-4 mb-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" readonly class="form-control" id="satuan" name="satuan" placeholder="" value="<?= ($barang[0]->satuan ?? '') ?>" />
                                    <label for="satuan"><?= lang('app.satuan') ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                            <div class="col-6 mb-4" id="zharga">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="harga" name="harga" placeholder="" value="<?= ($barang[0]->harga ?? '') ?>" />
                                    <label for="harga"><?= lang('app.harga') ?></label>
                                </div>
                            </div>
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
    function loadSatuan() {
        var getBiaya = $("#biaya").val();
        $.ajax({
            type: "POST",
            url: "/bahan/satuan",
            data: {
                biaya: getBiaya,
            },
            dataType: "json",
            success: function(response) {
                if (response.satuan) {
                    $("#satuan").val(response.satuan);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $('#modal-input').on('shown.bs.modal', function() {
        $('#biaya').select2({
            dropdownParent: $('.modal'),
            ajax: {
                url: "<?= $link ?>/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        param: 'biayasd',
                        ruas: '0000',
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
                $('#biaya, #kategori, #gambar').removeClass('is-invalid');
                $('.errbiaya, .errkategori, .errgambar').html('');
                if (response.error) {
                    handleFieldError('biaya', response.error.biaya);
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
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formfile']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= ($serial ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= ($serial ? lang('app.detildata') : lang('app.inputdata')) ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="niaktif" name="niaktif" value="<?= (($serial && $serial[0]->is_aktif == '0') ? '1' : '0') ?>">
                    <div class="form-group row">
                        <label for="barang" class="col-sm-1 col-form-label"><?= lang('app.item') ?></label>
                        <div class="col-sm-11">
                            <select id="barang" class="js-example-basic-single" name="barang">
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($barang as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (($serial && $serial[0]->barang_id == $db->id) ? 'selected' : '') ?>><?= "{$db->kode} => {$db->nama}" ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errbarang"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="noseri" class="col-sm-1 col-form-label"><?= lang('app.noseri') ?></label>
                        <div class="col-sm-5">
                            <input type="text" harusisi class="form-control" <?= (($serial && $serial[0]->is_confirm == '1') ? 'readonly' : '') ?> id="noseri" name="noseri" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($serial[0]->noseri ?? '') ?>">
                            <div id="error" class="invalid-feedback errnoseri"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="harga" class="col-sm-1 col-form-label"><?= lang('app.harga') ?></label>
                        <div class="col-sm-2">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" maxlength="11" placeholder="<?= lang('app.harusisi') ?>" value="<?= ($serial[0]->harga ?? '') ?>">
                            <div id="error" class="invalid-feedback errharga"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="perbaikan" class="col-sm-1 col-form-label"><?= lang('app.perbaikan') ?></label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="perbaikan" name="perbaikan" placeholder="0 - 20" value="<?= ($serial[0]->reparasi ?? '') ?>" min="0" max="20">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alat" class="col-sm-1 col-form-label"><?= lang('app.alat') ?></label>
                        <div class="col-sm-11">
                            <select id="alat" class="js-example-data-ajax" name="alat">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                                <?php if ($alat1) : ?><option value="<?= $alat1[0]->id ?>" selected><?= "{$alat1[0]->kode} ; {$alat1[0]->nomor} => {$alat1[0]->nama}" ?></option><?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div></div>
                        <div>
                            <button type="reset" class="btn <?= lang('app.btncReset') ?>" <?= $btnhid ?>><?= lang('app.btnReset') ?></button>
                            <button type="button" name="action" value="aktif" class="btn <?= $btnclas2 ?> btnsave" <?= $actaktif ?>><?= $btntext2 ?></button>
                            <button type="button" name="action" value="confirm" class="btn <?= lang('app.btncConfirm') ?> btnsave" <?= $btnsama . $actconf ?>><?= lang('app.btnConfirm') ?></button>
                            <button type="button" name="action" value="save" class="btn <?= $btnclas1 ?> btnsave" <?= $actcreate ?>><?= $btntext1 ?></button>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.upby") . ' : ' . ($serial[0]->upby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.confby") . ' : ' . ($serial[0]->coby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.acby") . ' : ' . ($serial[0]->akby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    function klikalat() {
        var getNama = $("#namaalat").val();
        $.ajax({
            url: "/noseri/alat",
            data: {
                perusahaan: '',
                wilayah: '',
                divisi: '',
                isi: getNama,
                werbipakxo: '0000000001',
                pilih: 'multi',
            },
            dataType: "json",
            success: function(response) {
                $('.modallampiran').html(response.data).show();
                $('#modal-lampiran').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        $("#barang").select2({
            ajax: {
                url: "/noseri/barang",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilihan: 'barang',
                        sn: '1',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum") ?>,
        });

        $("#alat").select2({
            ajax: {
                url: "/noseri/alat",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilihan: 'multi',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum") ?>,
        });

        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formfile')[0];
            var formData = new FormData(form);
            var getAction = $(this).val();
            var url = '/noseri/save';
            formData.append('postaction', getAction);
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnsave').attr('disabled', 'disabled');
                    $('.btnsave').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnsave').removeAttr('disabled');
                    $('.btnsave').each(function() {
                        var value = $(this).val();
                        if (value === 'aktif') {
                            $(this).html('<?= $btntext2 ?>');
                        } else if (value === 'confirm') {
                            $(this).html('<?= lang("app.btnConfirm") ?>');
                        } else if (value === 'save') {
                            $(this).html('<?= $btntext1 ?>');
                        }
                        $(this).attr('name', 'action');
                    });
                },
                success: function(response) {
                    $('#barang, #noseri, #harga').removeClass('is-invalid');
                    $('.errbarang, .errnoseri, .errharga').html('');
                    if (response.error) {
                        handleFieldError('barang', response.error.barang);
                        handleFieldError('noseri', response.error.noseri);
                        handleFieldError('harga', response.error.harga);
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
    });
</script>

<?= $this->endSection() ?>
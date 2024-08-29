<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php $ada = (($anggaran && $anggaran[0]->is_confirm == '1') ? 'bghead2' : 'bghead') ?>
<div class="page-body">
    <?= form_open('', ['class' => 'formfile']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" class="form-control" id="akses" name="akses" value="">
            <div class="invalid-feedback errakses alert background-danger" role="alert"></div>

            <div class="card">
                <div class="card-header <?= (($anggaran && $anggaran[0]->is_confirm == '1') ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.pilihan') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" id="awal" name="awal" value="0">
                    <input type="hidden" class="form-control" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="niaktif" name="niaktif" value="<?= (($anggaran && $anggaran[0]->is_aktif == '0') ? '1' : '0') ?>">
                    <input type="hidden" class="form-control" id="xpilih" name="xpilih" value="<?= ($anggaran[0]->pilihan ?? '') ?>">
                    <input type="hidden" class="form-control" id="xtujuan" name="xtujuan" value="<?= ($anggaran[0]->tujuan ?? '') ?>">
                    <input type="hidden" class="form-control" id="xjenis" name="xjenis" value="<?= ($anggaran[0]->jenis ?? '') ?>">
                    <div class="form-group row">
                        <label for="pilih" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?></label>
                        <div class="col-sm-4">
                            <select id="pilih" class="js-example-basic-single" name="pilih" <?= ($anggaran ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selanggaran as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (($anggaran && $anggaran[0]->pilihan == $db->nama) ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errpilih"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tujuan" class="col-sm-1 col-form-label"><?= lang('app.tujuan') ?></label>
                        <div class="col-sm-4">
                            <select id="tujuan" class="js-example-basic-single" name="tujuan" <?= (($anggaran && $anggaran[0]->is_confirm != '3') ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selnama as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (($anggaran && $anggaran[0]->tujuan == $db->nama) ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errtujuan"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zjenis">
                        <div class="col-sm-7"></div>
                        <label for="jenis" class="col-sm-1 col-form-label"><?= lang('app.jenis') ?></label>
                        <div class="col-sm-4">
                            <select id="jenis" class="js-example-basic-single" name="jenis" <?= ($anggaran ? 'disabled' : '') ?>>
                                <option value="" selected disabled><?= lang('app.pilih-') ?></option>
                                <?php foreach ($kategori as $db) : ?>
                                    <option value="<?= $db->kode ?>" <?= (($anggaran && $anggaran[0]->jenis == $db->kode) ? 'selected' : '') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errjenis"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="card">
                <div class="card-header <?= (($anggaran && $anggaran[0]->is_confirm == '1') ? lang('app.bgDetil') : lang('app.bgInput')) ?>">
                    <h5><?= lang('app.inputdata') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row" id="zbiaya">
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                        <div class="col-sm-11">
                            <select id="biaya" class="js-example-data-ajax" name="biaya">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errbiaya"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zakun">
                        <label for="akun" class="col-sm-1 col-form-label"><?= lang('app.noakun') ?></label>
                        <div class="col-sm-11">
                            <select id="akun" class="js-example-data-ajax" name="akun">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errakun"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bulan" class="col-sm-1 col-form-label"><?= ucfirst(lang('app.bulan')) ?></label>
                        <div class="col-sm-1">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="bulan" name="bulan" onchange="hitungtotal()" />
                        </div>
                        <label for="jumlah" class="col-sm-1 col-form-label">&emsp;<?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" onchange="hitungtotal()" />
                        </div>
                        <label for="harga" class="col-sm-1 col-form-label">&emsp;<?= lang('app.harga') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="total" class="col-sm-1 col-form-label">&emsp;<?= lang('app.total') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="total" name="total" />
                            <div class="invalid-feedback errtotal"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"></textarea>
                            <div class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4"></div>
                        <div class="col-4 text-center">
                            <button type="button" name="action" value="aktif" class="btn <?= $btnclas2 ?> btnsave" <?= $actaktif . $btnbaru ?>><?= $btntext2 ?></button>
                            <button type="button" name="action" value="confirm" class="btn <?= lang('app.btncConfirm') ?> btnsave" <?= $btnsama . $actconf . $btnbaru ?>><?= lang('app.btnConfirm') ?></button>
                            <button type="button" name="action" value="save" class="btn <?= lang('app.btncSave') ?> btnsave" <?= $actcreate ?>><?= lang('app.btnSave') ?></button>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" class="btn <?= lang('app.btncAdd') ?> btnadd" <?= $actcreate ?>><?= lang('app.btnAdd') ?></button>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.upby") . ' : ' . ($anggaran[0]->upby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.confby") . ' : ' . ($anggaran[0]->coby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <span><?= lang("app.acby") . ' : ' . ($anggaran[0]->akby ?? '') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabelbudget"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#pilih, #tujuan, #jenis").change(function() {
        if (this.id === 'pilih') {
            $("#xpilih").val($(this).val());
            var pilihValue = $(this).val();
            document.getElementById('awal').value = (pilihValue === 'pendapatan') ? '4' : '6';
        } else if (this.id === 'tujuan') {
            $("#xtujuan").val($("#tujuan").val());
            const isProyek = document.getElementById('xtujuan').value === 'proyek';
            $('#zjenis, #zbiaya').attr('hidden', !isProyek);
            $('#zakun').attr('hidden', isProyek);
        } else if (this.id === 'jenis') {
            $("#xjenis").val($(this).val());
            $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
        }
    });

    function hitungtotal() {
        if (document.getElementById('bulan').value === '') document.getElementById('bulan').value = '0,00'
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'
        var bulan = formatAngka(document.getElementById('bulan').value, 'nol');
        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var total = parseFloat(bulan) * parseFloat(jumlah) * parseFloat(harga);
        $('#total').val(formatAngka(total, 'rp'));
        // document.getElementById('total').value = formatAngka(total, 'rp');
    }

    function databudget() {
        var getIDU = "<?= $idunik ?>";
        var getTujuan = $("#xtujuan").val();
        var getAda = "<?= $ada ?>";
        $.ajax({
            url: "/anggaran/tabbudget",
            data: {
                idunik: getIDU,
                tujuan: getTujuan,
                ada: getAda,
            },
            dataType: "json",
            success: function(response) {
                $('.tabelbudget').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        $("#pilih, #tujuan").trigger("change");
        databudget();

        $("#biaya").select2({
            ajax: {
                url: "/anggaran/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: 'biaya',
                        ruas: '',
                        awal: $('#jenis').val().substring(0, 2),
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
        })

        $("#akun").select2({
            ajax: {
                url: "/anggaran/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        awal: $("#awal").val(),
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

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formfile')[0];
            var formData = new FormData(form);
            var url = '/anggaran/additem';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnadd').attr('disable', 'disabled');
                    $('.btnadd').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnadd').removeAttr('disable');
                    $('.btnadd').html('<?= lang('app.btnAdd') ?>');
                },
                success: function(response) {
                    $('#akses, #pilih, #tujuan, #jenis, #biaya, #akun, #total, #catatan').removeClass('is-invalid');
                    $('.errakses, .errpilih, .errtujuan, .errjenis, .errbiaya, .errakun, .errtotal, .errcatatan').html('');
                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('pilih', response.error.pilih);
                        handleFieldError('tujuan', response.error.tujuan);
                        handleFieldError('jenis', response.error.jenis);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('akun', response.error.akun);
                        handleFieldError('total', response.error.total);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        databudget();
                    }

                    function handleFieldError(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(error);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                        }
                    }

                    function clearElements() {
                        $('#pilih, #jenis').attr('disabled', 'disabled');
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#bulan, #jumlah, #harga, #total, #catatan").val('');
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
            return false;
        })

        $('.btnsave').click(function(e) {
            e.preventDefault();
            var form = $('.formfile')[0];
            var formData = new FormData(form);
            var getAction = $(this).val();
            var url = '/anggaran/save';
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
                            $(this).html('<?= lang("app.btnSave") ?>');
                        }
                        $(this).attr('name', 'action');
                    });
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.akses) {
                            $('#akses').addClass('is-invalid');
                            $('.errakses').html(response.error.akses);
                        } else {
                            $('#akses').removeClass('is-invalid');
                            $('.errakses').html('');
                        }
                    } else {
                        window.location.href = response.redirect;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
            return false;
        })

        // $('.btnsave').click(function(e) {
        //     e.preventDefault();
        //     var getIDU = "<= $idunik ?>";
        //     var getAktif = $("#niaktif").val();
        //     var getAction = $(this).val();
        //     var getPilih = $("#xpilih").val();
        //     var getTujuan = $("#xtujuan").val();
        //     $.ajax({
        //         type: 'post',
        //         url: '/anggaran/save',
        //         data: {
        //             idunik: getIDU,
        //             niaktif: getAktif,
        //             postaction: getAction,
        //             pilih: getPilih,
        //             tujuan: getTujuan,
        //         },
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.error) {
        //                 if (response.error.akses) {
        //                     $('#akses').addClass('is-invalid');
        //                     $('.errakses').html(response.error.akses);
        //                 } else {
        //                     $('#akses').removeClass('is-invalid');
        //                     $('.errakses').html('');
        //                 }
        //             } else {
        //                 window.location.href = response.redirect;
        //             }
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             alert(xhr.status + "\n" + xhr.responseText);
        //             alert(thrownError);
        //         }
        //     });
        // })
    });
</script>

<?= $this->endSection() ?>
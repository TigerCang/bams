<div onload="flashdata()"></div>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php $stat = "1" ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formts']) ?>
    <?= csrf_field() ?>
    <div class="row">
        <div class="col-sm-12">
            <input type="hidden" class="form-control" id="akses" name="akses" value="">
            <div class="invalid-feedback errakses alert background-danger" role="alert"></div>

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.header') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" id="idunik" name="idunik">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi">
                    <input type="hidden" class="form-control" id="idproyek" name="idproyek">

                    <input type="hidden" class="form-control" id="alatperush" name="alatperush">
                    <input type="hidden" class="form-control" id="alatdiv" name="alatdiv">
                    <input type="hidden" class="form-control" id="operatorperush" name="operatorperush">
                    <input type="hidden" class="form-control" id="operatorwil" name="operatorwil">
                    <input type="hidden" class="form-control" id="operatordiv" name="operatordiv">

                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='perusahaan' class='js-example-basic-single' name='perusahaan' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($perusahaan as $db) :
                                echo "<option value='{$db->id}'>{$db->kode} => {$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='wilayah' class='js-example-basic-single' name='wilayah' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($wilayah as $db) :
                                echo "<option value='{$db->id}'>{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='divisi' class='js-example-basic-single' name='divisi' disabled>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($divisi as $db) :
                                echo "<option value='{$db->id}'>{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="docsewa" class="col-sm-1 col-form-label"><?= lang('app.docsewa') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='docsewa' class='js-example-data-ajax' name='docsewa'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errdocsewa"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jasa" class="col-sm-1 col-form-label"><?= lang('app.jasa') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='jasa' class='js-example-basic-single' name='jasa'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errjasa"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.pelanggan') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="kodepelanggan" class="col-sm-1 col-form-label"><?= lang('app.pelanggan') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodepelanggan" name="kodepelanggan">
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="namapelanggan" name="namapelanggan">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kodeproyek" class="col-sm-1 col-form-label"><?= lang('app.proyek') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodeproyek" name="kodeproyek">
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="namaproyek" name="namaproyek">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ruas" class="col-sm-1 col-form-label"><?= lang('app.ruas') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='ruas' class='js-example-basic-single' name='ruas'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errruas"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='biaya' class='js-example-basic-single' name='biaya'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errbiaya"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.inputdata') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="bentuk" class="col-sm-1 col-form-label"><?= lang('app.bentuk') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='bentuk' class='js-example-basic-single' name='bentuk' disabled>";
                            echo "<option value='' selected disabled>" . lang('app.pilih-') . "</option>";
                            foreach ($selbentuk as $db) :
                                echo "<option value='{$db->nama}'" . ($db->nama == 'truk' ? 'selected' : '') . ">" . lang('app.' . $db->nama) . "</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kodealat" class="col-sm-1 col-form-label"><?= lang('app.alat') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodealat" name="kodealat" value="">
                        </div>
                        <div class="col-sm-9">
                            <input type="text" readonly class="form-control" id="namaalat" name="namaalat" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="operator" class="col-sm-1 col-form-label"><?= lang('app.operator') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='operator' class='js-example-data-ajax' name='operator'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="operator" class="col-sm-3 col-form-label"><?= lang('app.operasialat') ?></label>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <label for="kmh1" class="col-sm-1 col-form-label"><?= lang('app.kmh') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control autonumber" data-digit-after-decimal="0" id="kmh1" name="kmh1" autocomplete="off" />
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control autonumber" data-digit-after-decimal="0" id="kmh2" name="kmh2" autocomplete="off" />
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="operator" class="col-sm-1 col-form-label"><?= lang('app.jamalat') ?></label>
                        <div class="col-sm-2">
                            <input type="time" class="form-control" id="jam1" name="jam1">
                        </div>
                        <div class="col-sm-2">
                            <input type="time" class="form-control" id="jam2" name="jam2">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <label for="jamkerja" class="col-sm-1 col-form-label"><?= lang('app.kerja') ?></label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="jamkerja" name="jamkerja" min="0" max="24" autocomplete="off">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="jamstby" class="col-sm-1 col-form-label"><?= lang('app.stby') ?></label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="jamstby" name="jamstby" min="0" max="24" autocomplete="off">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="jamrusak" class="col-sm-1 col-form-label"><?= lang('app.rusak') ?></label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="jamrusak" name="jamrusak" min="0" max="24" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="operator" class="col-sm-3 col-form-label"><?= lang('app.operasioperator') ?></label>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-1"></div>
                        <label for="jamkerja" class="col-sm-1 col-form-label"><?= lang('app.normal') ?></label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="jamkerja" name="jamkerja" min="0" max="24" autocomplete="off">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="jamlembur" class="col-sm-1 col-form-label"><?= lang('app.lembur') ?></label>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="jamlembur" name="jamlembur" min="0" max="24" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control <?= (validation_show_error('catatan') ? 'is-invalid' : '') ?>" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"><?= old('catatan') ?></textarea>
                            <div class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4"></div>
                        <div class="col-4 text-center"></div>
                        <div class="col-4 text-right">
                            <?= "<button type='submit' class='btn " . lang('app.btnAdd') . " btnadd'" . (preg_match("/$stat/i", '013') ? '' : 'disabled') . ">" . lang('app.btn_Add') . "</button>"; ?>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

        </div>
    </div>
    <?= form_close() ?>
    <div class="dt-responsive table-responsive tabelts"></div>
</div><!-- body end -->

<script>
    // $("#docsewa").change(klikdocsewa);
    // $("#ruas").change(klikruas);
    // $("#alat").change(klikalat);
    // $("#operator").change(klikoperator);


    // function klikruas() {
    //     var getRuas = $("#ruas").val();
    //     var getProyek = $("#idproyek").val();
    //     var getTipe = $("#idtipe").val();
    //     $.ajax({
    //         type: "POST",
    //         url: "/tiketproyek/gantiruas",
    //         data: {
    //             proyek: getProyek,
    //             ruas: getRuas,
    //             tipe: getTipe,
    //         },
    //         dataType: "json",
    //         success: function(response) { // Ketika proses pengiriman berhasil
    //             $("#biaya").html(response.sukses.biaya);
    //             $("#ruas").html(response.sukses.ruas);

    //             if (typeof response.sukses.subruas !== 'undefined') {
    //                 $("#jarak").val(response.sukses.subruas['0'].jarak);
    //             } else {
    //                 $("#jarak").val('')
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText);
    //             alert(thrownError);
    //         }
    //     });
    // }

    // function klikalat() {
    //     var getAlat = $("#alat").val();
    //     $.ajax({
    //         type: "POST",
    //         url: "/tiketproyek/gantialat",
    //         data: {
    //             alat: getAlat,
    //         },
    //         dataType: "json",
    //         success: function(response) { // Ketika proses pengiriman berhasil
    //             $("#supir").html(response.sukses);
    //             if (Object.keys(response.alat).length !== 0) {
    //                 $("#alatperush").val(response.alat['0'].perusahaan_id);
    //                 $("#alatdiv").val(response.alat['0'].divisi_id);
    //                 $("#supirperush").val(response.supir['0'].perusahaan_id);
    //                 $("#supirwil").val(response.supir['0'].wilayah_id);
    //                 $("#supirdiv").val(response.supir['0'].divisi_id);
    //             } else {
    //                 $("#alatperush").val('');
    //                 $("#alatdiv").val('');
    //                 $("#alatdiv").val('');
    //                 $("#supirperush").val('');
    //                 $("#supirwil").val('');
    //                 $("#supirdiv").val('');
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText);
    //             alert(thrownError);
    //         }
    //     });
    // }

    // function klikoperator() {
    //     var getSupir = $("#operator").val();
    //     $.ajax({
    //         type: "POST",
    //         url: "/tiketproyek/gantisupir",
    //         data: {
    //             supir: getSupir,
    //         },
    //         dataType: "json",
    //         success: function(response) { // Ketika proses pengiriman berhasil
    //             if (Object.keys(response.supir).length !== 0) {
    //                 $("#supirperush").val(response.supir['0'].perusahaan_id);
    //                 $("#supirwil").val(response.supir['0'].divisi_id);
    //                 $("#supirdiv").val(response.supir['0'].divisi_id);
    //             } else {
    //                 $("#supirperush").val('');
    //                 $("#supirwil").val('');
    //                 $("#supirdiv").val('');
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText);
    //             alert(thrownError);
    //         }
    //     });
    // }

    // function datatiket() {
    //     var getDocjual = $("#docjual").val();
    //     $.ajax({
    //         url: "/tiketproyek/tabtiket",
    //         data: {
    //             docjual: getDocjual,
    //         },
    //         dataType: "json",
    //         success: function(response) {
    //             $('.tabeltiket').html(response.data);
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText);
    //             alert(thrownError);
    //         }
    //     });
    // }

    $(document).ready(function() {
        $("#docsewa").select2({
            ajax: {
                url: "/tsproyek/docsewa",
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
            <?= lang("app.inputminimum") ?>,
        });

        $("#operator").select2({
            ajax: {
                url: "/tsproyek/operator",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '0001',
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
            var form = $('.formts')[0];
            var formData = new FormData(form);
            var url = '/tiketproyek/addtiket';
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
                    $('.btnadd').html('<?= lang('app.btn_Add') ?>');
                },
                success: function(response) {
                    $('#kodecamp, #docjual, #ruas, #biaya, #docsewa, #gudang, #bahan, #notiket, #jumlah, #catatan').removeClass('is-invalid');
                    $('.errkodecamp, .errdocjual, .errruas, .errbiaya, .errdocsewa, .errgudang, .errbahan, .errnotiket, .errjumlah, .errcatatan').html('');

                    if (response.error) {
                        handleFieldError('kodecamp', response.error.kodecamp);
                        handleFieldError('docjual', response.error.docjual);
                        handleFieldError('ruas', response.error.ruas);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('docsewa', response.error.docsewa);
                        handleFieldError('gudang', response.error.gudang);
                        handleFieldError('bahan', response.error.bahan);
                        handleFieldError('notiket', response.error.notiket);
                        handleFieldError('jumlah', response.error.jumlah);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        flashdata('success', response.sukses);
                        datatiket();
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        clearFieldValues();
                    }

                    function handleFieldError(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(error);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                        }
                    }

                    function clearFieldValues() {
                        document.getElementById("notiket").value = "";
                        document.getElementById("stok").value = "";
                        document.getElementById("sisa").value = "";
                        document.getElementById("jumlah").value = "";
                        document.getElementById("catatan").value = "";
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
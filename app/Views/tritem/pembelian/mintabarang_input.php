<div onload="flashdata()"></div>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
$actconf = 'disabled hidden';
$beda = '';
if ($barang && $barang[0]->user_id != $tuser['id']) $beda = 'disabled'; //jika beda matikan tombol save
$stat = ($barang[0]->status ?? '0');
$status = statuslabel('barangpo', $stat);
if ($barang && $barang[0]->status == 'c') { //jika blm diacc
    if ($barang[0]->is_sama == '0' && $barang[0]->peminta_id == $tuser['id']) $actconf = '';
}
$actsave = (preg_match("/$stat/i", '013c') ? '' : 'disabled');
$klik = (preg_match("/$stat/i", '013c') ? '' : 'klikini');
if ($klik == '') $klik = ($beda == '' ? '' : 'klikini');
?>
<div class="page-body">
    <?= form_open('', ['class' => 'formbarang']) ?>
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
                <!--  -->
                <div class="card-block mt-2">
                    <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="kui" name="kui">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= ($barang[0]->perusahaan_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= ($barang[0]->wilayah_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= ($barang[0]->divisi_id ?? '') ?>">
                    <input type="hidden" class="form-control" id="xlevel" name="xlevel" value="<?= $tuser['acc_setuju'] ?>">
                    <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= (($tuser['confpeg'] == '1' && $tuser['akpeg'] == '1') ? $tuser['id'] : '') ?>">
                    <input type="hidden" class="form-control" id="idpeminta" name="idpeminta">
                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" <?= ($barang ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kui ?>" <?= (($barang && $barang[0]->perusahaan_id == $db->id)  ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= $db->kode . ' => ' . $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" <?= ($barang ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kode ?>" <?= (($barang && $barang[0]->wilayah_id == $db->id) ? 'selected' : '') . ($tuser['act_wilayah'] == '1' || preg_match("/,$db->id,/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" <?= ($barang ? 'disabled' : '') ?>>
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" data-kui="<?= $db->kode ?>" <?= (($barang && $barang[0]->divisi_id == $db->id) ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/,$db->id,/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.dokumen') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc') ?></label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= ($barang[0]->nodoc ?? '') ?>">
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="revisi" class="col-sm-1 col-form-label"><?= lang('app.rev') ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="revisi" name="revisi" value="<?= ($barang[0]->revisi ?? '0') ?>">
                        </div>
                        <label for="tanggal" class="col-sm-1 col-form-label">&emsp;&emsp;&emsp;<?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= ($barang[0]->tanggal ?? date('Y-m-d')) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="peminta" class="col-sm-1 col-form-label"><?= lang('app.peminta') ?></label>
                        <div class="col-sm-4">
                            <select id="peminta" class="js-example-data-ajax" name="peminta" <?= ($barang ? 'disabled' : '') ?>>
                                <option value="" selected><?= lang('app.pilihsr') ?></option>
                                <?php if ($user1) : ?> <option value="<?= $user1[0]->id ?>" selected><?= $user1[0]->kode . ' : ' . $user1[0]->namapeg ?></option><?php endif; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errpeminta"></div>
                        </div>
                        <div class="col-sm-4"></div>
                        <label for="status" class="col-sm-1 col-form-label">&emsp;&emsp;&emsp;<?= lang('app.status') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="status" name="status" value="<?= $status['text'] ?>">
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.inputdata') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card <?= $klik ?>"></i></li>
                        </ul>
                    </div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="jenis" class="col-sm-1 col-form-label"><?= lang('app.jenis') ?></label>
                        <div class="col-sm-2"><input type="checkbox" id="jenis" name="jenis" data-toggle="toggle" checked data-on="<?= lang('app.item') ?>" data-off="<?= lang('app.jasa') ?>" data-onstyle="primary" data-offstyle="info"></div>
                        <div class="col-sm-9" id="zitem">
                            <div class="input-group">
                                <select id="item" class="js-example-data-ajax" name="item" onchange="loadsatuan()">
                                    <option value=""><?= lang('app.pilihsr') ?></option>
                                </select>
                                <span class="input-group-addon"><i class="icofont icofont-files" aria-hidden="true" onclick="klikbarang()"></i></span>
                            </div>
                            <div id="error" class="invalid-feedback d-block erritem"></div>
                        </div>
                        <div class="col-sm-9" id="zjasa">
                            <select id="jasa" class="js-example-data-ajax" name="jasa">
                                <option value=""><?= lang('app.pilihsr') ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errjasa"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="spesifikasi" class="col-sm-1 col-form-label"><?= lang('app.spesifikasi') ?></label>
                        <div class="col-sm-11">
                            <textarea class="form-control" rows="3" id="spesifikasi" name="spesifikasi"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" />
                            <div class="invalid-feedback errjumlah"></div>
                        </div>
                        <div class="col-sm-2">
                            <select id="satuan" class="js-example-basic-single" name="satuan">
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($satuan as $db) : ?>
                                    <option value="<?= $db->nama ?>"><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errsatuan"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="konversi" class="col-sm-1 col-form-label"><?= lang('app.konversi') ?></label>
                        <div class="col-sm-2">
                            <input type="text" harusisi class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="konversi" name="konversi" />
                            <div class="invalid-feedback errkonversi"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="satuan2" name="satuan2">
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
                        <div class="col-4">
                            <button type="button" class="btn <?= lang('app.btncLogaksi') ?> btnlog"><?= lang('app.btnLogaksi') ?></button>
                        </div>
                        <div class="col-4 text-center">
                            <div class="dropdown-primary dropdown">
                                <button type="button" name="action" value="cetak" class="btn <?= lang('app.btncCetak') ?>"><?= lang('app.btnCetak') ?></button>
                                <button type="button" name="action" value="confirm" class="btn <?= lang('app.btncConfirm') ?> btnconf" <?= $actconf ?>><?= lang('app.btnConfirm') ?></button>
                                <button type="button" class="btn <?= lang('app.btncSave') ?> dropdown-toggle <?= $actsave ?>" data-toggle="dropdown"><?= lang('app.btnSave') ?></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <?php $style = ($beda == 'disabled' ? "style='pointer-events: none; opacity: 0.5;'" : ''); ?>
                                    <a class="dropdown-item" <?= $style ?> onclick="savedoc()"><?= lang('app.simpandoc') ?></a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="bataldoc()"><?= lang('app.bataldoc') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-right">
                            <button type="button" <?= $beda ?> class="btn <?= lang('app.btncAdd') ?> btnadd" <?= $actsave ?>><?= lang('app.btnAdd') ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
    <?= form_close() ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabelbarang"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    var awal = "<?= $nodoc[0]->nama ?>";
    $("#perusahaan, #divisi, #wilayah").change(function() {
        $("#idperusahaan").val($("#perusahaan").val());
        $("#iddivisi").val($("#divisi").val());
        $("#idwilayah").val($("#wilayah").val());
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + '/' + $("#wilayah").find(':selected').data('kui') + '.' + $("#divisi").find(':selected').data('kui') + '/';
    });

    $("#peminta, #jasa").change(function() {
        if (this.id === 'peminta') {
            $("#idpeminta").val($("#peminta").val());
        } else if (this.id === 'jasa') {
            $("#satuan").val('').trigger('change');
            $("#konversi, #satuan2").val('');
        }
    });

    function dataitembarang() {
        var getIDU = "<?= $idunik ?>";
        var getUser = $("#iduser").val();
        $.ajax({
            url: "/mintabarang/tabbarang",
            data: {
                idunik: getIDU,
                jaboskix: '1000111a',
                asal: 'minta',
                user: getUser,
            },
            dataType: "json",
            success: function(response) {
                $('.tabelbarang').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function loadsatuan() {
        var getBarang = $("#item").val();
        $.ajax({
            type: "POST",
            url: "/mintabarang/satuan",
            data: {
                barang: getBarang,
            },
            dataType: "json",
            success: function(response) {
                if (response.barang.length !== 0) { // if (typeof response.barang !== 'undefined')
                    const isNonStok = response.barang[0].pilihan === 'nonstok';
                    $("#satuan2").val(response.barang[0].satuan);
                    $("#satuan").val(response.barang[0].satuan).trigger('change');
                    $("#konversi").val(isNonStok ? '1,0000' : '');
                    $("#jumlah").val(isNonStok ? '1,0000' : '');
                    $("#konversi").prop('readonly', isNonStok); //bernilai true false
                    $("#jumlah").prop('readonly', isNonStok);
                } else {
                    $("#jumlah").val('');
                    $("#konversi").val('');
                    $("#satuan2").val('');
                    $("#konversi").prop('readonly', false);
                    $("#jumlah").prop('readonly', false);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikbarang() {
        var getItem = $("#item").val();
        var getJenis = $("#jenis").val();
        $.ajax({
            url: "/mintabarang/mbarang",
            data: {
                isi: getItem,
                jenis: getJenis
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

    function savedoc() {
        var getIDU = "<?= $idunik ?>";
        var getUser = $("#iduser").val();
        var getDokumen = $("#nodoc").val();
        var getRevisi = $("#revisi").val();
        var getPeminta = $("#idpeminta").val();
        $.ajax({
            type: "POST",
            url: "/mintabarang/savedoc",
            data: {
                idunik: getIDU,
                user: getUser,
                nodoc: getDokumen,
                revisi: getRevisi,
                peminta: getPeminta,
            },
            dataType: "json",
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
    }

    function bataldoc() {
        var getIDU = "<?= $idunik ?>";
        var getUser = $("#iduser").val();
        var getDokumen = $("#nodoc").val();
        $.ajax({
            type: "POST",
            url: "/mintabarang/bataldoc",
            data: {
                idunik: getIDU,
                user: getUser,
                nodoc: getDokumen,
            },
            dataType: "json",
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
    }

    $(document).ready(function() {
        dataitembarang();
        $("#peminta").change();
        $('#jumlah').on('blur', function() {
            var jumlahValue = parseFloat($(this).val().replace(',', '.'));
            if (jumlahValue === 0) $(this).val(''); // Mengosongkan nilai input
        });

        var checkbox = '#jenis';
        const divItem = document.getElementById("zitem");
        const divJasa = document.getElementById("zjasa");
        divItem.removeAttribute("hidden", true);
        divJasa.setAttribute("hidden", true);
        $(checkbox).bootstrapToggle();
        $(checkbox).change(function() {
            var isChecked = $(this).prop("checked");
            divItem.toggleAttribute("hidden", !isChecked);
            divJasa.toggleAttribute("hidden", isChecked);
            $("#item").val('').trigger('change');
            $("#jasa").val('').trigger('change');
        });

        $("#peminta").select2({
            ajax: {
                url: "/mintabarang/peminta",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pegawai: '1',
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

        $("#item").select2({
            ajax: {
                url: "/mintabarang/item",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilihan: '',
                        sn: '0',
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

        $("#jasa").select2({
            ajax: {
                url: "/mintabarang/jasa",
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
            <?= lang("app.inputminimum") ?>,
        })

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formbarang')[0];
            var formData = new FormData(form);
            var url = '/mintabarang/additem';
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
                    $('.btnadd').removeAttr('disable', 'disabled');
                    $('.btnadd').html('<?= lang('app.btnAdd') ?>');
                },
                success: function(response) {
                    $('#akses, #perusahaan, #wilayah, #divisi, #peminta, #item, #jasa, #jumlah, #satuan, #catatan').removeClass('is-invalid');
                    $('.errakses, .errperusahaan, .errwilayah, .errdivisi, .errpeminta, .erritem, .errjasa, .errjumlah, .errsatuan, .errcatatan').html('');
                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('peminta', response.error.peminta);
                        handleFieldError('item', response.error.item);
                        handleFieldError('jasa', response.error.jasa);
                        handleFieldError('jumlah', response.error.jumlah);
                        handleFieldError('satuan', response.error.satuan);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        clearElements();
                        flashdata('success', response.sukses);
                        document.getElementById("nodoc").value = response.nodoc;
                        document.getElementById("status").value = response.stat;
                        dataitembarang();
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
                        $('#perusahaan, #wilayah, #divisi, #peminta').attr('disabled', 'disabled');
                        // $(".js-example-data-ajax").empty().append(`<option value=""><= lang('app.pilihsr') ?></option>`);
                        // $("select[name='item']").empty(); // Menghapus semua opsi dari elemen dengan nama 'item'
                        $("select[name='item']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("select[name='jasa']").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        $("#spesifikasi").val("");
                        $("#jumlah").val("");
                        $("#satuan").val("").trigger('change');
                        $("#konversi").val("");
                        $("#satuan2").val("");
                        $("#catatan").val("");
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
            return false;
        })

        $('.btnconf').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik ?>";
            var getUser = $("#iduser").val();
            var getLevel = $("#xlevel").val();
            var getDokumen = $("#nodoc").val();
            var getAction = $(this).val();
            $.ajax({
                url: "/mintabarang/confdoc",
                type: "POST",
                data: {
                    idunik: getIDU,
                    user: getUser,
                    level: getLevel,
                    nodoc: getDokumen,
                    postaction: getAction,
                },
                dataType: "json",
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
        })

        $('.btnlog').click(function(e) {
            e.preventDefault();
            var getIDU = "<?= $idunik ?>";
            $.ajax({
                url: "/mintabarang/logaksi",
                data: {
                    idunik: getIDU,
                    pilihan: 'cek',
                    asal: 'cekbarang',
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
        })
    });
</script>

<?= $this->endSection() ?>
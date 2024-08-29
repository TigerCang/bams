<div onload="flashdata()"></div>

<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page-body start -->
<div class="page-body">
    <?= form_open('', ['class' => 'formminta']) ?>
    <?= csrf_field(); ?>
    <div class="row">
        <div class="col-sm-12">

            <input type="hidden" class="form-control" id="akses" name="akses" value="">
            <div class="invalid-feedback errakses alert background-danger" role="alert"></div>

            <div class="card">
                <div class="card-header <?= ($revisi == 'n') ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                    <h5><?= lang('app.header'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <?php if (empty($minta)) {
                        $pil = old('pilihan');
                        $stat = '1';
                    } else {
                        $pil = $minta['0']->pilihan;
                        $stat = $minta['0']->status;

                        switch ($minta['0']->pilihan) {
                            case 'proyek':
                                $beban = $proyek1['0']->kode;
                                $namabeban = $proyek1['0']->paket;
                                break;
                            case 'camp':
                                $beban = $camp1['0']->kode;
                                $namabeban = $camp1['0']->nama;
                                break;
                            case 'alat':
                                $beban = $alat1['0']->kode;
                                $namabeban = $alat1['0']->nama;
                                break;
                            case 'tanah':
                                $beban = $tanah1['0']->kode;
                                $namabeban = $tanah1['0']->nama;
                                break;
                        }
                    } ?>

                    <input type="text" class="form-control" id="idunik" name="idunik" value="<?= $idunik; ?>">
                    <input type="text" class="form-control" id="kui" name="kui" value="<?= old('kui'); ?>">
                    <input type="text" class="form-control" id="xlevel" name="xlevel" value="<?= $tuser['lev_setuju']; ?>">
                    <input type="text" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= (empty($minta)) ? old('idperusahaan') : $minta['0']->perusahaan_id; ?>">
                    <input type="text" class="form-control" id="idwilayah" name="idwilayah" value="<?= (empty($minta)) ? old('idwilayah') : $minta['0']->wilayah_id; ?>">
                    <input type="text" class="form-control" id="iddivisi" name="iddivisi" value="<?= (empty($minta)) ? old('iddivisi') : $minta['0']->divisi_id; ?>">
                    <input type="text" class="form-control" id="xpilihan" name="xpilihan" value="<?= (empty($minta)) ? old('xpilihan') : $minta['0']->pilihan; ?>">
                    <input type="text" class="form-control" id="idtipe" name="idtipe" value="<?= (empty($minta)) ? old('idtipe') : (($minta['0']->pilihan == 'proyek') ? $proyek1['0']->tipe_id : ''); ?>">
                    <input type="text" class="form-control" id="idbeban" name="idbeban" value="<?= (empty($minta)) ? old('idbeban') : $minta['0']->cabang_id; ?>">
                    <input type="text" class="form-control" id="idkbli" name="idkbli" value="<?= (!empty($kbli1)) ? $kbli1['0']->id : ''; ?>">
                    <input type="text" class="form-control" id="kodekbli" name="kodekbli">
                    <input type="text" class="form-control" id="namakbli" name="namakbli">
                    <input type="text" class="form-control" id="ninetto" name="ninetto" />
                    <input type="text" class="form-control" id="nibruto" name="nibruto" />
                    <input type="text" class="form-control" id="vtotal" name="vtotal" value="<?= old('vtotal'); ?>" />


                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan'); ?></label>
                        <div class="col-sm-11">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan" <?= (empty(!$minta)) ? 'disabled' : ''; ?>>
                                <option value=""><?= lang('app.pilih-'); ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id; ?>" data-kui="<?= $db->kui; ?>" <?= (old('perusahaan') == $db->id) ? 'selected' : ((empty(!$minta)) ? ((($minta['0']->perusahaan_id == $db->id) && (old('perusahaan') == '')) ? 'selected' : '') : ''); ?> <?= ($tuser['akses_perusahaan'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['perusahaan'])) ? '' : 'disabled'); ?>><?= $db->kode . '&emsp;=>&emsp;' . $db->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah'); ?></label>
                        <div class="col-sm-4">
                            <select id="wilayah" class="js-example-basic-single" name="wilayah" <?= (empty(!$minta)) ? 'disabled' : ''; ?>>
                                <option value=""><?= lang('app.pilih-'); ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id; ?>" data-kui="<?= $db->kui; ?>" <?= (old('wilayah') == $db->id) ? 'selected' : ((empty(!$minta)) ? ((($minta['0']->wilayah_id == $db->id) && (old('wilayah') == '')) ? 'selected' : '') : ''); ?> <?= ($tuser['akses_wilayah'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['wilayah'])) ? '' : 'disabled'); ?>><?= $db->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                        <div class="col-sm-4">
                            <select id="divisi" class="js-example-basic-single" name="divisi" <?= (empty(!$minta)) ? 'disabled' : ''; ?>>
                                <option value=""><?= lang('app.pilih-'); ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id; ?>" data-kui="<?= $db->kui; ?>" <?= (old('divisi') == $db->id) ? 'selected' : ((empty(!$minta)) ? ((($minta['0']->divisi_id == $db->id) && (old('divisi') == '')) ? 'selected' : '') : ''); ?> <?= ($tuser['akses_divisi'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['divisi'])) ? '' : 'disabled'); ?>><?= $db->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= ($revisi == 'n') ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                    <h5><?= lang('app.dokumen'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="userid" class="col-sm-1 col-form-label"><?= lang('app.peminta'); ?></label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" <?= (empty(!$minta)) ? 'readonly' : ''; ?> class="form-control" id="userid" name="userid" placeholder="<?= lang('app.harusisi'); ?>" value="<?= (empty(!$minta)) ? $minta['0']->peminta : session()->username; ?>" autocomplete="off">
                                <?php if (empty($minta)) { ?>
                                    <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="klikuser()"></i></span>
                                <?php } else { ?>
                                    <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                <?php } ?>
                            </div>
                            <div id="error" class="invalid-feedback d-block erruserid"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= (empty(!$minta)) ? $minta['0']->tgl_minta : date('Y-m-d'); ?>">
                        </div>
                        <label for="norev" class="col-sm-1 col-form-label text-right"><?= lang('app.norev'); ?></label>
                        <div class="col-sm-1">
                            <input type="text" readonly class="form-control" id="norev" name="norev" value="<?= $norevisi; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan'); ?></label>
                        <div class="col-sm-4">
                            <select id="pilihan" class="js-example-basic-single" name="pilihan" <?= (empty(!$minta)) ? 'disabled' : ''; ?>>
                                <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                <?php foreach ($selnama as $db) : ?>
                                    <option value="<?= $db->nama; ?>" <?= ($pil == $db->nama) ? 'selected' : ''; ?>><?= lang('app.' . $db->nama); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errpilihan"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc'); ?></label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= (empty(!$minta)) ? $minta['0']->nodoc : ''; ?>">
                            <div class="invalid-feedback errdokumen"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="beban" class="col-sm-1 col-form-label"><?= lang('app.cabang'); ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="beban" name="beban" placeholder="<?= lang('app.harusisi'); ?>" value="<?= (empty($minta)) ? old('beban') :  $beban; ?>">
                            <div class="invalid-feedback errbeban"></div>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="namabeban" name="namabeban" value="<?= (empty($minta)) ? old('namabeban') : $namabeban; ?>" autocomplete="off">
                                <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="klikbeban()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.penerima'); ?></label>
                        <div class="col-sm-11">
                            <div class="input-group input-group-dropdown">
                                <select id="penerima" class="js-example-data-ajax" name="penerima">
                                    <option value=""><?= lang('app.pilihsr'); ?></option>
                                    <?php if (empty(!$minta)) {
                                        echo "<option value='" . $penerima1['0']->id . "' selected='selected'>" . $penerima1['0']->kode . ' => ' . $penerima1['0']->nama . "</option>";
                                    } ?>
                                </select>&ensp;
                                <button type="button" class="btn btn-primary dropdown-toggle <?= (preg_match("/$stat/i", '013')) ? '' : 'disabled'; ?>" data-toggle="dropdown"><?= lang('app.aksi'); ?></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" onclick="ubahdoc()"><?= lang('app.ubahdoc'); ?></a>
                                    <div role="separator" class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/kaslangsung/bataldoc/<?= $idunik; ?>"><?= lang('app.bataldoc'); ?></a>
                                </div>
                            </div>
                            <div id="error" class="invalid-feedback d-block errpenerima"></div>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->
            <div class="dt-responsive table-responsive tabeluangmuka"></div>

            <div class="card">
                <div class="card-header <?= ($revisi == 'n') ? lang('app.bgInput') : lang('app.bgDetil'); ?>">
                    <h5><?= lang('app.inputdata'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row" id="zruas">
                        <label for="ruas" class="col-sm-1 col-form-label"><?= lang('app.ruas'); ?></label>
                        <div class="col-sm-11">
                            <select id="ruas" class="js-example-basic-single" name="ruas">
                                <option value=""><?= lang('app.pilih-'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="zbiaya">
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.item'); ?></label>
                        <div class="col-sm-4">
                            <select id="biaya" class="js-example-data-ajax" name="biaya">
                                <option value=""><?= lang('app.pilihsr'); ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errbiaya"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="sumberdaya" class="col-sm-1 col-form-label"><?= lang('app.sumberdaya'); ?></label>
                        <div class="col-sm-4">
                            <select id="sumberdaya" class="js-example-data-ajax" name="sumberdaya">
                                <option value=""><?= lang('app.pilihsr'); ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errsumberdaya"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zakun">
                        <label for="noakun" class="col-sm-1 col-form-label"><?= lang('app.noakun'); ?></label>
                        <div class="col-sm-11">
                            <select id="noakun" class="js-example-data-ajax" name="noakun">
                                <option value="" selected="selected"><?= lang('app.pilihsr'); ?></option>
                            </select>
                            <div id="error" class="invalid-feedback d-block errnoakun"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nokbli" class="col-sm-1 col-form-label"><?= lang('app.kbli'); ?></label>
                        <div class="col-sm-11">
                            <select id="nokbli" class="js-example-data-ajax" name="nokbli">
                                <option value="" selected="selected"><?= lang('app.pilihsr'); ?></option>
                                <?php if (empty(!$kbli1)) {
                                    echo "<option value='" . $kbli1['0']->id . "' selected='selected'>" . $kbli1['0']->kode . ' => ' . $kbli1['0']->nama . "</option>";
                                } ?>
                            </select>
                            <div id="error" class="invalid-feedback d-block errnokbli"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah'); ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="<?= old('jumlah'); ?>" autocomplete="off" onchange="hitungtotal()" />
                        </div>
                        <label for="harga" class="col-sm-1 col-form-label text-right"><?= lang('app.harga'); ?>&emsp;</label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="harga" name="harga" value="<?= old('harga'); ?>" autocomplete="off" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="total" class="col-sm-1 col-form-label text-right"><?= lang('app.total'); ?>&emsp;</label>
                        <div class="col-sm-3">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="<?= lang('app.harusisi'); ?>" value="<?= old('total'); ?>" autocomplete="off" />
                            <div class="invalid-feedback errvtotal"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi'); ?>"><?= old('catatan'); ?></textarea>
                            <div class="invalid-feedback errcatatan"></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div></div>
                        <div>
                            <button type="button" class="btn <?= lang('app.btnCetak'); ?>"><?= lang('app.btn_Cetak'); ?></button>
                            <button type="submit" class="btn <?= lang('app.btnSave'); ?> btnok" <?= (preg_match("/$stat/i", '013')) ? '' : 'disabled'; ?>><?= lang('app.btn_Save'); ?></button>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

        </div>
    </div>
    <?= form_close() ?>
    <div class="dt-responsive table-responsive tabelkas"></div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    var awal = "<?= $nodoc['0']->nama ?>";
    $("#perusahaan").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('idperusahaan').value = document.getElementById('perusahaan').value
    });
    $("#divisi").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('iddivisi').value = document.getElementById('divisi').value
    });
    $("#wilayah").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('idwilayah').value = document.getElementById('wilayah').value
    });
    $("#pilihan").change(function() {
        document.getElementById('xpilihan').value = document.getElementById('pilihan').value
    });

    //hitungtotal
    function hitungtotal() {
        if (document.getElementById('jumlah').value === '') {
            document.getElementById('jumlah').value = '0,00'
        }
        if (document.getElementById('harga').value === '') {
            document.getElementById('harga').value = '0,00'
        }

        var jumlah = formatKosong(document.getElementById('jumlah').value);
        var harga = formatKosong(document.getElementById('harga').value);
        var total = parseFloat(jumlah) * parseFloat(harga);
        document.getElementById('total').value = formatRupiah(total);
        document.getElementById('vtotal').value = total;
    }

    function datamintakas() {
        var getIDU = $("#idunik").val();
        var getPilih = $("#pilihan").val();
        $.ajax({
            url: "/kasnonlangsung/tabkas",
            data: {
                idunik: getIDU,
                asal: 'kasnonlangsung',
                pilih: getPilih,
                paksbe: '111001', //biayaproyek akun kbli supir barang edit
            },
            dataType: "json",
            success: function(response) {
                $('.tabelkas').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function datauangmuka() {
        var getIDU = $("#idunik").val();
        var getpenerima = $("#penerima").val();
        var getpilihan = $("#xpilihan").val();

        $.ajax({
            url: "/kasnonlangsung/tabuangmuka",
            data: {
                idunik: getIDU,
                penerima: getpenerima,
                pilihan: getpilihan,
            },
            dataType: "json",
            success: function(response) {
                $('.tabeluangmuka').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikuser() {
        var getuser = $("#userid").val();
        $.ajax({
            url: "/kasnonlangsung/user",
            data: {
                isi: getuser,
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

    function klikbeban() {
        var getpilihan = $("#xpilihan").val();
        var getperusahaan = $("#idperusahaan").val();
        var getwilayah = $("#idwilayah").val();
        var getdivisi = $("#iddivisi").val();
        var getnama = $("#namabeban").val();
        $.ajax({
            url: "/kasnonlangsung/beban",
            data: {
                pilihan: getpilihan,
                perusahaan: getperusahaan,
                wilayah: getwilayah,
                divisi: getdivisi,
                isi: getnama,
                beban: '2',
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

    function loadruas() {
        var getProyek = $("#idbeban").val();
        $.ajax({
            type: "POST",
            url: "/kasnonlangsung/ruas",
            data: {
                proyek: getProyek,
                pilih: 'proyek',
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                if (response.ruas) {
                    $("#ruas").html(response.ruas);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function ubahdoc() {
        var getIDU = $("#idunik").val();
        var getPilihan = $("#xpilihan").val();
        var getCabang = $("#idbeban").val();
        var getLevel = $("#xlevel").val();
        var getPenerima = $("#penerima").val();
        var getUser = $("#userid").val();
        var getDoc = $("#nodoc").val();

        $.ajax({
            type: "POST",
            url: "/kaslangsung/updatedoc",
            data: {
                idunik: getIDU,
                pilihan: getPilihan,
                cabang: getCabang,
                level: getLevel,
                penerima: getPenerima,
                user: getUser,
                dokumen: getDoc,
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
                    if (response.error.pilihan) {
                        $('#pilihan').addClass('is-invalid');
                        $('.errpilihan').html(response.error.pilihan);
                    } else {
                        $('#pilihan').removeClass('is-invalid');
                        $('.errpilihan').html('');
                    }
                    if (response.error.beban) {
                        $('#beban').addClass('is-invalid');
                        $('.errbeban').html(response.error.beban);
                    } else {
                        $('#beban').removeClass('is-invalid');
                        $('.errbeban').html('');
                    }
                    if (response.error.penerima) {
                        $('#penerima').addClass('is-invalid');
                        $('.errpenerima').html(response.error.penerima);
                    } else {
                        $('#penerima').removeClass('is-invalid');
                        $('.errpenerima').html('');
                    }
                    if (response.error.dokumen) {
                        $('#nodoc').addClass('is-invalid');
                        $('.errdokumen').html(response.error.dokumen);
                    } else {
                        $('#nodoc').removeClass('is-invalid');
                        $('.errdokumen').html('');
                    }
                } else {
                    $('#akses').removeClass('is-invalid');
                    $('.errakses').html('');
                    $('#pilihan').removeClass('is-invalid');
                    $('.errpilihan').html('');
                    $('#beban').removeClass('is-invalid');
                    $('.errbeban').html('');
                    $('#penerima').removeClass('is-invalid');
                    $('.errpenerima').html('');
                    $('#nodoc').removeClass('is-invalid');
                    $('.errdokumen').html('');
                    flashdata(response.sukses, 'success', response.judul);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function setkbli() {
        var getid = $("#idkbli").val();
        var getkode = $("#kodekbli").val();
        var getnama = $("#namakbli").val();

        $("#nokbli").empty()
        $('#nokbli').append(`<option value="` + getid + `">` + getkode + ` => ` + getnama + `</option>`);
    }

    function loadpilihan() {
        if (document.getElementById('pilihan').value === 'proyek') {
            $('#zruas').removeAttr('hidden');
            $('#zbiaya').removeAttr('hidden');
            $('#zakun').attr('hidden', 'hidden');
        } else {
            $('#zruas').attr('hidden', 'hidden');
            $('#zbiaya').attr('hidden', 'hidden');
            $('#zakun').removeAttr('hidden');
        }
    }

    $(document).ready(function() {
        datamintakas();
        datauangmuka();
        loadpilihan();
        loadruas();

        $("#pilihan").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $("#ruas").empty()
            $('#ruas').append(`<option value=""><?= lang('app.pilih-'); ?></option>`);
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
            loadpilihan();
        });

        $("#perusahaan").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $("#ruas").empty()
            $('#ruas').append(`<option value=""><?= lang('app.pilih-'); ?></option>`);
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });

        $("#wilayah").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $("#ruas").empty()
            $('#ruas').append(`<option value=""><?= lang('app.pilih-'); ?></option>`);
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });

        $("#divisi").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $("#ruas").empty()
            $('#ruas').append(`<option value=""><?= lang('app.pilih-'); ?></option>`);
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });

        $("#ruas").change(function(e) {
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });

        $("#penerima").select2({
            ajax: {
                url: "/kaslangsung/penerima",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '001',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum"); ?>,
        })

        $("#biaya").select2({
            ajax: {
                url: "/kaslangsung/biaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: 'biaya',
                        ruas: $("#ruas").val(),
                        kategori: $("#xkatproyek").val(),
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum"); ?>,
        })

        $("#sumberdaya").select2({
            ajax: {
                url: "/kaslangsung/sumberdaya",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: 'sumberdaya',
                        ruas: $("#ruas").val(),
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= lang("app.inputminimum"); ?>,
        })

        $("#noakun").select2({
            ajax: {
                url: "/kaslangsung/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term, // search term
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
            <?= lang("app.inputminimum"); ?>,
        });

        $("#nokbli").select2({
            ajax: {
                url: "/kaslangsung/kbli",
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
            <?= lang("app.inputminimum"); ?>,
        });

        $('.btnok').click(function(e) {
            e.preventDefault();
            var form = $('.formminta')[0];
            var formData = new FormData(form);
            var url = '/kasnonlangsung/save';
            $.ajax({
                type: 'post',
                url: url,
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    $('.btnok').attr('disable', 'disabled');
                    $('.btnok').html('<i class="fa fa-spin fa-spinner"></i>');
                },
                complete: function() {
                    $('.btnok').removeAttr('disable', 'disabled');
                    $('.btnok').html('<?= lang('app.btn_Save'); ?>');
                },
                success: function(response) {
                    if (response.error) { //dari msg save lampiran
                        if (response.error.akses) {
                            $('#akses').addClass('is-invalid');
                            $('.errakses').html(response.error.akses);
                        } else {
                            $('#akses').removeClass('is-invalid');
                            $('.errakses').html('');
                        }
                        if (response.error.perusahaan) {
                            $('#perusahaan').addClass('is-invalid');
                            $('.errperusahaan').html(response.error.perusahaan);
                        } else {
                            $('#perusahaan').removeClass('is-invalid');
                            $('.errperusahaan').html('');
                        }
                        if (response.error.wilayah) {
                            $('#wilayah').addClass('is-invalid');
                            $('.errwilayah').html(response.error.wilayah);
                        } else {
                            $('#wilayah').removeClass('is-invalid');
                            $('.errwilayah').html('');
                        }
                        if (response.error.divisi) {
                            $('#divisi').addClass('is-invalid');
                            $('.errdivisi').html(response.error.divisi);
                        } else {
                            $('#divisi').removeClass('is-invalid');
                            $('.errdivisi').html('');
                        }
                        if (response.error.userid) {
                            $('#userid').addClass('is-invalid');
                            $('.erruserid').html(response.error.userid);
                        } else {
                            $('#userid').removeClass('is-invalid');
                            $('.erruserid').html('');
                        }
                        if (response.error.pilihan) {
                            $('#pilihan').addClass('is-invalid');
                            $('.errpilihan').html(response.error.pilihan);
                        } else {
                            $('#pilihan').removeClass('is-invalid');
                            $('.errpilihan').html('');
                        }
                        if (response.error.beban) {
                            $('#beban').addClass('is-invalid');
                            $('.errbeban').html(response.error.beban);
                        } else {
                            $('#beban').removeClass('is-invalid');
                            $('.errbeban').html('');
                        }
                        if (response.error.penerima) {
                            $('#penerima').addClass('is-invalid');
                            $('.errpenerima').html(response.error.penerima);
                        } else {
                            $('#penerima').removeClass('is-invalid');
                            $('.errpenerima').html('');
                        }
                        if (response.error.biaya) {
                            $('#biaya').addClass('is-invalid');
                            $('.errbiaya').html(response.error.biaya);
                        } else {
                            $('#biaya').removeClass('is-invalid');
                            $('.errbiaya').html('');
                        }
                        if (response.error.sumberdaya) {
                            $('#sumberdaya').addClass('is-invalid');
                            $('.errsumberdaya').html(response.error.sumberdaya);
                        } else {
                            $('#sumberdaya').removeClass('is-invalid');
                            $('.errsumberdaya').html('');
                        }
                        if (response.error.noakun) {
                            $('#noakun').addClass('is-invalid');
                            $('.errnoakun').html(response.error.noakun);
                        } else {
                            $('#noakun').removeClass('is-invalid');
                            $('.errnoakun').html('');
                        }
                        if (response.error.nokbli) {
                            $('#nokbli').addClass('is-invalid');
                            $('.errnokbli').html(response.error.nokbli);
                        } else {
                            $('#nokbli').removeClass('is-invalid');
                            $('.errnokbli').html('');
                        }
                        if (response.error.vtotal) {
                            $('#total').addClass('is-invalid');
                            $('.errvtotal').html(response.error.vtotal);
                        } else {
                            $('#total').removeClass('is-invalid');
                            $('.errvtotal').html('');
                        }
                        if (response.error.catatan) {
                            $('#catatan').addClass('is-invalid');
                            $('.errcatatan').html(response.error.catatan);
                        } else {
                            $('#catatan').removeClass('is-invalid');
                            $('.errcatatan').html('');
                        }
                    } else {
                        $('#akses').removeClass('is-invalid');
                        $('.errakses').html('');
                        $('#perusahaan').removeClass('is-invalid');
                        $('.errperusahaan').html('');
                        $('#wilayah').removeClass('is-invalid');
                        $('.errwilayah').html('');
                        $('#divisi').removeClass('is-invalid');
                        $('.errdivisi').html('');
                        $('#userid').removeClass('is-invalid');
                        $('.erruseid').html('');
                        $('#pilihan').removeClass('is-invalid');
                        $('.errpilihan').html('');
                        $('#beban').removeClass('is-invalid');
                        $('.errbeban').html('');
                        $('#penerima').removeClass('is-invalid');
                        $('.errpenerima').html('');
                        $('#biaya').removeClass('is-invalid');
                        $('.errbiaya').html('');
                        $('#sumberdaya').removeClass('is-invalid');
                        $('.errsumberdaya').html('');
                        $('#noakun').removeClass('is-invalid');
                        $('.errnoakun').html('');
                        $('#nokbli').removeClass('is-invalid');
                        $('.errnokbli').html('');
                        $('#total').removeClass('is-invalid');
                        $('.errvtotal').html('');
                        $('#catatan').removeClass('is-invalid');
                        $('.errcatatan').html('');

                        $('#perusahaan').attr('disabled', 'disabled');
                        $('#wilayah').attr('disabled', 'disabled');
                        $('#divisi').attr('disabled', 'disabled');
                        $('#userid').attr('readonly', 'readonly');
                        $('#pilihan').attr('disabled', 'disabled');
                        document.getElementById("nodoc").value = response.nodoc;
                        flashdata(response.sukses, 'success', response.judul);
                        datamintakas();

                        $(".js-example-data-ajax").empty()
                        $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
                        document.getElementById("jumlah").value = "";
                        document.getElementById("harga").value = "";
                        document.getElementById("total").value = "";
                        $("#catatan").val('');
                        return false;
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

<?= $this->endSection(); ?>
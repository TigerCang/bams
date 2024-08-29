<div onload="flashdata()"></div>

<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page-body start -->
<div class="page-body">
    <form action="/pindahkas/save/<?= $idunik; ?>" id="myForm" method="POST">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-sm-12">

                <input type="hidden" class="form-control <?= ($validation->hasError('akses')) ? 'is-invalid' : ''; ?>" id="akses" name="akses" value="">
                <div class="invalid-feedback alert background-danger" role="alert">
                    <?= $validation->geterror('akses'); ?>
                </div>

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.header'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <?php if (empty($minta)) {
                            $perush = old('perusahaan');
                            $wil = old('wilayah');
                            $div = old('divisi');
                            $pil = old('pilihan');
                            $stat = '1';
                        } else {
                            $perush = $minta['0']->perusahaan_id;
                            $wil = $minta['0']->wilayah_id;
                            $div = $minta['0']->divisi_id;
                            $pil = $minta['0']->pilihan;
                            $stat = $minta['0']->status;

                            switch ($minta['0']->pilihan) {
                                case 'proyek':
                                    $idbeban = $proyek1['0']->idunik;
                                    $beban = $proyek1['0']->kode;
                                    $namabeban = $proyek1['0']->paket;
                                    break;
                                case 'camp':
                                    $idbeban = $camp1['0']->idunik;
                                    $beban = $camp1['0']->kode;
                                    $namabeban = $camp1['0']->nama;
                                    break;
                                case 'alat':
                                    $idbeban = $alat1['0']->idunik;
                                    $beban = $alat1['0']->kode;
                                    $namabeban = $alat1['0']->nama;
                                    break;
                                case 'tanah':
                                    $idbeban = $tanah1['0']->idunik;
                                    $beban = $tanah1['0']->kode;
                                    $namabeban = $tanah1['0']->nama;
                                    break;
                            }
                        } ?>

                        <input type="text" class="form-control" id="idunik" name="idunik" value="<?= $idunik; ?>">
                        <input type="hidden" class="form-control" id="kui" name="kui" value="<?= old('kui'); ?>">
                        <input type="hidden" class="form-control" id="xlevel" name="xlevel" value="<?= (empty($minta)) ? $tuser['lev_setuju'] : $user['0']->lev_setuju; ?>">
                        <input type="text" class="form-control" id="xperusahaan" name="xperusahaan" value="<?= (empty($minta)) ? old('xperusahaan') : $perusahaan1['0']->idunik; ?>">
                        <input type="text" class="form-control" id="xwilayah" name="xwilayah" value="<?= (empty($minta)) ? old('xwilayah') : $wilayah1['0']->idunik; ?>">
                        <input type="text" class="form-control" id="xdivisi" name="xdivisi" value="<?= (empty($minta)) ? old('xdivisi') : $divisi['0']->idunik; ?>">
                        <input type="text" class="form-control" id="xpilihan" name="xpilihan" value="<?= (empty($minta)) ? old('xpilihan') : $minta['0']->pilihan; ?>">
                        <input type="text" class="form-control" id="xidbeban" name="xidbeban" value="<?= (empty($minta)) ? old('xidbeban') : $idbeban; ?>">
                        <input type="text" class="form-control" id="xpenerima" name="xpenerima" value="<?= (empty($minta)) ? old('xpenerima') : $penerima1['0']->idunik; ?>">
                        <input type="hidden" class="form-control" id="vtotal" name="vtotal" value="<?= (old('vtotal')) ? old('vtotal') : ((empty($anak)) ? '0' :  $anak['0']->debit); ?>" />

                        <input type="hidden" class="form-control" id="xkatproyek" name="xkatproyek">
                        <input type="hidden" class="form-control" id="xidkbli" name="xidkbli">
                        <input type="hidden" class="form-control" id="xkodekbli" name="xkodekbli">
                        <input type="hidden" class="form-control" id="xnamakbli" name="xnamakbli">
                        <input type="hidden" class="form-control" id="ninetto" name="ninetto" />
                        <input type="hidden" class="form-control" id="nibruto" name="nibruto" />

                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-2 col-form-label"><?= lang('app.perusahaan'); ?></label>
                            <div class="col-sm-10">
                                <select id="perusahaan" class="js-example-basic-single <?= ($validation->hasError('xperusahaan')) ? 'is-invalid' : ''; ?>" name="perusahaan" <?= (empty($minta)) ? "" : 'disabled'; ?>>
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($perusahaan as $db) : ?>
                                        <option value="<?= $db->idunik; ?>" data-kui="<?= $db->kui; ?>" <?= (old('perusahaan') == $db->idunik) ? 'selected' : ((($perush == $db->id) && (old('perusahaan') == '')) ? 'selected' : ''); ?><?= ($user['0']->akses_perusahaan == '1') ? '' : ((preg_match("/,$db->id,/i", $user['0']->perusahaan)) ? '' : 'disabled'); ?>><?= $db->kode . '&emsp;=>&emsp;' . $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('xperusahaan'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-2 col-form-label"><?= lang('app.wilayah'); ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single <?= ($validation->hasError('xwilayah')) ? 'is-invalid' : ''; ?>" name="wilayah" <?= (empty($minta)) ? "" : 'disabled'; ?>>
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($wilayah as $db) : ?>
                                        <option value="<?= $db->idunik; ?>" data-kui="<?= $db->kui; ?>" <?= (old('wilayah') == $db->idunik) ? 'selected' : ((($wil == $db->id) && (old('perusahaan') == '')) ? 'selected' : ''); ?> <?= ($user['0']->akses_wilayah == '1') ? '' : ((preg_match("/,$db->id,/i", $user['0']->wilayah)) ? '' : 'disabled'); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('xwilayah'); ?>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single <?= ($validation->hasError('xdivisi')) ? 'is-invalid' : ''; ?>" name="divisi" <?= (empty($minta)) ? "" : 'disabled'; ?>>
                                    <option value=""><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($divisi as $db) : ?>
                                        <option value="<?= $db->idunik; ?>" data-kui="<?= $db->kui; ?>" <?= (old('divisi') == $db->idunik) ? 'selected' : ((($div == $db->id) && (old('divisi') == '')) ? 'selected' : ''); ?> <?= ($user['0']->akses_divisi == '1') ? '' : ((preg_match("/,$db->id,/i", $user['0']->divisi)) ? '' : 'disabled'); ?>><?= $db->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('xdivisi'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.dokumen'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="userid" class="col-sm-2 col-form-label"><?= lang('app.peminta'); ?></label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" <?= (empty($minta)) ? '' : 'readonly'; ?> class="form-control <?= ($validation->hasError('userid')) ? 'is-invalid' : ''; ?>" id="userid" name="userid" value="<?= (old('userid')) ? old('userid') : ((empty($minta)) ? session()->username :  $minta['0']->peminta); ?>" autocomplete="off">
                                    <?php if (empty($minta)) { ?>
                                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="klikuser()"></i></span>
                                    <?php } else { ?>
                                        <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                    <?php } ?>
                                </div>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('userid'); ?>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= (empty($minta)) ? date('Y-m-d') : $minta['0']->tgl_minta; ?>">
                            </div>
                            <label for="norev" class="col-sm-1 col-form-label text-right"><?= lang('app.norev'); ?></label>
                            <div class="col-sm-1">
                                <input type="text" readonly class="form-control" id="norev" name="norev" value="<?= $norevisi;  ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pilihan" class="col-sm-2 col-form-label"><?= lang('app.pilihan'); ?></label>
                            <div class="col-sm-4">
                                <select id="pilihan" class="js-example-basic-single <?= ($validation->hasError('xpilihan')) ? 'is-invalid' : ''; ?>" name="pilihan" <?= (empty($minta)) ? "" : 'disabled'; ?>>
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($selnama as $db) : ?>
                                        <option value="<?= $db->nama; ?>" <?= ($pil == $db->nama) ? 'selected' : ''; ?>><?= lang('app.' . $db->nama); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('xpilihan'); ?>
                                </div>
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= (empty($minta)) ? "" :  $minta['0']->nodoc; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="beban" class="col-sm-2 col-form-label"><?= lang('app.cabang'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" readonly class="form-control <?= ($validation->hasError('beban')) ? 'is-invalid' : ''; ?>" id="beban" name="beban" value="<?= (empty($minta)) ? old('beban') :  $beban; ?>">
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('beban'); ?>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" <?= (empty($minta)) ? "" : 'readonly'; ?> class="form-control" id="namabeban" name="namabeban" value="<?= (empty($minta)) ? old('namabeban') : $namabeban; ?>" autocomplete="off">
                                    <?php if (empty($minta)) { ?>
                                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="klikbeban()"></i></span>
                                    <?php } else { ?>
                                        <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerima" class="col-sm-2 col-form-label"><?= lang('app.penerima'); ?></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-dropdown">
                                    <select id="penerima" class="js-example-data-ajax" name="penerima">
                                        <option value=""><?= lang('app.pilihsr'); ?></option>
                                        <?php if (empty(!$minta)) {
                                            echo "<option value='" . $penerima1['0']->idunik . "' selected='selected'>" . $penerima1['0']->kode . ' => ' . $penerima1['0']->nama . "</option>";
                                        } ?>
                                    </select>&ensp;
                                    <div class="input-group-btn grpbtn">
                                        <button type="button" class="btn btnaksi btn-ungu dropdown-toggle <?= (preg_match("/$stat/i", '013')) ? '' : 'disabled'; ?>" data-toggle="dropdown"><?= lang('app.aksi'); ?></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" onclick="klikdoc()"><?= lang('app.ubahdoc'); ?></a>
                                            <div role="separator" class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="/pindahkas/bataldoc/<?= $idunik; ?>"><?= lang('app.bataldoc'); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('xpenerima'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.inputdata'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="noakun" class="col-sm-2 col-form-label"><?= lang('app.noakun'); ?></label>
                            <div class="col-sm-10">
                                <select id="noakun" class="js-example-data-ajax <?= ($validation->hasError('noakun')) ? 'is-invalid' : ''; ?>" name="noakun">
                                    <option value="" selected="selected"><?= lang('app.pilihsr'); ?></option>
                                    <?php if (empty(!$minta)) {
                                        echo "<option value='" . $akun1['0']->idunik . "' selected='selected'>" . $akun1['0']->kode . ' => ' . $akun1['0']->nama . "</option>";
                                    } ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block">
                                    <?= $validation->geterror('noakun'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah" class="col-sm-2 col-form-label"><?= lang('app.jumlah'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : ((empty($anak)) ? '0' :  gantitik($anak['0']->jumlah)); ?>" autocomplete="off" onchange="hitungtotal()" />
                            </div>
                            <label for="harga" class="col-sm-1 col-form-label"><?= lang('app.harga'); ?></label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="harga" name="harga" value="<?= (old('harga')) ? old('harga') : ((empty($anak)) ? '0' :  $anak['0']->harga); ?>" autocomplete="off" onchange="hitungtotal()" />
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="total" class="col-sm-1 col-form-label"><?= lang('app.total'); ?></label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control form-control-right autonumber <?= ($validation->hasError('vtotal')) ? 'is-invalid' : ''; ?>" data-a-sep="." data-a-dec="," id="total" name="total" value="<?= (old('total')) ? old('total') : ((empty($anak)) ? '0' :  $anak['0']->debit); ?>" autocomplete="off" />
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('vtotal'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-2 col-form-label"><?= lang('app.catatan'); ?></label>
                            <div class="col-sm-10">
                                <textarea harusisi class="form-control <?= ($validation->hasError('catatan')) ? 'is-invalid' : ''; ?>" rows="4" id="catatan" name="catatan"><?= (old('catatan')) ? old('catatan') : ((empty($anak)) ? '' :  $anak['0']->catatan); ?></textarea>
                                <div class="invalid-feedback">
                                    <?= $validation->geterror('catatan'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" class="btn <?= lang('app.btnLampir'); ?> inputbiaya"><?= lang('app.btn_Gambarbiaya'); ?></button>
                            </div>
                            <div>
                                <button type="button" class="btn <?= lang('app.btnCetak'); ?>"><?= lang('app.btn_Cetak'); ?></button>
                                <button type="submit" class="btn <?= lang('app.btnCreate'); ?>" <?= (preg_match("/$stat/i", '013')) ? '' : 'disabled'; ?>><?= lang('app.btn_Create'); ?></button>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </form>

    <div class="dt-responsive table-responsive tabellampiran"></div>
</div><!-- body end -->

<div class="modallampiran" style="display: none;"></div>
<div class="modalbeban" style="display: none;"></div>

<script>
    var awal = "<?= $nodoc['0']->nama; ?>";
    $("#perusahaan").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('xperusahaan').value = document.getElementById('perusahaan').value
    });
    $("#divisi").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('xdivisi').value = document.getElementById('divisi').value
    });
    $("#wilayah").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
        document.getElementById('xwilayah').value = document.getElementById('wilayah').value
    });
    $("#pilihan").change(function() {
        document.getElementById('xpilihan').value = document.getElementById('pilihan').value
    });
    $("#penerima").change(function() {
        document.getElementById('xpenerima').value = document.getElementById('penerima').value
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

    // panggil tabel minta
    function datalampiran() {
        var getidunik = $("#idunik").val();
        $.ajax({
            url: "/pindahkas/tablampir",
            data: {
                idunik: getidunik,
                // idunik: getIDU,
            },
            dataType: "json",
            success: function(response) {
                $('.tabellampiran').html(response.data);
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
            url: "/pindahkas/user",
            data: {
                isi: getuser,
            },
            dataType: "json",
            success: function(response) {
                $('.modalbeban').html(response.data).show();
                $('#modal-beban').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikbeban() {
        var getpilihan = $("#xpilihan").val();
        var getperusahaan = $("#xperusahaan").val();
        var getwilayah = $("#xwilayah").val();
        var getdivisi = $("#xdivisi").val();
        var getnama = $("#namabeban").val();
        $.ajax({
            url: "/pindahkas/beban",
            data: {
                pilihan: getpilihan,
                perusahaan: getperusahaan,
                wilayah: getwilayah,
                divisi: getdivisi,
                isi: getnama,
                beban: '1',
            },
            dataType: "json",
            success: function(response) {
                $('.modalbeban').html(response.data).show();
                $('#modal-beban').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikdoc() {
        var getIdunik = $("#idunik").val();
        var getPilihan = $("#xpilihan").val();
        var getCabang = $("#xidbeban").val();
        var getPenerima = $("#xpenerima").val();
        var getUser = $("#userid").val();
        var getDoc = $("#nodoc").val();

        $.ajax({
            type: "POST",
            url: "/pindahkas/updatedoc",
            data: {
                idunik: getIdunik,
                pilihan: getPilihan,
                cabang: getCabang,
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
                } else {
                    $('#akses').removeClass('is-invalid');
                    $('.errakses').html('');
                    $('#pilihan').removeClass('is-invalid');
                    $('.errpilihan').html('');
                    $('#beban').removeClass('is-invalid');
                    $('.errbeban').html('');
                    $('#penerima').removeClass('is-invalid');
                    $('.errpenerima').html('');

                    flashdata(response.sukses, 'success', response.judul);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        datalampiran();

        $("#pilihan").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });
        $("#perusahaan").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });
        $("#wilayah").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });
        $("#divisi").change(function(e) {
            document.getElementById("beban").value = "";
            document.getElementById("namabeban").value = "";
            $(".js-example-data-ajax").empty()
            $('.js-example-data-ajax').append(`<option value=""><?= lang('app.pilihsr'); ?></option>`);
        });

        $('.inputbiaya').click(function(e) {
            e.preventDefault();
            // var getIDU = $("#idunik").val();
            var getIDU = "<?= $idunik; ?>";
            var getPilihan = $("#xpilihan").val();

            $.ajax({
                url: "/pindahkas/addlampir",
                data: {
                    idunik: getIDU,
                    pilihan: getPilihan,
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

        $("#penerima").select2({
            ajax: {
                url: "/pindahkas/penerima",
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

        $("#noakun").select2({
            ajax: {
                url: "/pindahkas/akun",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term, // search term
                        awal: '1',
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
    });
</script>

<?= $this->endSection(); ?>
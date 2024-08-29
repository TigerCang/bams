<div onload="flashdata()"></div>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php $stat = "1" ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formtiket']) ?>
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
                    <input type="hidden" class="form-control" id="idjual" name="idjual">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi">
                    <input type="hidden" class="form-control" id="idcamp" name="idcamp">
                    <input type="hidden" class="form-control" id="idproyek" name="idproyek">
                    <input type="hidden" class="form-control" id="idtipe" name="idtipe">
                    <input type="hidden" class="form-control" id="idbarang" name="idbarang">
                    <input type="hidden" class="form-control" id="idkategori" name="idkategori">

                    <input type="hidden" class="form-control" id="alatperush" name="alatperush">
                    <input type="hidden" class="form-control" id="alatdiv" name="alatdiv">
                    <input type="hidden" class="form-control" id="supirperush" name="supirperush">
                    <input type="hidden" class="form-control" id="supirwil" name="supirwil">
                    <input type="hidden" class="form-control" id="supirdiv" name="supirdiv">

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
                        <label for="kodecamp" class="col-sm-1 col-form-label"><?= lang('app.camp') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodecamp" name="kodecamp" placeholder="<?= lang('app.harusisi') ?>" value="<?= (old('kodecamp') ?? (!empty($tiket) ? $camp1['0']->kode : '')) ?>">
                            <div class="invalid-feedback errkodecamp"></div>
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" class="form-control" id="namacamp" name="namacamp" value="<?= (empty($tiket) ? old('namacamp') : $camp1['0']->nama) ?>" autocomplete="off">
                                <?= (empty($tiket) ? "<span class='input-group-addon'><i class='icofont icofont-search-alt-2' aria-hidden='true' onclick='klikcamp()'></i></span>" : "<span class='input-group-addon'><i class='icofont icofont-link-alt' aria-hidden='true'></i></span>") ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="docjual" class="col-sm-1 col-form-label"><?= lang('app.docjual') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='docjual' class='js-example-basic-single' name='docjual'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errdocjual"></div>
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
                        <label for="jarak" class="col-sm-1 col-form-label"><?= lang('app.jarak') ?></label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jarak" name="jarak" autocomplete="off" />
                                <div class="input-group-append">
                                    <span class="input-group-text"><label class="col-form-label">&ensp;Km</label></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="biaya" class="col-sm-1 col-form-label"><?= lang('app.itembiaya') ?></label>
                        <div class="col-sm-7">
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
                        <label for="docsewa" class="col-sm-1 col-form-label"><?= lang('app.docsewa') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='docsewa' class='js-example-basic-single' name='docsewa'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
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
                    <div class="form-group row mt-2 mb-2" style="border: 1px solid black;"></div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="datetime-local" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d\TH:i', time()) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="gudang" class="col-sm-1 col-form-label"><?= lang('app.gudang') ?></label>
                        <div class="col-sm-6">
                            <?= "<select id='gudang' class='js-example-basic-single' name='gudang'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errgudang"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="stok" class="col-sm-1 col-form-label"><?= lang('app.stok') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="stok" name="stok" value="<?= old('sisa') ?>" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="barang" class="col-sm-1 col-form-label"><?= lang('app.bahan') ?></label>
                        <div class="col-sm-6">
                            <?= "<select id='barang' class='js-example-basic-single' name='barang'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errbarang"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="sisa" class="col-sm-1 col-form-label"><?= lang('app.sisa') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="sisa" name="sisa" value="<?= old('sisa') ?>" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="notiket" class="col-sm-1 col-form-label"><?= lang('app.notiket') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="notiket" name="notiket" maxlength="15">
                            <div id="error" class="invalid-feedback d-block errnotiket"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="0" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" autocomplete="off" />
                            <div id="error" class="invalid-feedback d-block errjumlah"></div>
                        </div>
                    </div>
                    <div class="form-group row mt-2 mb-2" style="border: 1px solid black;"></div>
                    <div class="form-group row" hidden>
                        <label for="bentuk" class="col-sm-1 col-form-label"><?= lang('app.bentuk') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='bentuk' class='js-example-basic-single' name='bentuk' disabled>";
                            echo "<option value='' selected disabled>" . lang('app.pilih-') . "</option>";
                            foreach ($selbentuk as $db) :
                                echo "<option value='{$db->nama}'" . ($db->nama == 'truk' ? 'selected' : '') . ">" . lang('app.' . $db->nama) . "</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="kategori" class="col-sm-1 col-form-label"><?= lang('app.kategori') ?>&emsp;</label>
                        <div class="col-sm-5">
                            <?= "<select id='kategori' class='js-example-tokenizer' name='kategori' disabled>";
                            echo "<option value='' selected disabled>" . lang('app.pilih-') . "</option>";
                            foreach ($selkategori as $db) :
                                echo "<option value='{$db->id}'>$db->nama</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="alat" class="col-sm-1 col-form-label"><?= lang('app.alat') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='alat' class='js-example-data-ajax' name='alat'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="supir" class="col-sm-1 col-form-label"><?= lang('app.supir') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='supir' class='js-example-data-ajax' name='supir'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan') ?></label>
                        <div class="col-sm-11">
                            <textarea harusisi class="form-control" rows="3" id="catatan" name="catatan" placeholder="<?= lang('app.harusisi') ?>"><?= old('catatan') ?></textarea>
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
    <div class="dt-responsive table-responsive tabeltiket"></div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#docjual").change(klikdocjual);
    $("#docsewa").change(klikdocsewa);
    $("#jasa").change(klikjasa);
    $("#ruas").change(klikruas);
    $("#barang").change(klikbarang);
    $("#alat").change(klikalat);
    $("#supir").change(kliksupir);

    function klikcamp() {
        var getnama = $("#namacamp").val();
        $.ajax({
            url: "/tiketproyek/camp",
            data: {
                perusahaan: '',
                wilayah: '',
                divisi: '',
                isi: getnama,
                werbipakxo: '1000000010',
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

    function loaddokumen() {
        var getCamp = $("#idcamp").val();
        var getPerusahaan = $("#idperusahaan").val();
        var getWilayah = $("#idwilayah").val();
        var getDivisi = $("#iddivisi").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/docjual",
            data: {
                camp: getCamp,
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#docjual").html(response.docjual);
                $('#idtipe').val('');
                $('#jarak').val('');
                $("#kodepelanggan").val('');
                $("#namapelanggan").val('');
                $("#kodeproyek").val('');
                $("#namaproyek").val('');
                $("#gudang").html(response.gudang);
                $("#ruas").html(response.ruas);
                $("#docsewa").html(response.docsewa);
                $("#barang").html(response.barang);
                $("#biaya").html(response.biaya);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikdocjual() {
        var getDocjual = $("#docjual").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/gantidocjual",
            data: {
                docjual: getDocjual,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#ruas").html(response.sukses.ruas);
                $("#barang").html(response.sukses.barang);
                $("#biaya").html(response.sukses.biaya);
                $("#docsewa").html(response.sukses.sewa);
                $("#jarak").val('');
                if (typeof response.sukses.proyek !== 'undefined') {
                    $("#idjual").val(response.sukses.dokumen['0'].id);
                    $("#idunik").val(response.sukses.dokumen['0'].idunik);
                    $("#kodepelanggan").val(response.sukses.penerima['0'].kode);
                    $("#namapelanggan").val(response.sukses.penerima['0'].nama);
                    $("#idproyek").val(response.sukses.proyek['0'].id);
                    $("#kodeproyek").val(response.sukses.proyek['0'].kode);
                    $("#namaproyek").val(response.sukses.proyek['0'].paket);
                    $("#idtipe").val(response.sukses.proyek[0].tipe_id)
                } else {
                    $("#idjual").val('');
                    $("#idunik").val('');
                    $("#kodepelanggan").val('');
                    $("#namapelanggan").val('');
                    $("#idproyek").val('');
                    $("#kodeproyek").val('');
                    $("#namapproyek").val('');
                    $("#idtipe").val('')
                }
                datatiket();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikruas() {
        var getRuas = $("#ruas").val();
        var getProyek = $("#idproyek").val();
        var getTipe = $("#idtipe").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/gantiruas",
            data: {
                proyek: getProyek,
                ruas: getRuas,
                tipe: getTipe,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#biaya").html(response.sukses.biaya);
                $("#ruas").html(response.sukses.ruas);

                if (typeof response.sukses.subruas !== 'undefined') {
                    $("#jarak").val(response.sukses.subruas['0'].jarak);
                } else {
                    $("#jarak").val('')
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikdocsewa() {
        var getDocsewa = $("#docsewa").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/gantidocsewa",
            data: {
                docsewa: getDocsewa,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#jasa").html(response.jasa);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikjasa() {
        var getJasa = $("#jasa").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/gantijasa",
            data: {
                jasa: getJasa,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                if (response.kategori.length > 0) {
                    $("#idkategori").val(response.kategori);
                    $("#kategori").val(response.kategori).change();
                } else {
                    $("#idkategori").val('');
                    $("#kategori").val('').change();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikbarang() {
        var getBarang = $("#barang").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/gantibarang",
            data: {
                barang: getBarang,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#idbarang").val(response.barang['0'].barang_id);
                // if (typeof response.sukses !== 'undefined') {
                //     var sisaformat = response.sukses['0'].jumlah.toString().replace(".", ",");
                //     $("#sisa").val(sisaformat).autoNumeric('set', sisaformat.replace(",", ".")); // Gunakan fungsi 'set' untuk mengatur nilai dengan autonumeric
                // } else {
                //     $("#sisa").val('')
                // }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikalat() {
        var getAlat = $("#alat").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/gantialat",
            data: {
                alat: getAlat,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#supir").html(response.sukses);
                if (Object.keys(response.alat).length !== 0) {
                    $("#alatperush").val(response.alat['0'].perusahaan_id);
                    $("#alatdiv").val(response.alat['0'].divisi_id);
                    $("#supirperush").val(response.supir['0'].perusahaan_id);
                    $("#supirwil").val(response.supir['0'].wilayah_id);
                    $("#supirdiv").val(response.supir['0'].divisi_id);
                } else {
                    $("#alatperush").val('');
                    $("#alatdiv").val('');
                    $("#alatdiv").val('');
                    $("#supirperush").val('');
                    $("#supirwil").val('');
                    $("#supirdiv").val('');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function kliksupir() {
        var getSupir = $("#supir").val();
        $.ajax({
            type: "POST",
            url: "/tiketproyek/gantisupir",
            data: {
                supir: getSupir,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                if (Object.keys(response.supir).length !== 0) {
                    $("#supirperush").val(response.supir['0'].perusahaan_id);
                    $("#supirwil").val(response.supir['0'].divisi_id);
                    $("#supirdiv").val(response.supir['0'].divisi_id);
                } else {
                    $("#supirperush").val('');
                    $("#supirwil").val('');
                    $("#supirdiv").val('');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function datatiket() {
        var getDocjual = $("#docjual").val();
        $.ajax({
            url: "/tiketproyek/tabtiket",
            data: {
                docjual: getDocjual,
            },
            dataType: "json",
            success: function(response) {
                $('.tabeltiket').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        $("#alat").select2({
            ajax: {
                url: "/tiketproyek/alat",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    var getBentuk = $("#bentuk").val();
                    // var getKategori = $("#idkategori").val();
                    var getKategori = $("#kategori").val();
                    return {
                        searchTerm: params.term,
                        bentuk: getBentuk,
                        kategori: getKategori,
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

        $("#supir").select2({
            ajax: {
                url: "/tiketproyek/supir",
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
            var form = $('.formtiket')[0];
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
                    $('#kodecamp, #docjual, #ruas, #biaya, #docsewa, #jasa, #gudang, #barang, #notiket, #jumlah, #catatan').removeClass('is-invalid');
                    $('.errkodecamp, .errdocjual, .errruas, .errbiaya, .errdocsewa, .errjasa, .errgudang, .errbarang, .errnotiket, .errjumlah, .errcatatan').html('');

                    if (response.error) {
                        handleFieldError('kodecamp', response.error.kodecamp);
                        handleFieldError('docjual', response.error.docjual);
                        handleFieldError('ruas', response.error.ruas);
                        handleFieldError('biaya', response.error.biaya);
                        handleFieldError('docsewa', response.error.docsewa);
                        handleFieldError('jasa', response.error.jasa);
                        handleFieldError('gudang', response.error.gudang);
                        handleFieldError('barang', response.error.barang);
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
                        $("#notiket").val('');
                        $("#stok").val('');
                        $("#sisa").val('');
                        $("#jumlah").val('');
                        $("#catatan").val('');
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
<div onload="flashdata()"></div>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
$stat = "1";
$chid = ((substr($cja, 0, 1) == '1') ? '' : 'hidden');
$jhid = ((substr($cja, 1, 1) == '1') ? '' : 'hidden');
?>

<div class="page-body">
    <?= form_open('', ['class' => 'formjual']) ?>
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
                    <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik ?>">
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= (empty($jual) ? old('idperusahaan') : $jual['0']->perusahaan_id) ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= (empty($jual) ? old('idwilayah') : $jual['0']->wilayah_id) ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= (empty($jual) ? old('iddivisi') : $jual['0']->divisi_id) ?>">
                    <input type="hidden" class="form-control" id="idcamp" name="idcamp" value="<?= ((empty($jual) ? old('idcamp') : $jual['0']->camp_id)) ?>">
                    <input type="hidden" class="form-control" id="idproyek" name="idproyek" value="<?= ((empty($jual) ? old('idbeban') : $jual['0']->proyek_id)) ?>">
                    <input type="hiddena" class="form-control" id="penerimaid" name="penerimaid" value="<?= ((empty($jual) ? old('idpenerima') : $jual['0']->penerima_id)) ?>">
                    <input type="hidden" class="form-control" id="pajak" name="pajak" value="<?= (old('pajak') ?? (empty(!$jual) ? $jual['0']->is_pajak : '0')) ?>">
                    <input type="hidden" class="form-control" id="xdata" name="xdata" value="<?= (!empty($jual) ? $jual['0']->pilihdata : 'stok') ?>">

                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='perusahaan' class='js-example-basic-single' name='perusahaan'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($perusahaan as $db) :
                                echo "<option value='{$db->id}'" . ((old('perusahaan') == $db->id) || (empty(!$jual) && $jual['0']->perusahaan_id == $db->id && empty(old('perusahaan')))  ? 'selected' : '') . " " . ($tuser['akses_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') . ">{$db->kode} => {$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errperusahaan"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='wilayah' class='js-example-basic-single' name='wilayah'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($wilayah as $db) :
                                echo "<option value='{$db->id}'" . ((old('wilayah') == $db->id) || (empty(!$jual) && $jual['0']->wilayah_id == $db->id && empty(old('wilayah'))) ? 'selected' : '') . " " . ($tuser['akses_wilayah'] == '1' || preg_match("/,$db->id,/i", $tuser['wilayah']) ? '' : 'disabled') . ">{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errwilayah"></div>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='divisi' class='js-example-basic-single' name='divisi'>";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($divisi as $db) :
                                echo "<option value='{$db->id}'" . ((old('divisi') == $db->id) || (empty(!$jual) && $jual['0']->divisi_id == $db->id && empty(old('divisi'))) ? 'selected' : '') . " " . ($tuser['akses_divisi'] == '1' || preg_match("/,$db->id,/i", $tuser['divisi']) ? '' : 'disabled') . ">{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errdivisi"></div>
                        </div>
                    </div>
                    <div class="form-group row" <?= $chid ?>>
                        <label for="kodecamp" class="col-sm-1 col-form-label"><?= lang('app.camp') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodecamp" name="kodecamp" placeholder="<?= lang('app.harusisi') ?>" value="<?= (old('kodecamp') ?? (!empty($camp1) ? $camp1['0']->kode : '')) ?>">
                            <div class="invalid-feedback errkodecamp"></div>
                        </div>
                        <div class="col-sm-9 input-group">
                            <input type="text" <?= (!empty($jual) && $jual['0']->st_jual != '0' ? 'readonly' : '') ?> class="form-control" id="namacamp" name="namacamp" value="<?= (old('kodecamp') ?? (!empty($camp1) ? $camp1['0']->nama : '')) ?>">
                            <?= (!empty($jual) && $jual['0']->st_jual != '0' ? "<span class='input-group-addon'><i class='icofont icofont-link-alt' aria-hidden='true'></i></span>" : "<span class='input-group-addon'><i class='icofont icofont-search-alt-2' aria-hidden='true' onclick='klikcamp()'></i></span>") ?>


                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.dokumen') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc') ?></label>
                        <div class="col-sm-4">
                            <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= (empty(!$jual) ? $jual['0']->nodoc : '') ?>">
                        </div>
                        <div class="col-sm-4"></div>
                        <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= (empty(!$jual) ? $jual['0']->tanggal : date('Y-m-d')) ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.pelanggan') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='penerima' class='js-example-data-ajax' name='penerima'>";
                            echo "<option value='' selected>" . lang('app.pilihsr') . "</option>";
                            if (!empty($penerima1)) echo "<option value='{$penerima1['0']->id}' selected>{$penerima1['0']->kode} => {$penerima1['0']->nama}</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errpenerima"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kodeproyek" class="col-sm-1 col-form-label"><?= lang('app.proyek') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodeproyek" name="kodeproyek" value="<?= (old('kodeproyek') ?? (!empty($proyek1) ? $proyek1['0']->kode : '')) ?>">
                        </div>
                        <div class="col-sm-9 input-group">
                            <input type="text" class="form-control" id="namapaket" name="namapaket" value="<?= (old('kodeproyek') ?? (!empty($proyek1) ? $proyek1['0']->paket : '')) ?>">
                            <span class='input-group-addon'><i class='icofont icofont-search-alt-2' aria-hidden='true' onclick='klikproyek()'></i></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nopo" class="col-sm-1 col-form-label"><?= lang('app.nopo') ?></label>
                        <div class="col-sm-4">
                            <input type="text" <?= (!empty($jual) ? 'readonly' : '') ?> class="form-control" id="nopo" name="nopo" value="<?= (empty(!$jual) ? $jual['0']->nodoc : '') ?>">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="pilihdata" class="col-sm-1 col-form-label"><?= lang('app.data') ?></label>
                        <div class="col-sm-2">
                            <?= "<select id='pilihdata' class='js-example-basic-single' name='pilihdata'" . (!empty($jual) ? 'disabled' : '') . ">";
                            foreach ($selitem as $db) :
                                echo "<option value='{$db->nama}'" . ((old('pilihdata') == $db->nama) || (empty(!$jual) && $jual['0']->modeorder == $db->nama && empty(old('pilihdata'))) ? 'selected' : '') . ">" . lang('app.' . $db->nama) . "</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="pajak" class="col-sm-1 col-form-label text-right"><?= lang('app.pajak') ?></label>
                        <div class="col-sm-1 d-inline text-right">
                            <input class="switch bs-switch" data="pajak" type="checkbox" <?= (old('pajak') || old('pajak') == '0') ? (old('pajak') == '1' ? 'checked' : '') : ((empty(!$jual) && $jual['0']->is_pajak == '1') ? 'checked' : '') ?> data-on-text="<?= lang('app.ya') ?>" data-off-text="<?= lang('app.no') ?>" data-on-color="success" data-off-color="danger">
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
                    <div class="form-group row" <?= $jhid ?>>
                        <label for="jasa" class="col-sm-1 col-form-label"><?= lang('app.jasa') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='jasa' class='js-example-tokenizer' name='jasa'>";
                            echo "<option value=''>" . lang('app.pilihcr') . "</option>";
                            foreach ($jasaso as $db) :
                                echo "<option value='{$db->jasa}'>{$db->jasa}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errjasa"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zbarang">
                        <label for="barang" class="col-sm-1 col-form-label"><?= lang('app.stok') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='barang' class='js-example-data-ajax' name='barang' onchange='loadsatuan()'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errbarang"></div>
                        </div>
                    </div>
                    <div class="form-group row" id="zalat">
                        <label for="alat" class="col-sm-1 col-form-label"><?= lang('app.alat') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='alat' class='js-example-data-ajax' name='alat' onchange='loadbentuk()'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row" id="ztanah">
                        <label for="tanah" class="col-sm-1 col-form-label"><?= lang('app.tanah') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='tanah' class='js-example-data-ajax' name='tanah'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row" id="zinventaris">
                        <label for="inventaris" class="col-sm-1 col-form-label"><?= lang('app.inventaris') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='inventaris' class='js-example-data-ajax' name='inventaris'>";
                            echo "<option value=''>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row" <?= $jhid ?>>
                        <label for="bentuk" class="col-sm-1 col-form-label"><?= lang('app.bentuk') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='bentuk' class='js-example-basic-single' name='bentuk'>";
                            echo "<option value='' selected disabled>" . lang('app.pilih-') . "</option>";
                            foreach ($selbentuk as $db) :
                                echo "<option value='{$db->nama}'>" . lang('app.' . $db->nama) . "</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errbentuk"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="kategori" class="col-sm-1 col-form-label"><?= lang('app.kategori') ?>&emsp;</label>
                        <div class="col-sm-5">
                            <?= "<select id='kategori' class='js-example-tokenizer' name='kategori'>";
                            echo "<option value='' selected disabled>" . lang('app.pilih-') . "</option>";
                            foreach ($katalat as $db) :
                                echo "<option value='{$db->id}'>{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errkategori"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jumlah" class="col-sm-1 col-form-label"><?= lang('app.jumlah') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="4" data-a-sep="." data-a-dec="," id="jumlah" name="jumlah" value="<?= old('jumlah') ?>" onchange="hitungtotal()" />
                        </div>
                        <div class="col-sm-2" id="zsatuan1">
                            <input type="text" readonly class="form-control" id="satuan" name="satuan">
                        </div>
                        <div class="col-sm-2" id="zsatuan2">
                            <?= "<select id='satuan2' class='js-example-basic-single' name='satuan2'>";
                            echo "<option value='' selected disabled>" . lang('app.pilih-') . "</option>";
                            foreach ($satuan as $db) :
                                echo "<option value='{$db->nama}'>{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                            <div id="error" class="invalid-feedback d-block errsatuan2"></div>
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="harga" class="col-sm-1 col-form-label"><?= lang('app.harga') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="harga" name="harga" value="<?= old('harga') ?>" onchange="hitungtotal()" />
                        </div>
                        <label for="diskon" class="col-sm-1 col-form-label">&emsp;<?= lang('app.diskon') ?></label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="diskon" name="diskon" value="<?= old('diskon') ?>" onchange="hitungtotal()" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9"></div>
                        <label for="total" class="col-sm-1 col-form-label">&emsp;<?= lang('app.total') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="<?= lang('app.harusisi') ?>" value="<?= old('total') ?>" />
                            <div class="invalid-feedback errtotal"></div>
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
                        <div class="col-4 text-center">
                            <div class="dropdown-primary dropdown">
                                <?= "<button type='button' class='btn " . lang('app.btnCetak') . "'>" . lang('app.btn_Cetak') . "</button>";
                                echo " <button type='button' class='btn " . lang('app.btnSave') . " dropdown-toggle " . (preg_match("/$stat/i", '013') ? '' : 'disabled') . "' data-toggle='dropdown'>" . lang('app.btn_Save') . "</button>";
                                echo "<div class='dropdown-menu dropdown-menu-right'>";
                                echo "<a class='dropdown-item' onclick='savedoc()'>" . lang('app.simpandoc') . "</a>";
                                echo "<div role='separator' class='dropdown-divider'></div>";
                                echo "<a class='dropdown-item' href='/$menu/bataldoc/$idunik'>" . lang('app.bataldoc') . "</a>";
                                echo "</div>"; ?>
                            </div>
                        </div>
                        <div class="col-4 text-right">
                            <?= "<button type='submit' class='btn " . lang('app.btnAdd') . " btnadd'" . (preg_match("/$stat/i", '013') ? '' : 'disabled') . ">" . lang('app.btn_Add') . "</button>"; ?>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->
        </div>
    </div>
    <?= form_close() ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dt-responsive table-responsive tabelsales"></div>
        </div>
    </div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    $("#perusahaan").on("change", () => $("#idperusahaan").val($("#perusahaan").val()));
    $("#wilayah").on("change", () => $("#idwilayah").val($("#wilayah").val()));
    $("#divisi").on("change", () => $("#iddivisi").val($("#divisi").val()));

    $("#pilihdata").on("change", function() {
        var selectedValue = $(this).val();

        $('#zbarang').attr('hidden', 'hidden');
        $('#zalat').attr('hidden', 'hidden');
        $('#ztanah').attr('hidden', 'hidden');
        $('#zinventaris').attr('hidden', 'hidden');
        $('#zsatuan1').attr('hidden', 'hidden');
        $('#zsatuan2').attr('hidden', 'hidden');

        if (selectedValue === 'stok') {
            $('#zbarang').removeAttr('hidden');
            $('#zsatuan1').removeAttr('hidden');
        } else if (selectedValue === 'alat') {
            $('#zalat').removeAttr('hidden');
            $('#zsatuan2').removeAttr('hidden');
        } else if (selectedValue === 'tanah') {
            $('#ztanah').removeAttr('hidden');
            $('#zsatuan2').removeAttr('hidden');
        } else if (selectedValue === 'inventraris') {
            $('#zinventaris').removeAttr('hidden');
            $('#zsatuan2').removeAttr('hidden');
        }
        $('#xdata').val(selectedValue);
    });

    function hitungtotal() {
        if (document.getElementById('jumlah').value === '') document.getElementById('jumlah').value = '0,0000'
        if (document.getElementById('harga').value === '') document.getElementById('harga').value = '0,00'
        if (document.getElementById('diskon').value === '') document.getElementById('diskon').value = '0,00'

        var jumlah = formatAngka(document.getElementById('jumlah').value, 'nol');
        var harga = formatAngka(document.getElementById('harga').value, 'nol');
        var diskon = formatAngka(document.getElementById('diskon').value, 'nol');
        var total = parseFloat(jumlah) * (parseFloat(harga) - parseFloat(diskon));
        $('#total').val(formatAngka(total, 'rp'));
    }

    function datasalesitem() {
        var getIDU = "<?= $idunik ?>";
        var getcja = "<?= $cja ?>";
        $.ajax({
            url: "/<?= $menu ?>/tabsalesitem",
            data: {
                idunik: getIDU,
                cja: getcja,
            },
            dataType: "json",
            success: function(response) {
                $('.tabelsales').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function klikcamp() {
        var getperusahaan = $("#perusahaan").val();
        var getwilayah = $("#wilayah").val();
        var getdivisi = $("#divisi").val();
        var getnama = $("#namacamp").val();
        $.ajax({
            url: "/<?= $menu ?>/camp",
            data: {
                perusahaan: getperusahaan,
                wilayah: getwilayah,
                divisi: getdivisi,
                isi: getnama,
                werbipakxo: '1000000000',
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

    function klikproyek() {
        var getnama = $("#namapaket").val();
        $.ajax({
            url: "/<?= $menu ?>/proyek",
            data: {
                perusahaan: '',
                wilayah: '',
                divisi: '',
                isi: getnama,
                werbipakxo: '0100010000',
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

    function loadpenerima1() {
        var getPenerima = $("#penerimaid").val();
        $.ajax({
            type: "POST",
            url: "/<?= $menu ?>/penerima1",
            data: {
                penerima: getPenerima,
            },
            dataType: "json",
            success: function(response) { // Ketika proses pengiriman berhasil
                $("#penerima").html(response.penerima);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function loadsatuan() {
        var getBarang = $("#barang").val();
        $.ajax({
            type: "POST",
            url: "/<?= $menu ?>/satuan",
            data: {
                barang: getBarang,
            },
            dataType: "json",
            success: function(response) {
                $("#satuan").val(response.satuan);
                var hargaformat = response.harga.toString().replace(".", ",");
                $("#harga").val(hargaformat).autoNumeric('set', hargaformat.replace(",", ".")); // Gunakan fungsi 'set' untuk mengatur nilai dengan autonumeric
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function loadbentuk() {
        var getAlat = $("#alat").val();
        $.ajax({
            type: "POST",
            url: "/<?= $menu ?>/bentuk",
            data: {
                alat: getAlat,
            },
            dataType: "json",
            success: function(response) {
                $("#bentuk").val(response.bentuk).change();
                $("#kategori").val(response.kategori).change();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        datasalesitem();
        $('#zsatuan2').attr('hidden', 'hidden');
        $('#zalat').attr('hidden', 'hidden');
        $('#ztanah').attr('hidden', 'hidden');
        $('#zinventaris').attr('hidden', 'hidden');

        $("#penerima").select2({
            ajax: {
                url: "/<?= $menu ?>/pelanggan",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilih: '1000',
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

        $("#barang").select2({
            ajax: {
                url: "/<?= $menu ?>/barang",
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
        });

        $("#alat").select2({
            ajax: {
                url: "/<?= $menu ?>/alat",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        pilihan: 'pribadi',
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

        $("#tanah").select2({
            ajax: {
                url: "/<?= $menu ?>/tanah",
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
        });

        $("#inventaris").select2({
            ajax: {
                url: "/<?= $menu ?>/inventaris",
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
        });

        $('.btnadd').click(function(e) {
            e.preventDefault();
            var form = $('.formjual')[0];
            var formData = new FormData(form);
            var url = '/<?= $menu ?>/addjual';
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
                    $('#akses, #perusahaan, #wilayah, #divisi, #kodecamp, #penerima, #barang, #alat, #tanah, #inventaris, #jasa, #bentuk, #kategori, #satuan2, #total, #catatan').removeClass('is-invalid');
                    $('.errakses, .errperusahaan, .errwilayah, .errdivisi, .errkodecamp, .errpenerima, .errbarang, .erralat, .errtanah, .errinventaris, .errjasa, .errbentuk, .errkategori, errsatuan2, .errtotal, .errcatatan').html('');

                    if (response.error) {
                        handleFieldError('akses', response.error.akses);
                        handleFieldError('perusahaan', response.error.perusahaan);
                        handleFieldError('wilayah', response.error.wilayah);
                        handleFieldError('divisi', response.error.divisi);
                        handleFieldError('kodecamp', response.error.kodecamp);
                        handleFieldError('penerima', response.error.penerima);
                        handleFieldError('barang', response.error.barang);
                        handleFieldError('alat', response.error.alat);
                        handleFieldError('tanah', response.error.tanah);
                        handleFieldError('inventaris', response.error.inventaris);
                        handleFieldError('jasa', response.error.jasa);
                        handleFieldError('bentuk', response.error.bentuk);
                        handleFieldError('kategori', response.error.kategori);
                        handleFieldError('satuan2', response.error.satuan2);
                        handleFieldError('total', response.error.total);
                        handleFieldError('catatan', response.error.catatan);
                    } else {
                        // clearFieldsAndDisableElements();
                        flashdata('success', response.sukses);
                        datasalesitem();
                        $(".js-example-data-ajax").empty().append(`<option value=""><?= lang('app.pilihsr') ?></option>`);
                        clearFieldValues();
                        // loadjasa();
                    }

                    function handleFieldError(field, error) {
                        if (error) {
                            $('#' + field).addClass('is-invalid');
                            $('.err' + field).html(error);
                        } else {
                            $('#' + field).removeClass('is-invalid');
                        }
                    }

                    // function clearFieldsAndDisableElements() {
                    //     $('#perusahaan, #wilayah, #divisi, #pilihdata').removeClass('is-invalid').attr('disabled', 'disabled');
                    //     $('#akses, #kodecamp, #total, #jasa, #bentuk, #kategori, #satuan2, #catatan').removeClass('is-invalid');
                    //     $('#namacamp, #nopo').attr('readonly', 'readonly');
                    // }

                    function clearFieldValues() {
                        // document.getElementById("nodoc").value = response.nodoc;
                        // document.getElementById("nopo").value = response.nopo;
                        // $("#nodoc").val(response.nodoc);
                        // $("#nopo").val(response.nopo);
                        // $("#jasa").val("");
                        $("#jumlah").val("");
                        $("#satuan").val("");
                        $("#harga").val("");
                        $("#diskon").val("");
                        $("#total").val("");
                        $("#catatan").val("");
                    }

                    // function loadjasa() {
                    //     $("#jasa").html(response.jasaso);
                    // }
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
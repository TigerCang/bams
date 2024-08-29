<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<!-- Page-body start -->
<div class="page-body">
    <form action="/nilaipegawai/save/<?= $idunik ?>" id="myForm" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="row">
            <div class="col-sm-12">

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
                        <input type="hidden" class="form-control" id="kui" name="kui" value="<?= $nodoc['0']->nama . '/' . $perusahaan1['0']->kui . $wilayah1['0']->kode . '/' . $divisi1['0']->kode . '/' ?>">
                        <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= $perusahaan1['0']->id ?>">
                        <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= $wilayah1['0']->id ?>">
                        <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= $divisi1['0']->id ?>">
                        <input type="hidden" class="form-control" id="idpegawai" name="idpegawai" value="<?= $pegawai1['0']->id ?>">

                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                            <div class="col-sm-11">
                                <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                    <?= "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($perusahaan as $db) :
                                        echo "<option value='{$db->id}' data-kui='{$db->kui}'" . ((old('perusahaan') == $db->id) || (empty(!$minta) && $minta['0']->perusahaan_id == $db->id && empty(old('perusahaan'))) ? 'selected' : '') . ">{$db->kode} => {$db->nama}</option>";
                                    endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                    <?= "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($wilayah as $db) :
                                        echo "<option value='{$db->id}' data-kui='{$db->kode}'" . ((old('wilayah') == $db->id) || (empty(!$minta) && $minta['0']->wilayah_id == $db->id && empty(old('wilayah'))) ? 'selected' : '') . ">{$db->nama}</option>";
                                    endforeach ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                    <?= "<option value=''>" . lang('app.pilih-') . "</option>";
                                    foreach ($divisi as $db) :
                                        echo "<option value='{$db->id}' data-kui='{$db->kode}'" . ((old('divisi') == $db->id) || (empty(!$minta) && $minta['0']->divisi_id == $db->id && empty(old('divisi'))) ? 'selected' : '') . ">{$db->nama}</option>";
                                    endforeach ?>
                                </select>
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
                                <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= (empty(!$minta) ? $minta['0']->nodoc : '') ?>">
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal') ?></label>
                            <div class="col-sm-2">
                                <input type="month" readonly class="form-control" id="tanggal" name="tanggal" value="<?= (empty(!$minta) ? $minta['0']->tgl_nilai : date('Y-m')) ?>">
                            </div>
                            <div class="col-sm-2 text-right"><button type="button" class="btn <?= lang('app.btnLegenda') ?> tampilaksilog"><?= lang('app.btn_Legenda') ?></button></div>

                        </div>
                        <div class="form-group row">
                            <label for="pegawai" class="col-sm-1 col-form-label"><?= lang('app.pegawai') ?></label>
                            <div class="col-sm-11">
                                <select id="pegawai" class="js-example-data-ajax" name="pegawai" <?= (empty(!$minta) ? 'disabled' : '') ?> onchange="loadpegawai()">
                                    <option value=""><?= lang('app.pilihsr') ?></option>
                                </select>
                                <div id="error" class="invalid-feedback d-block"><?= validation_show_error('pegawai') ?></div>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <table id="tabel" class="table table-striped table-hover table-bordered nowrap">
                    <thead>
                        <?php
                        echo "<tr class='bghead'>";
                        echo "<th scope='col' width='50'>#</th>";
                        echo "<th scope='col' hidden>" . lang('app.id') . "</th>";
                        echo "<th scope='col'>" . lang('app.katrating') . "</th>";
                        echo "<th scope='col' width='150' class='text-center'>" . lang('app.nilai') . " (0 - 20) </th>";
                        echo "</tr>"; ?>
                    </thead>
                    <tbody>
                        <?php $nomor = 1;
                        foreach ($kategori as $row) :
                            echo "<tr>";
                            echo "<td>" . $nomor++ . "." . "</td>";
                            echo "<td hidden>$row->id</td>";
                            echo "<td>$row->nama</td>";
                            echo "<td class='text-center' contenteditable='true' onkeydown='disableEnterKey(event)' oninput='validateInput(this)'>0</td>";
                            echo "</tr>";
                        endforeach ?>
                    </tbody>
                </table>
                <br>
                <button type="button" onclick="getDataFromTable()">Tes Data</button>

                <div class="card">
                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div class="col-4"></div>
                            <div class="col-4 text-center">
                                <?= "<button type='button' class='btn " . lang('app.btnCetak') . "'>" . lang('app.btn_Cetak') . "</button>";
                                echo " <button type='submit' class='btn " . lang('app.btnSave') . "'>" . lang('app.btn_Save') . "</button>"; ?>
                            </div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

            </div>
        </div>
    </form>
</div><!-- body end -->

<script>
    var awal = "<?= $nodoc['0']->nama ?>";
    $("#perusahaan").change(function() {
        document.getElementById('kui').value = awal + '/' + $("#perusahaan").find(':selected').data('kui') + $("#wilayah").find(':selected').data('kui') + '/' + $("#divisi").find(':selected').data('kui') + '/';
    });

    function validateInput(element) {
        const value = element.innerText;
        const numericValue = parseInt(value);

        if (value.trim() === '' || isNaN(numericValue) || numericValue < 0 || numericValue > 20) element.innerText = '0';
    }

    function disableEnterKey(event) {
        if (event.keyCode === 13) event.preventDefault();
    }

    $(document).ready(function() {
        $("#pegawai").select2({
            ajax: {
                url: "/itmk/pegawai",
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
        })
    });

    function loadpegawai() {
        var getPegawai = $("#pegawai").val();
        $.ajax({
            type: "POST",
            url: "/itmk/detilpegawai",
            data: {
                pegawai: getPegawai,
            },
            dataType: "json",
            success: function(response) {
                if (response.pegawai) {
                    var dataPegawai = response.pegawai['0'];
                    $("#idperusahaan").val(dataPegawai.perusahaan_id);
                    $("#idwilayah").val(dataPegawai.wilayah_id);
                    $("#iddivisi").val(dataPegawai.divisi_id);
                    $("#idpegawai").val(dataPegawai.id);
                    $("#wilayah").val(dataPegawai.wilayah_id).trigger("change");
                    $("#divisi").val(dataPegawai.divisi_id).trigger("change");
                    $("#perusahaan").val(dataPegawai.perusahaan_id).trigger("change");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    function getDataFromTable() {
        var data = [];

        $('#tabel tbody tr').each(function() {
            var row = [];
            $(this).find('td').each(function() {
                var cellValue = $(this).text();
                row.push(cellValue);
            });
            data.push(row);
        });

        // Lakukan sesuatu dengan data yang telah diambil, seperti mengirimnya ke server
    }
</script>

<?= $this->endSection() ?>
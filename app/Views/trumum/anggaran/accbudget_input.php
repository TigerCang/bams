<div onload="flashdata()"></div>

<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
$stat = "1"; ?>

<div class="page-body">
    <?= form_open('', ['class' => 'formbudget']) ?>
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
                    <input type="hidden" class="form-control" id="idperusahaan" name="idperusahaan" value="<?= $proyek1['0']->perusahaan_id ?>">
                    <input type="hidden" class="form-control" id="idwilayah" name="idwilayah" value="<?= $proyek1['0']->wilayah_id ?>">
                    <input type="hidden" class="form-control" id="iddivisi" name="iddivisi" value="<?= $proyek1['0']->divisi_id ?>">
                    <input type="hidden" class="form-control" id="idproyek" name="idproyek" value="<?= $budget['0']->proyek_id ?>">
                    <input type="hidden" class="form-control" id="idruas" name="idruas" value="<?= (empty($budget) ? old('idruas') : $budget['0']->ruas_id) ?>">
                    <input type="hidden" class="form-control" id="idtipe" name="idtipe" value="<?= (empty($proyek1) ? old('idtipe') : $proyek1['0']->tipe_id) ?>">
                    <input type="hidden" class="form-control" id="idkbli" name="idkbli">
                    <input type="hidden" class="form-control" id="kodekbli" name="kodekbli">
                    <input type="hidden" class="form-control" id="namakbli" name="namakbli">

                    <div class="form-group row">
                        <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='perusahaan' class='js-example-basic-single' name='perusahaan'" . (empty(!$budget) ? 'disabled' : '') . ">";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($perusahaan as $db) :
                                echo "<option value='{$db->id}'" . ((old('perusahaan') == $db->id) || (empty(!$budget) && $proyek1['0']->perusahaan_id == $db->id && empty(old('perusahaan')))  ? 'selected' : '') . " " . ($tuser['akses_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') . ">{$db->kode} => {$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='wilayah' class='js-example-basic-single' name='wilayah'" . (empty(!$budget) ? 'disabled' : '') . ">";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($wilayah as $db) :
                                echo "<option value='{$db->id}'" . ((old('wilayah') == $db->id) || (empty(!$budget) && $proyek1['0']->wilayah_id == $db->id && empty(old('wilayah'))) ? 'selected' : '') . " " . ($tuser['akses_wilayah'] == '1' || preg_match("/,$db->id,/i", $tuser['wilayah']) ? '' : 'disabled') . ">{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-2"></div>
                        <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi') ?></label>
                        <div class="col-sm-4">
                            <?= "<select id='divisi' class='js-example-basic-single' name='divisi'" . (empty(!$budget) ? 'disabled' : '') . ">";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            foreach ($divisi as $db) :
                                echo "<option value='{$db->id}'" . ((old('divisi') == $db->id) || (empty(!$budget) && $proyek1['0']->divisi_id == $db->id && empty(old('divisi'))) ? 'selected' : '') . " " . ($tuser['akses_divisi'] == '1' || preg_match("/,$db->id,/i", $tuser['divisi']) ? '' : 'disabled') . ">{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                    </div>
                </div>
            </div><!-- Akhir card table-->

            <div class="card">
                <div class="card-header <?= lang('app.bgInput') ?>">
                    <h5><?= lang('app.proyek') ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row">
                        <label for="kodeproyek" class="col-sm-1 col-form-label"><?= lang('app.proyek') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control" id="kodeproyek" name="kodeproyek" placeholder="<?= lang('app.harusisi') ?>" value="<?= $proyek1['0']->kode ?>">
                            <div class="invalid-feedback errkodeproyek"></div>
                        </div>
                        <div class="col-sm-9 input-group">
                            <input type="text" <?= (!empty($budget) ? 'readonly' : '') ?> class="form-control" id="namapaket" name="namapaket" value="<?= $proyek1['0']->paket ?>" autocomplete="off">
                            <?= (empty($budget) ? "<span class='input-group-addon'><i class='icofont icofont-search-alt-2' aria-hidden='true'></i></span>" : "<span class='input-group-addon'><i class='icofont icofont-link-alt' aria-hidden='true'></i></span>") ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="noadd" class="col-sm-1 col-form-label"><?= lang('app.noadd') ?></label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right" id="noadd" name="noadd" value="<?= $budget['0']->noadendum ?>">
                        </div>
                        <div class="col-sm-1"></div>
                        <label for="nibruto" class="col-sm-2 col-form-label text-right"><?= lang('app.nibruto') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="nibruto" name="nibruto" value="<?= $proyek1['0']->ni_bruto ?>" />
                        </div>
                        <label for="ninetto" class="col-sm-2 col-form-label text-right"><?= lang('app.ninetto') ?>&emsp;&emsp;</label>
                        <div class="col-sm-2">
                            <input type="text" readonly class="form-control form-control-right autonumber" data-digit-after-decimal="2" data-a-sep="." data-a-dec="," id="ninetto" name="ninetto" value="<?= $proyek1['0']->ni_netto ?>" />
                        </div>
                    </div>
                    <div class="form-group row" <?= ($budget['0']->asal == 'btlangsung' ? 'hidden' : '') ?>>
                        <label for="ruas" class="col-sm-1 col-form-label"><?= lang('app.ruas') ?></label>
                        <div class="col-sm-11">
                            <?= "<select id='ruas' class='js-example-basic-single' name='ruas'" . (empty(!$budget) ? 'disabled' : '') . ">";
                            echo "<option value=''>" . lang('app.pilih-') . "</option>";
                            echo "</select>"; ?>
                        </div>
                    </div>
                    <div class="form-group row" <?= ($budget['0']->asal == 'btlangsung' ? 'hidden' : '') ?>>
                        <label for="periode" class="col-sm-1 col-form-label"><?= lang('app.periode') ?></label>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal1" name="tanggal1" value="<?= $budget['0']->tanggal1 ?>">
                        </div>
                        <div class="col-sm-1 text-center">s/d</div>
                        <div class="col-sm-2">
                            <input type="date" readonly class="form-control" id="tanggal2" name="tanggal2" value="<?= $budget['0']->tanggal2 ?>">
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

                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <div class="col-4"></div>

                    </div>
                </div>
            </div><!-- Akhir card table-->

        </div>
    </div>
    <?= form_close() ?>
    <div class="dt-responsive table-responsive tabelbudget"></div>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    function databudgetitem() {
        var getIDU = "<?= $idunik ?>";
        var getasal = "<?= $budget['0']->asal ?>";
        var getkategori = $("#idtipe").val();
        $.ajax({
            url: "/budgetbiayal/tabbudgetitem",
            data: {
                idunik: getIDU,
                katproyek: getkategori,
                asal: getasal,
                aksi: '1',
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
        loadruas();
        databudgetitem();


    });
</script>

<?= $this->endSection() ?>
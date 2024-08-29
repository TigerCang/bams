<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?php
echo (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : '');
if ($tuser['acc_setuju'] == '0') $filcek = 'hidden';
$tcek = ($tuser['acc_setuju'] == '0' ? '' : 'checked'); ?>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                    <div class="job-badge" <?= $baru ?>><a href="/<?= $menu ?>/input" class="btn <?= $btnclascr ?>" <?= $actcreate ?>><?= $btntextcr ?></a></div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?> : </label>
                        <div class="col-sm-3">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan">
                                <option value="all" <?= ($tuser['act_perusahaan'] == '1' ? '' : 'disabled') ?>><?= lang('app.semua-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('perus') == $db->id ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= $db->kode ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select id="divisi" class="js-example-basic-single" name="divisi">
                                <option value="all" <?= ($tuser['act_divisi'] == '1' ? '' : 'disabled') ?>><?= lang('app.semua-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('div') == $db->id ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/,$db->id,/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2"><input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>"></div>
                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="datamintabarang()"></i></span>
                    </div>
                    <!--  -->
                    <div class="form-group row rownol">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-3" <?= $filstat ?>>
                            <select id="status" class="js-example-basic-single" name="status">
                                <option value="all"><?= lang('app.semua-') ?></option>
                                <option value="0"><?= lang('app.baru') ?></option>
                                <option value="c"><?= lang('app.blmacc') ?></option>
                                <option value="1"><?= lang('app.tunda') ?></option>
                                <option value="2"><?= lang('app.proses') ?></option>
                                <option value="3"><?= lang('app.revisi') ?></option>
                                <option value="4"><?= lang('app.tolak') ?></option>
                                <option value="5"><?= lang('app.batal') ?></option>
                                <option value="6"><?= lang('app.gudang') ?></option>
                                <option value="7"><?= lang('app.mintaok') ?></option>
                                <option value="8"><?= lang('app.pembelian') ?></option>
                            </select>
                            <!-- // <option value='9'>" . lang('app.selesai') . "</option> -->
                        </div>
                        <div class="col-sm-1" <?= $filcek ?>><input type="checkbox" id="acc" name="acc" data-toggle="toggle" data-on="<?= lang('app.setuju') ?>" data-off="<?= lang('app.no') ?>" data-onstyle="primary" data-offstyle="light" <?= $tcek ?>></div>
                    </div>
                    <div class="dt-responsive table-responsive viewmintabarang mt-2"></div>
                </div>
            </div>
        </div><!-- Akhir card -->

    </div>
</div><!-- body end -->

<script>
    function datamintabarang() {
        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = 'all';
        var getDivisi = $("#divisi").val();
        var getTanggal = $("#tanggal").val();
        var getStatus = $("#status").val();
        var getAcc = $("#acc").prop('checked');
        url = "/<?= $menu ?>/tabminta";
        $.ajax({
            url: url,
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                divisi: getDivisi,
                tanggal: getTanggal,
                status: getStatus,
                acc: getAcc,
            },
            dataType: "json",
            success: function(response) {
                $('.viewmintabarang').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        var selectPerusahaan = $('#perusahaan');
        var selectedPerusahaan = selectPerusahaan.val();
        var selectDivisi = $('#divisi');
        var selectedDivisi = selectDivisi.val();

        if (selectedPerusahaan && selectedPerusahaan !== 'all' && selectedDivisi && selectedDivisi !== 'all') {
            datamintabarang();
            return;
        } else {
            selectPerusahaan.find('option').each(function() {
                if (!$(this).is(':disabled') && $(this).val() !== 'all') {
                    $(this).prop('selected', true);
                    return false;
                }
            });
            selectDivisi.find('option').each(function() {
                if (!$(this).is(':disabled') && $(this).val() !== 'all') {
                    $(this).prop('selected', true);
                    return false;
                }
            });
        }
        datamintabarang();
    });
</script>

<?= $this->endSection() ?>
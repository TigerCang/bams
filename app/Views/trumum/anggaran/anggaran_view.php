<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                    <div class="job-badge" <?= $baru ?>><a href="/<?= $menu ?>/input" class="btn <?= $btnclascr ?>"><?= $btntextcr ?></a></div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?> : </label>
                        <div class="col-sm-3">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan">
                                <option value="all" <?= ($tuser['act_perusahaan'] == '1' ? '' : 'disabled') ?>><?= lang('app.semua-') ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('perus') == $db->id ? 'selected' : '') . ($tuser['act_perusahaan'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['perusahaan']) ? '' : 'disabled') ?>><?= $db->kode ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3" <?= $dhid ?>>
                            <select id="divisi" class="js-example-basic-single" name="divisi">
                                <option value="all" <?= ($tuser['act_divisi'] == '1' ? '' : 'disabled') ?>><?= lang('app.semua-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('div') == $db->id ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3" <?= $whid ?>>
                            <select id="wilayah" class="js-example-basic-single" name="wilayah">
                                <option value="all" <?= ($tuser['act_wilayah'] == '1' ? '' : 'disabled') ?>><?= lang('app.semua-') ?></option>
                                <?php foreach ($wilayah as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('wil') == $db->id ? 'selected' : '') . ($tuser['act_wilayah'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['wilayah']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2" <?= $thid ?>>
                            <select id="tujuan" class="js-example-basic-single" name="tujuan">
                                <option value="pilih-" selected><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selbeban as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (session()->getFlashdata('tujuan') == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="tahun" name="tahun" value="<?= session()->getFlashdata('tahun') ?? date("Y") ?>" min="2020" max="2100">
                        </div>
                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="dataanggaran()"></i></span>
                    </div>
                    <!--  -->
                    <div class="form-group row rownol">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-2" <?= $phid ?>>
                            <select id="pilih" class="js-example-basic-single" name="pilih">
                                <option value="" selected><?= lang('app.pilih-') ?></option>
                                <?php foreach ($selnama as $db) : ?>
                                    <option value="<?= $db->nama ?>" <?= (session()->getFlashdata('pilih') == $db->nama ? 'selected' : '') ?>><?= lang('app.' . $db->nama) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="dt-responsive table-responsive viewanggaran mt-2"></div>
                </div>
            </div><!-- Akhir card-->

        </div>
    </div>
</div><!-- body end -->

<script>
    function dataanggaran() {
        var getPerusahaan = $("#perusahaan").val();
        var getDivisi = $("#divisi").val();
        var getWilayah = $("#wilayah").val();
        var getPilih = $("#pilih").val();
        var getTujuan = $("#tujuan").val();
        var getTahun = $("#tahun").val();
        var getMenu = "<?= $menu ?>";
        // var getAcc = $("#acc").prop('checked');
        var getAcc = "1";
        (getMenu === 'anggobjek' ? getWilayah = 'all' : getDivisi = 'all');
        if (getMenu !== 'anggobjek') getTujuan = 'proyek';
        url = "/<?= $menu ?>/tabinduk";
        $.ajax({
            url: url,
            data: {
                perusahaan: getPerusahaan,
                divisi: getDivisi,
                wilayah: getWilayah,
                pilih: getPilih,
                tujuan: getTujuan,
                tahun: getTahun,
                menu: getMenu,
                acc: getAcc,
            },
            dataType: "json",
            success: function(response) {
                $('.viewanggaran').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        // var selectPerusahaan = $('#perusahaan');
        // var selectedPerusahaan = selectPerusahaan.val();
        var selectPerusahaan = $('#perusahaan');
        var selectedPerusahaan = '<?= session()->getFlashdata('perus') ?>';
        var selectDivisi = $('#divisi');
        var selectedDivisi = '<?= session()->getFlashdata('div') ?>';
        var selectWilayah = $('#wilayah');
        var selectedWilayah = '<?= session()->getFlashdata('wil') ?>';

        if (selectedPerusahaan && selectedPerusahaan !== 'all' && selectedDivisi && selectedDivisi !== 'all' && selectedWilayah && selectedWilayah !== 'all') {
            dataanggaran();
            return;
        } else {
            //     selectPerusahaan.find('option').each(function() {
            //         if (!$(this).is(':disabled') && $(this).val() !== 'all') {
            //             $(this).prop('selected', true);
            //             return false;
            //         }
            //     });
            selectPerusahaan.find('option').each(function() {
                var isDisabled = $(this).is(':disabled');
                var value = $(this).val();
                if (value === selectedPerusahaan && !isDisabled) {
                    $(this).prop('selected', true);
                    return false;
                } else if (!isDisabled && value !== 'all' && !selectedPerusahaan) {
                    $(this).prop('selected', true);
                    return false;
                }
            });
            selectDivisi.find('option').each(function() {
                var isDisabled = $(this).is(':disabled');
                var value = $(this).val();
                if (value === selectedDivisi && !isDisabled) {
                    $(this).prop('selected', true);
                    return false;
                } else if (!isDisabled && value !== 'all' && !selectedDivisi) {
                    $(this).prop('selected', true);
                    return false;
                }
            });
            selectWilayah.find('option').each(function() {
                var isDisabled = $(this).is(':disabled');
                var value = $(this).val();
                if (value === selectedWilayah && !isDisabled) {
                    $(this).prop('selected', true);
                    return false;
                } else if (!isDisabled && value !== 'all' && !selectedWilayah) {
                    $(this).prop('selected', true);
                    return false;
                }
            });
        }
        dataanggaran();
    });
</script>

<?= $this->endSection() ?>
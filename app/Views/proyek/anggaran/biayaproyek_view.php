<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                    <div class="job-badge" <?= ($asal == 'acc' ? 'hidden' : '') ?>>
                        <?php echo "<a href='/$menu/input' class='btn " . lang('app.btnCreate') .  "'>" . lang('app.btn_Create') . "</a>"; ?>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row rownol" <?= ($asal == 'acc' ? 'hidden' : '') ?>>
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?> : </label>
                        <div class="col-sm-3">
                            <?= "<select id='perusahaan' class='js-example-basic-single' name='perusahaan'>";
                            echo "<option value='all'" . ($tuser['akses_perusahaan'] == '1' ? '' : 'disabled') . ">" . lang('app.semua-') . "</option>";
                            foreach ($perusahaan as $db) :
                                echo "<option value='{$db->id}'" . (session()->getFlashdata('perus') == $db->id ? 'selected' : '') . " " . ($tuser['akses_perusahaan'] == '1' || preg_match("/,$db->id,/i", $tuser['perusahaan']) ? '' : 'disabled') . ">{$db->kode}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-3">
                            <?= "<select id='wilayah' class='js-example-basic-single' name='wilayah'>";
                            echo "<option value='all'" . ($tuser['akses_wilayah'] == '1' ? '' : 'disabled') . ">" . lang('app.semua-') . "</option>";
                            foreach ($wilayah as $db) :
                                echo "<option value='{$db->id}'" . (session()->getFlashdata('wil') == $db->id ? 'selected' : '') . " " . ($tuser['akses_wilayah'] == '1' || preg_match("/,$db->id,/i", $tuser['wilayah']) ? '' : 'disabled') . ">{$db->nama}</option>";
                            endforeach;
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-1">
                            <input type="number" class="form-control" id="tahun" name="tahun" value="<?= date("Y") ?>" min="2000" max="2100" autocomplete="off">
                        </div>
                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="caridata()"></i></span>
                    </div>
                    <div class="dt-responsive table-responsive viewanggaran"></div>
                </div>
            </div><!-- Akhir card-->

        </div>
    </div>
</div><!-- body end -->

<script>
    function caridata() {
        var getPerusahaan = $("#perusahaan").val();
        var getWilayah = $("#wilayah").val();
        var getTahun = $("#tahun").val();
        var getMenu = "<?= $menu ?>";
        var getAsal = "<?= $asal ?>";
        url = "/<?= $menu ?>/tabanginduk";
        $.ajax({
            url: url,
            data: {
                perusahaan: getPerusahaan,
                wilayah: getWilayah,
                tahun: getTahun,
                menu: getMenu,
                asal: getAsal,
            },
            dataType: "json",
            success: function(response) {
                $(' .viewanggaran').html(response.data);
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
        var selectWilayah = $('#wilayah');
        var selectedWilayah = selectWilayah.val();
        if (selectedPerusahaan && selectedPerusahaan !== 'all' && selectedWilayah && selectedWilayah !== 'all') {
            caridata()
            return;
        } else {
            selectPerusahaan.find('option').each(function() {
                if (!$(this).is(':disabled') && $(this).val() !== 'all') {
                    $(this).prop('selected', true);
                    return false;
                }
            });
            selectWilayah.find('option').each(function() {
                if (!$(this).is(':disabled') && $(this).val() !== 'all') {
                    $(this).prop('selected', true);
                    return false;
                }
            });
        }
        caridata();
    });
</script>

<?= $this->endSection() ?>
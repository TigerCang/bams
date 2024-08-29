<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList'); ?>">
                    <h5><?= lang('app.daftardata'); ?></h5>
                    <?php if ($pesan == '1') {
                        echo "<div class='job-badge'>";
                        echo "<a href='/$menu/input' class='btn " . lang('app.btnCreate') .  "'>" . lang('app.btn_Create') . "</a>";
                        echo "</div>";
                    } ?>
                </div>

                <?php if (session()->getFlashdata('pesan')) :
                    echo "<div onload=\"flashdata('" . session()->getFlashdata('pesan') . "','success','" . session()->getFlashdata('judul') . "')\"></div>";
                endif; ?>

                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan'); ?> : </label>
                        <div class="col-sm-5 input-group">
                            <select id="perusahaan" class="js-example-basic-single" name="perusahaan">
                                <option value="all" <?= ($tuser['akses_perusahaan'] == '1') ? '' : 'disabled'; ?>><?= lang('app.semua-'); ?></option>
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id; ?>" <?= (session()->getFlashdata('perus') == $db->id) ? 'selected' : (($perusahaan['0']->id == $db->id) ? 'selected' : ''); ?> <?= ($tuser['akses_perusahaan'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['perusahaan'])) ? '' : 'disabled'); ?>><?= $db->kode . '&emsp;=>&emsp;' . $db->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-3 input-group">
                            <select id="divisi" class="js-example-basic-single" name="divisi">
                                <option value="all" <?= ($tuser['akses_divisi'] == '1') ? '' : 'disabled'; ?>><?= lang('app.semua-'); ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id; ?>" <?= (session()->getFlashdata('div') == $db->id) ? 'selected' : (($divisi['0']->id == $db->id) ? 'selected' : ''); ?> <?= ($tuser['akses_divisi'] == '1') ? '' : ((preg_match("/,$db->id,/i", $tuser['divisi'])) ? '' : 'disabled'); ?>><?= $db->nama; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d'); ?>">
                                <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="caridata()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="dt-responsive table-responsive viewpesanbarang mt-2"></div>
                </div>
            </div><!-- Akhir card-->

        </div>
    </div>
</div><!-- body end -->

<script>
    function caridata() {
        var getperusahaan = $("#perusahaan").val();
        var getwilayah = 'all';
        var getdivisi = $("#divisi").val();
        var gettanggal = $("#tanggal").val();
        var getmenu = "<?= $menu; ?>";
        var getpesan = "<?= $pesan; ?>";
        url = "/<?= $menu; ?>/tabpesan";

        $.ajax({
            url: url,
            data: {
                perusahaan: getperusahaan,
                wilayah: getwilayah,
                divisi: getdivisi,
                tanggal: gettanggal,
                menu: getmenu,
                pesan: getpesan,
            },
            dataType: "json",
            success: function(response) {
                $('.viewpesanbarang').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        caridata();
    });
</script>

<?= $this->endSection(); ?>
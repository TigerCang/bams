<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                    <?php if ($tandat == '0') {
                        echo "<div class='job-badge'>";
                        echo "<a href='/$menu/input' class='btn " . lang('app.btnCreate') .  "'>" . lang('app.btn_Create') . "</a>";
                        echo "</div>";
                    } ?>
                </div>
                <?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>

                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?> : </label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="month" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m') ?>">
                                <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="caridata()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="dt-responsive table-responsive viewdata mt-2"></div>
                </div>
            </div><!-- Akhir card-->

        </div>
    </div>
</div><!-- body end -->

<script>
    function caridata() {
        var gettanggal = $("#tanggal").val();
        var getmenu = "<?= $menu ?>";
        var getpeminta = "<?= $peminta ?>";
        var getpegawai = "<?= $pegawai ?>";
        url = "/<?= $menu ?>/tabminta";

        $.ajax({
            url: url,
            data: {
                tanggal: gettanggal,
                menu: getmenu,
                peminta: getpeminta,
                pegawai: getpegawai,
            },
            dataType: "json",
            success: function(response) {
                $('.viewdata').html(response.data);
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

<?= $this->endSection() ?>
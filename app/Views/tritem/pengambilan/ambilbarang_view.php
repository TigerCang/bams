<!-- <div onload="flashdata()"></div> -->
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                    <div class="job-badge" <?= $baru ?>><?= "<a href='/$menu/input' class='btn $btnclascr' $actcreate>$btntextcr</a>"; ?></div>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?> : </label>
                        <div class="col-sm-2"><input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>"></div>
                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="dataambilbarang()"></i></span>
                    </div>
                    <div class="dt-responsive table-responsive viewmintabarang mt-2"></div>
                </div>
            </div>
        </div><!-- Akhir card -->

    </div>
</div>
</div><!-- body end -->

<script>
    function datamintabarang() {
        url = "/ambilbarang/tabambil";
        $.ajax({
            url: url,
            data: {
                tanggal: getTanggal,
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
        datamintabarang();
    });
</script>

<?= $this->endSection() ?>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                    <div class="job-badge"><?= "<a href='/$menu/input' class='btn " . lang('app.btnCreate') .  "' " . ($tuser['act_create'] == '0' ? 'disabled' : '') . ">" . lang('app.btn_Create') . "</a>"; ?></div>
                </div>

                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?> : </label>
                        <div class="col-sm-6" <?= $hid ?>>
                            <?= "<select id='camp' class='js-example-data-ajax' name='camp'>";
                            echo "<option value='' selected>" . lang('app.pilihsr') . "</option>";
                            // if (empty(!$proyek1)) echo "<option value='{$proyek1['0']->id}' selected>{$proyek1['0']->kode} => {$proyek1['0']->paket}</option>";
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                        </div>
                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="caridata()"></i></span>
                    </div>
                    <div class="dt-responsive table-responsive viewdata mt-2"></div>
                </div>
            </div><!-- Akhir card-->

        </div>
    </div>
</div><!-- body end -->

<script>
    function caridata() {
        var getcamp = $("#camp").val();
        var gettanggal = $("#tanggal").val();
        var getmenu = '<?= $menu ?>';
        var getasal = '<?= $asal ?>';
        var getcepsa = '<?= $cepsa ?>';
        $.ajax({
            url: "/<?= $menu ?>/tabsales",
            data: {
                camp: getcamp,
                proyek: '',
                tanggal: gettanggal,
                menu: getmenu,
                asal: getasal,
                proses: '0',
                cepsa: getcepsa, //camp penerima proyek status aksi
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

        $("#camp").select2({
            ajax: {
                url: "/<?= $menu ?>/loadcamp",
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
        });
    });
</script>

<?= $this->endSection() ?>
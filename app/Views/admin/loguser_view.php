<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                </div>
                <!--  -->
                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="user" class="col-sm-1 col-form-label" <?= $uhid ?>><?= lang('app.usernama') ?> : </label>
                        <div class="col-sm-4" <?= $uhid ?>>
                            <select id="user" class="js-example-basic-single" name="user">
                                <option value=""><?= lang('app.pilih-') ?></option>
                                <?php foreach ($user as $db) : ?>
                                    <option value="<?= $db->kode ?>"><?= $db->kode ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-1" <?= $uhid ?>></div>
                        <label for="aktifitas" class="col-sm-1 col-form-label"><?= lang('app.cari') ?> : </label>
                        <div class="col-sm-5 input-group">
                            <input type="text" class="form-control" id="aktifitas" name="aktifitas" value="" placeholder="<?= lang('app.menudata') ?>">
                            <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="cariaktifitas()"></i></span>
                        </div>
                        <div class="col-sm-12">&nbsp;</div>
                        <div class="col-sm-12">
                            <div class="checkbox-fade fade-in-primary d-inline">
                                <label>
                                    <input type="checkbox" id="create">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.create') ?></span>
                                </label>&emsp;&emsp;
                                <label>
                                    <input type="checkbox" id="detil">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.lihat') ?></span>
                                </label>&emsp;&emsp;
                                <label>
                                    <input type="checkbox" id="update">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.update') ?></span>
                                </label>&emsp;&emsp;
                                <label>
                                    <input type="checkbox" id="delete">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.delete') ?></span>
                                </label>&emsp;&emsp;
                                <label>
                                    <input type="checkbox" id="pasti">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.pasti') ?></span>
                                </label>&emsp;&emsp;
                                <label>
                                    <input type="checkbox" id="simpan">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.simpan') ?></span>
                                </label>&emsp;&emsp;
                                <label>
                                    <input type="checkbox" id="batal">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.batal') ?></span>
                                </label>&emsp;&emsp;
                                <label>
                                    <input type="checkbox" id="log10">
                                    <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                    <span class="text-inverse"><?= lang('app.log10') ?></span>
                                </label>&emsp;&emsp;
                            </div>
                        </div>
                    </div>
                    <div class="dt-responsive table-responsive viewaktifitas mt-2"></div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
</div><!-- body end -->

<script>
    function cariaktifitas() {
        var getAktifitas = $("#aktifitas").val();
        var getUser = $("#user").val();
        var getHid = "<?= $uhid ?>";
        var getDetil = document.getElementById('detil').checked;
        $.ajax({
            url: "/loguser/tablog",
            data: {
                usernama: getUser,
                isi: getAktifitas,
                hid: getHid,
                detil: getDetil,
            },
            dataType: "json",
            success: function(response) {
                $('.viewaktifitas').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }

    $(document).ready(function() {
        cariaktifitas();
    });
</script>

<?= $this->endSection() ?>
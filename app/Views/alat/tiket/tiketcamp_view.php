<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : ''); ?>

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

                <div class="card-block mt-2">
                    <div class="form-group row rownol">
                        <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan') ?> : </label>
                        <div class="col-sm-6 input-group" <?= ($tandat == '1') ? '' : 'hidden' ?>>
                            <?= "<select id='proyek' class='js-example-data-ajax' name='proyek'>";
                            echo "<option value='' selected>" . lang('app.pilihsr') . "</option>";
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-6 input-group" <?= ($tandat == '1') ? 'hidden' : '' ?>>
                            <?= "<select id='camp' class='js-example-data-ajax' name='camp'>";
                            echo "<option value='' selected>" . lang('app.pilihsr') . "</option>";
                            // if (empty(!$proyek1)) echo "<option value='{$proyek1['0']->id}' selected>{$proyek1['0']->kode} => {$proyek1['0']->paket}</option>";
                            echo "</select>"; ?>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
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
        var getcamp = $("#camp").val();
        var getproyek = $("#proyek").val();
        var gettanggal = $("#tanggal").val();
        $.ajax({
            url: "/<?= $menu ?>/tabdata",
            data: {
                camp: getcamp,
                proyek: getproyek,
                tanggal: gettanggal,
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
        // caridata();

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

        $("#proyek").select2({
            ajax: {
                url: "/<?= $menu ?>/loadproyek",
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
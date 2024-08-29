<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<?= (session()->getFlashdata('judul') ? "<div onload=\"flashdata('success','" . session()->getFlashdata('judul') . "')\"></div>" : '') ?>
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList') ?>">
                    <h5><?= lang('app.daftardata') ?></h5>
                    <div class="job-badge"><a href="/inventaris/input" class="btn <?= $btnclascr ?>" <?= $actcreate ?>><?= $btntextcr ?></a></div>
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
                        <div class="col-sm-3 input-group">
                            <select id="divisi" class="js-example-basic-single" name="divisi">
                                <option value="all" <?= ($tuser['act_divisi'] == '1' ? '' : 'disabled') ?>><?= lang('app.semua-') ?></option>
                                <?php foreach ($divisi as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('div') == $db->id ? 'selected' : '') . ($tuser['act_divisi'] == '1' || preg_match("/(^|,)" . $db->id . "(,|$)/i", $tuser['divisi']) ? '' : 'disabled') ?>><?= $db->nama ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <span class="input-group-addon"><i class="icofont icofont-search-alt-2" aria-hidden="true" onclick="caridata()"></i></span>
                    </div>
                    <div class="dt-responsive table-responsive viewdata mt-2"></div>
                </div>
            </div><!-- Akhir card -->

        </div>
    </div>
</div><!-- body end -->

<script>
    function caridata() {
        var getPerusahaan = $("#perusahaan").val();
        var getDivisi = $("#divisi").val();
        $.ajax({
            url: "/inventaris/tabdata",
            data: {
                perusahaan: getPerusahaan,
                divisi: getDivisi,
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
        var selectPerusahaan = $('#perusahaan');
        var selectedPerusahaan = selectPerusahaan.val();
        var selectDivisi = $('#divisi');
        var selectedDivisi = selectDivisi.val();

        if (selectedPerusahaan && selectedPerusahaan !== 'all' && selectedDivisi && selectedDivisi !== 'all') {
            caridata()
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
        caridata();
    });
</script>

<?= $this->endSection() ?>
<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title">Filter</h5>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 d-flex justify-content-between align-items-center mb-4">
                        <div class="form-floating form-floating-outline w-100 me-4">
                            <select class="select2-subtext form-select" id="sperusahaan" name="sperusahaan" data-allow-clear="true" data-placeholder="<?= lang('app.pilih-') ?>">
                                <?php foreach ($perusahaan as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('flash-perus') == $db->id ? 'selected' : '') ?> data-subtext="<?= $db->nama ?>"><?= $db->kode ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="sperusahaan"><?= lang('app.perusahaan') ?></label>
                        </div>
                        <div>
                            <button type="button" class="<?= json('btn cari') ?> btncari"><?= lang('app.btn cari') ?></button>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center row <?= (session()->getFlashdata('pesan') ? 'py-3' : 'py-0') ?> gap-3 gap-md-0">
                    <div>
                        <button type="button" class="<?= json('btn create') ?> btninput" <?= ($tuser['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                    </div>
                </div>
                <?php if (session()->getFlashdata('pesan')) :
                    echo json('alert sukses-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive viewTabel"></div>
        </div><!--/ Card -->

    </div><!--/ Col -->
</div><!--/ Row -->

<script>
    $(document).ready(function() {
        $('.btncari').trigger('click');
    });

    $(document).ready(function() {
        $(document).on('click', '.btninput', function(e) {
            e.preventDefault();
            var getIdu = $(this).data('idunik') || '';
            var url = '<?= $link ?>/input?datakey=' + getIdu;
            window.location.href = url;
        })
    });

    $(document).on('click', '.btncari', function(e) {
        e.preventDefault();
        var getPerusahaan = $("#sperusahaan").val();
        $.ajax({
            url: "<?= $link ?>/cari",
            type: "POST",
            data: {
                perusahaan: getPerusahaan,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTabel').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })
</script>

<?= $this->endSection() ?>
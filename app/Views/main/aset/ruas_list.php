<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title" <?= $filproyek ?>>Filter</h5>
                <div class="row" <?= $filproyek ?>>
                    <div class="col-12 col-md-12 col-lg-8 d-flex justify-content-between align-items-center mb-4">
                        <div class="form-floating form-floating-outline w-100 me-4">
                            <select class="select2-subtext form-select" id="sproyek" name="sproyek" data-allow-clear="true" data-placeholder="<?= lang('app.pilihsr') ?>">
                                <?php if (session()->getFlashdata('flash-proyek')) : ?> <option value="<?= session()->getFlashdata('flash-proyek')[0]->id ?>" selected data-subtext="<?= (session()->getFlashdata('flash-proyek')[0]->paket) ?>"><?= (session()->getFlashdata('flash-proyek')[0]->kode) ?></option><?php endif ?>
                            </select>
                            <label for="sproyek"><?= lang('app.proyek') ?></label>
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

<div class="modalinput" style="display: none;"></div>

<script>
    $(document).ready(function() {
        $('.btncari').trigger('click');

        $('#sproyek').select2({
            ajax: {
                url: "<?= $link ?>/proyek",
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
            <?= json('min input') ?>,
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });
    });

    $(document).on('click', '.btninput', function(e) {
        e.preventDefault();
        var getIdu = $(this).data('idunik') || '';
        $.ajax({
            url: "<?= $link ?>/input",
            data: {
                datakey: getIdu,
            },
            dataType: "json",
            success: function(response) {
                $('.modalinput').html(response.data).show();
                $('#modal-input').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    $(document).on('click', '.btncari', function(e) {
        e.preventDefault();
        var getProyek = $("#sproyek").val() || '-';
        if ("<?= $tujuan ?>" == 'jarak') {
            getProyek = '';
        }
        $.ajax({
            url: "<?= $link ?>/cari",
            type: "POST",
            data: {
                proyek: getProyek,
                cabang: '',
                tujuan: "<?= $tujuan ?>",
                cpl: "<?= $cpl ?>",
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
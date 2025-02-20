<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title">Filter</h5>
                <div class="row g-2 mb-4">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sCompany" name="sCompany" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?= companyOptions($company, session()->getFlashdata('flash-company'), thisUser()) ?>
                            </select>
                            <label for="sCompany"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sPosition" name="sPosition" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <?php foreach ($selectPosition as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (session()->getFlashdata('flash-position') == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="sPosition"><?= lang('app.position') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <button type="button" class="<?= json('btn search') ?> btn-search"><?= lang('app.btn search') ?></button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center row <?= (session()->getFlashdata('message') ? 'py-3' : 'py-0') ?> gap-3 gap-md-0">
                    <div>
                        <button type="button" class="<?= json('btn create') ?> btn-input" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                    </div>
                </div>
                <?php if (session()->getFlashdata('message')) :
                    echo json('alert success-1') . session()->getFlashdata('message') . json('alert success-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive viewTable"></div>
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->

<script>
    $(function() {
        $('.btn-search').trigger('click');
    });

    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique') || '';
        var url = '<?= $link ?>/input?search=' + getUnique;
        window.location.href = url;
    })

    $(document).on('click', '.btn-search', function(e) {
        e.preventDefault();
        var getCompany = $("#sCompany").val();
        var getPosition = $("#sPosition").val();
        $.ajax({
            url: "<?= $link ?>/search",
            type: "POST",
            data: {
                company: getCompany,
                position: getPosition,
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })
</script>

<?= $this->endSection() ?>
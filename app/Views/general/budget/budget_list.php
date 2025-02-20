<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title">Filter</h5>
                <div class="row g-2 mb-4">
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sObject" name="sObject">
                                <?php foreach ($selectObject as $db) : ?>
                                    <?php if (($choice == 'project' && $db->name == 'project') || ($choice == 'object' && $db->name != 'project')) : ?>
                                        <?php if ($db->number <= 10) : ?>
                                            <option value="<?= $db->name ?>" <?= (isset($budget[0]->object) && $budget[0]->object == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                        <?php endif ?>
                                    <?php endif ?>
                                <?php endforeach ?>
                            </select>
                            <label for="sObject"><?= lang('app.object') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 col-lg-2">
                        <div class="form-floating form-floating-outline">
                            <input type="number" class="form-control" id="sYear" name="sYear" placeholder="" value="0" min="2025" max="2100" />
                            <label for="sYear"><?= lang('app.year') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 col-lg-2">
                        <button type="button" class="<?= json('btn search') ?> btn-search"><?= lang('app.btn search') ?></button>
                    </div>

                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sBranch" name="sBranch" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                            </select>
                            <label for="branch" id="branchLabel"><?= lang('app.branch') ?></label>
                        </div>
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
        var getUrl = window.location.pathname.split('/').pop();
        var getObject = $("#sObject").val();
        var getYear = $("#sYear").val();
        $.ajax({
            url: "/search/budget",
            type: "POST",
            data: {
                url: getUrl,
                object: getObject,
                year: getYear,
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
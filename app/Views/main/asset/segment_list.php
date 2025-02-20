<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title" <?= $filter ?>>Filter</h5>
                <div class="row g-2 mb-4" <?= $filter ?>>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="sProject" name="sProject" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($project1) : ?>
                                    <option value="<?= $project1[0]->id ?>" selected><?= "{$project1[0]->code} &ensp;&emsp; {$project1[0]->package_name}" ?></option>
                                <?php endif ?>
                            </select>
                            <label for="sProject"><?= lang('app.project') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-2 col-lg-2">
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
<div class="modal-input" style="display: none;"></div>

<script>
    // function initializeSelect2(selector, ajaxUrl) {
    //     $(selector).select2({
    //         ajax: {
    //             url: ajaxUrl,
    //             type: "POST",
    //             dataType: "json",
    //             delay: 250,
    //             data: function(params) {
    //                 return {
    //                     searchTerm: params.term,
    //                     company: '',
    //                     region: '',
    //                     division: '',
    //                 };
    //             },
    //             processResults: function(response) {
    //                 return {
    //                     results: response
    //                 };
    //             },
    //             cache: true
    //         },
    //         <= json('min input') ?>,
    //     });
    // }

    $(document).ready(function() {
        // initializeSelect2('#sProject', "/load/project");
        $('.btn-search').trigger('click');

        $('#sProject').select2({
            ajax: {
                url: "/load/project",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        company: '',
                        region: '',
                        division: '',
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
        });
    });

    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique') || '';
        $.ajax({
            url: "<?= $link ?>/input",
            data: {
                search: getUnique,
            },
            dataType: "json",
            success: function(response) {
                $('.modal-input').html(response.data).show();
                $('#modal-input').modal('show')
                // $('#modal-input').on('shown.bs.modal', function() {
                //     initializeSelect2('#sProject', "/load/project");
                // });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    $(document).on('click', '.btn-search', function(e) {
        e.preventDefault();
        var getUrl = window.location.pathname.split('/').pop();
        var getProject = (getUrl == 'distance') ? '' : ($("#sProject").val() || '-');
        $.ajax({
            url: "/search/distance",
            type: "POST",
            data: {
                project: getProject,
                branch: '',
                url: getUrl,
                bcd: getBCD,
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
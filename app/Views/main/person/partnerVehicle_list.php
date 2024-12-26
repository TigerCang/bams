<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-header pb-0">
                <h5 class="card-title">Filter</h5>
                <div class="row g-2 mb-4">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline w-100 me-4">
                            <select class="select2-subtext form-select" id="sPerson" name="sPerson" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($person1) : ?> <option value="<?= $person1[0]->id ?>" selected data-subtext="<?= $person1[0]->name ?>"><?= $person1[0]->code ?></option><?php endif ?>
                            </select>
                            <label for="sPerson"><?= lang('app.partner') ?></label>
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
    $(document).ready(function() {
        $('.btn-search').trigger('click');

        $('#sPerson').select2({
            ajax: {
                url: "/load/person",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        choose: '00100',
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

                $('#modal-input').on('shown.bs.modal', function() {
                    $('#sPerson').select2({
                        ajax: {
                            url: "/load/person",
                            type: "POST",
                            dataType: "json",
                            delay: 250,
                            data: function(params) {
                                return {
                                    searchTerm: params.term,
                                    choose: '00100',
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
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    $(document).on('click', '.btn-search', function(e) {
        e.preventDefault();
        var getPerson = $("#sPerson").val();
        var getUrl = "<?= substr($link, 1) ?>";
        $.ajax({
            url: "/search/tool",
            type: "POST",
            data: {
                company: '',
                person: getPerson,
                url: getUrl,
                con: '001',
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
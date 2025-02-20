<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center row <?= (session()->getFlashdata('message') ? 'py-3' : 'py-0') ?> gap-3 gap-md-0">
                    <div>
                        <button type="button" class="<?= json('btn create') ?> btn-input" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                    </div>
                </div>
                <div id="alertContainer" class="mt-2"></div>
                <?php if (session()->getFlashdata('message')) :
                    echo json('alert success-1') . session()->getFlashdata('message') . json('alert success-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tableInit" class="table table-striped table-hover nowrap">
                    <thead>
                        <tr class="tr-color">
                            <th width="5">#</th>
                            <th width="100"><?= lang('app.date') ?></th>
                            <th><?= lang('app.description') ?></th>
                            <th width="100" class='text-center'><?= lang('app.cut leave') ?></th>
                            <th width="200"><?= lang('app.save by') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($calendar as $index => $row) : ?>
                            <tr>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= formatDate($row->day_date) ?></td>
                                <td><?= $row->name ?></td>
                                <td class='text-center'><?= ($row->cut_day == '1' ? '<i class="fa-regular fa-square-check"></i>' : '') ?></td>
                                <td><?= $row->user ?></td>
                                <td><?php if (thisUser()['act_button'][3] == '1') : ?>
                                        <a href="javascript:void(0);" class="btn-delete" data-unique="<?= $row->unique ?>" data-date="<?= $row->day_date ?>"><?= json('btn i-delete') ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div><!--/ Card Datatable -->
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->
<div class="modal-input" style="display: none;"></div>

<script>
    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault(); // Prevent default link behavior
        $.ajax({
            url: "<?= $link ?>/input",
            dataType: "json",
            success: function(response) {
                $('.modal-input').html(response.data).show();
                $('#modal-input').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique');
        var getDate = $(this).data('date');
        askConfirmation("<?= lang('app.sure') ?>", "<?= lang('app.confirm delete') ?>").then((result) => {
            if (result.isConfirmed) {
                submitForm(getUnique, getDate);
            } else {
                return;
            }
        });
    });

    function submitForm(getUnique, getDate) {
        $.ajax({
            type: 'POST',
            url: '/calendar/delete',
            data: {
                unique: getUnique,
                date: getDate,
            },
            success: function(response) {
                window.location.href = response.redirect;
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    }
</script>

<?= $this->endSection() ?>
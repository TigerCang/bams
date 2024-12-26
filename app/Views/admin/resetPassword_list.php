<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <?php if (session()->getFlashdata('message')) :
                    echo json('alert success-1') . session()->getFlashdata('message') . json('alert success-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tableInit" class="table table-striped table-hover">
                    <thead>
                        <tr class="tr-color">
                            <th width="5">#</th>
                            <th width="150"><?= lang('app.username') ?></th>
                            <th><?= lang('app.code') ?></th>
                            <th><?= lang('app.name') ?></th>
                            <th width="200"><?= lang('app.company') ?></th>
                            <th width="200"><?= lang('app.division') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $index => $row) : ?>
                            <tr>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= $row->code ?></td>
                                <td><span><?= $row->code_employee ?></span>
                                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->eid ?></small>
                                </td>
                                <td><?= $row->name ?></td>
                                <td><?= $row->company ?></td>
                                <td><span><?= $row->division ?></span>
                                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->region ?></small>
                                </td>
                                <td><?php if (thisUser()['act_button'][1] == '1') : ?>
                                        <a href="javascript:void(0);" class="btn-input" data-unique="<?= $row->unique ?>"><?= json('btn i-refresh') ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div> <!--/ Card Datatable -->
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->

<script>
    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique');
        $.ajax({
            type: 'POST',
            url: '/resetpassword/reset',
            data: {
                unique: getUnique,
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
    });
</script>

<?= $this->endSection() ?>
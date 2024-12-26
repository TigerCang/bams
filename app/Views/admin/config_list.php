<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0">
                <?php if (session()->getFlashdata('message')) :
                    echo json('alert success-1') . session()->getFlashdata('message') . json('alert success-2');
                endif ?>
            </div> <!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tableInit" class="table table-striped table-hover">
                    <thead>
                        <tr class="tr-color">
                            <th width="5">#</th>
                            <th><?= lang('app.param') ?></th>
                            <th width="100" class="text-center"><?= lang('app.value') ?></th>
                            <th width="200"><?= lang('app.save by') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($config as $index => $row) : ?>
                            <tr>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= lang('app.' . $row['param']) ?></td>
                                <td class="text-center"><?= $row['value'] ?></td>
                                <td><?= ($row['user']) ?></td>
                                <td><?php if (thisUser()['act_button'][2] == '1') : ?>
                                        <a href="javascript:void(0);" class="btn-input" data-param="<?= $row['param'] ?>"><?= json('btn i-edit') ?></a>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div> <!--/ Card Datatable -->
        </div> <!--/ Card -->
    </div> <!--/ Col -->
</div> <!--/ Row -->
<div class="modal-input" style="display: none;"></div>

<script>
    $('.btn-input').click(function(e) {
        e.preventDefault();
        var getParam = $(this).data('param');
        $.ajax({
            url: "<?= $link ?>/input",
            data: {
                search: getParam,
            },
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
</script>

<?= $this->endSection() ?>
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
                <?php if (session()->getFlashdata('message')) :
                    echo json('alert success-1') . session()->getFlashdata('message') . json('alert success-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tableInit" class="table table-striped table-hover">
                    <thead>
                        <tr class="tr-color">
                            <th width="5">#</th>
                            <th width="150" <?= $kHid ?>><?= lang('app.param') ?></th>
                            <th width="200"><?= lang('app.group') ?></th>
                            <th><?= lang('app.description') ?></th>
                            <th width="200" <?= $pHid ?>><?= lang('app.company') ?></th>
                            <th width="100" <?= $nHid ?>><?= lang('app.value') ?></th>
                            <th width="100" class="text-center"><?= json('status') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupAccount as $index => $row) :
                            $label = labelBadge('main', ($row->adaptation)) ?>
                            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                                <td><?= $index + 1 ?>.</td>
                                <td <?= $kHid ?>><?= lang('app.' . $row->param) ?></td>
                                <td><?= lang('app.' . $row->sub_param) ?></td>
                                <td><?= $row->name ?></td>
                                <td <?= $pHid ?>><?= $row->company ?></td>
                                <td <?= $nHid ?>><?= $row->value ?></td>
                                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                                <td><?php if (thisUser()['act_button'][1] == '1') : ?>
                                        <a href="javascript:void(0);" class="btn-input" data-unique="<?= $row->unique ?>"><?= json('btn i-view') ?></a>
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
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })
</script>

<?= $this->endSection() ?>
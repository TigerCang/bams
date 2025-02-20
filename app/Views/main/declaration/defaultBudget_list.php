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
                            <th width="100"><?= lang('app.source') ?></th>
                            <th width="200"><?= lang('app.object') ?></th>
                            <th><?= lang('app.title') ?></th>
                            <th class="text-end" width="150"><?= lang('app.total') ?></th>
                            <th width="100" class="text-center"><?= json('status') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($budget as $index => $row) :
                            $label = labelBadge('main', ($row->adaptation)) ?>
                            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= lang('app.' . $row->source) ?></td>
                                <td><?= lang('app.' . $row->object) ?></td>
                                <td><?= $row->title ?></td>
                                <td class="text-end"><?= formatComa($row->allTotal) ?></td>
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

<script>
    // function getUniqueFromServer(callback) {
    //     $.ajax({
    //         url: '/getUnique',
    //         method: 'GET',
    //         dataType: 'json',
    //         success: function(response) {
    //             if (response.unique) callback(response.unique);
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             alert(xhr.status + "\n" + xhr.responseText);
    //             alert(thrownError);
    //         }
    //     });
    // }

    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique') || '';
        // if (getUnique === '') {
        // getUniqueFromServer(function(unique) {
        //         var url = '<= $link ?>/input?search=' + unique;
        //         window.location.href = url;
        //     });
        // } else {
        var url = '<?= $link ?>/input?search=' + getUnique;
        window.location.href = url;
        // }
    })
</script>

<?= $this->endSection() ?>
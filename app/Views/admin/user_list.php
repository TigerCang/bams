<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header">
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
                            <th><?= lang('app.person') ?></th>
                            <th><?= lang('app.role') ?></th>
                            <th width="100" class="text-center"><?= lang('app.approve') ?></th>
                            <th width="100" class="text-center"><?= json('status') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $index => $row) :
                            $label = labelBadge('main', ($row->adaptation)) ?>
                            <tr <?= ($row->xLog == '' ? 'class="fw-bold"' : '') ?>>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= $row->code ?></td>
                                <td><?= $row->person ?></td>
                                <td><?= $row->role ?></td>
                                <td class="text-center"><?= $row->act_approve ?></td>
                                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                                <td><?php if (thisUser()['act_button'][1] == '1') : ?>
                                        <a href="javascript:void(0);" class="btn-input" data-unique="<?= $row->unique ?>"><?= json('btn i-edit') ?></a>
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
    $(document).on('click', '.btn-input', function(e) {
        e.preventDefault();
        var getUnique = $(this).data('unique') || '';
        var url = '<?= $link ?>/input?search=' + getUnique;
        window.location.href = url;
    })
</script>

<?= $this->endSection() ?>
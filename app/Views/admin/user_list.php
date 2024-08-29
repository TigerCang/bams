<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">

    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header">
                <?php if (session()->getFlashdata('pesan')) :
                    echo json('alert sukses-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tabelAwal" class="table table-striped table-hover nowrap">
                    <thead>
                        <tr class="bghead">
                            <th width="5">#</th>
                            <th><?= lang('app.usernama') ?></th>
                            <th><?= lang('app.peminta') ?></th>
                            <th><?= lang('app.role') ?></th>
                            <th class="text-center"><?= lang('app.setuju') ?></th>
                            <th class="text-center"><?= json('status') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($user as $index => $row) :
                            $label = labelBadge('main', ($row->kondisi)) ?>
                            <tr <?= ($row->xlog == '' ? 'class="fontbold"' : '') ?>>
                                <td><?= $index + 1 ?>.</td>
                                <td><?= $row->kode ?></td>
                                <td><?= $row->peminta ?></td>
                                <td><?= $row->role ?></td>
                                <td class="text-center"><?= $row->act_setuju ?></td>
                                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                                <td><?php if ($tuser['act_button'][1] == '1') : ?>
                                        <a href="javascript:void(0);" class="btninput" data-idunik="<?= $row->idunik ?>"><?= json('btn iubah') ?></a>
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
    $(document).on('click', '.btninput', function(e) {
        e.preventDefault();
        var getIdu = $(this).data('idunik') || '';
        var url = '<?= $link ?>/input?datakey=' + getIdu;
        window.location.href = url;
    })
</script>

<?= $this->endSection() ?>
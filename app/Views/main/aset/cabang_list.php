<?= $this->extend($tampilan == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-12">

        <div class="card mb-6">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center row <?= (session()->getFlashdata('pesan') ? 'py-3' : 'py-0') ?> gap-3 gap-md-0">
                    <div>
                        <button type="button" class="<?= json('btn create') ?> btninput" <?= ($tuser['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn create') ?></button>
                    </div>
                </div>
                <?php if (session()->getFlashdata('pesan')) :
                    echo json('alert sukses-1') . session()->getFlashdata('pesan') . json('alert sukses-2');
                endif ?>
            </div><!--/ Card Header -->

            <div class="card-datatable table-responsive">
                <table id="tabelAwal" class="table table-striped table-hover nowrap">
                    <thead>
                        <tr class="bghead">
                            <th width="5" hidden>#</th>
                            <th><?= lang('app.kode') ?></th>
                            <th><?= lang('app.deskripsi') ?></th>
                            <th><?= lang('app.perusahaan') ?></th>
                            <th><?= lang('app.divisi') ?></th>
                            <th class="text-center"><?= json('status') ?></th>
                            <th width="5" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cabang as $index => $row) :
                            $label = labelBadge('main', ($row->kondisi)) ?>
                            <tr <?= ($row->xlog == '' ? 'class="fontbold"' : '') ?>>
                                <td hidden><?= $index + 1 ?>.</td>
                                <td><?= $row->kode ?></td>
                                <td><?= $row->nama ?></td>
                                <td><?= $row->perusahaan ?></td>
                                <td><span><?= $row->divisi ?></span>
                                    <small class="text-truncate mb-0 d-none d-sm-block"><?= $row->wilayah ?></small>
                                </td>
                                <td class="text-center"><label class="label <?= $label['class'] ?>"><?= $label['text'] ?></label></td>
                                <td><?php if ($tuser['act_button'][1] == '1') : ?>
                                        <a href="javascript:void(0);" class="btninput" data-idunik="<?= $row->idunik ?>"><?= json('btn iview') ?></a>
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
    $(document).ready(function() {
        $(document).on('click', '.btninput', function(e) {
            e.preventDefault();
            var getIdu = $(this).data('idunik') || '';
            var url = '<?= $link ?>/input?datakey=' + getIdu;
            window.location.href = url;
        })
    });
</script>

<?= $this->endSection() ?>
<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page-body start -->
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">

            <div class="card">
                <div class="card-header <?= lang('app.bgList'); ?>">
                    <h5><?= lang('app.daftardata'); ?></h5>
                    <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                            <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                        </ul>
                    </div>
                </div>

                <div class="card-block mt-2">
                    <div class="mb-2">
                        <a href="/atributgaji/input" class="btn <?= lang('app.btnCreate'); ?> <?= (session()->user['act_create'] == '0') ? 'disabled' : '' ?>"><?= lang('app.btn_createnew'); ?></a>
                        <?php if (session()->getFlashdata('pesan')) : ?>
                            <div onload="flashdata('<?= session()->getFlashdata('pesan') ?>','success','<?= session()->getFlashdata('judul') ?>')"></div>
                        <?php endif; ?>
                    </div>

                    <div class="dt-responsive table-responsive">
                        <table id="example" class="table table-striped table-hover">
                            <thead>
                                <tr class="bghead">
                                    <th scope="col" width="10">#</th>
                                    <th scope="col" width="10"><?= lang('app.konstanta'); ?></th>
                                    <th scope="col"><?= lang('app.satuan'); ?></th>
                                    <th scope="col" width="10"></th>
                                    <th scope=" col"><?= lang('app.nama'); ?></th>
                                    <th scope="col" width="10" class="text-center"><?= lang('app.pemisah'); ?></th>
                                    <th scope="col" width="10"><?= lang('app.status'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $nomor = 1; ?>
                                <?php foreach ($atribut as $row) : ?>
                                    <tr>
                                        <td><?= $nomor++; ?>.</td>
                                        <td><a href="/atributgaji/detail/<?= $row->id_unik; ?>"><?= $row->nilaikonstanta; ?></a></td>
                                        <td><a href="/atributgaji/detail/<?= $row->id_unik; ?>"><?= $row->satuan; ?></a></td>
                                        <td class="text-center"><a href="/atributgaji/detail/<?= $row->id_unik; ?>">X</a></td>
                                        <td><a href="/atributgaji/detail/<?= $row->id_unik; ?>"><?= $row->nama; ?></a></td>
                                        <td class="text-center"><a href="/atributgaji/detail/<?= $row->id_unik; ?>"><?= $row->separator; ?></a></td>

                                        <?php if ($row->is_aktif == '0') {
                                            echo "<td><label class='label label-danger'>" . lang('app.noaktif') . "</label></td>";
                                        } elseif ($row->is_confirm == '1') {
                                            echo "<td><label class='label label-success'>" . lang('app.pasti') . "</label></td>";
                                        } else {
                                            echo "<td><label class='label label-warning'>" . lang('app.tunda') . "</label></td>";
                                        } ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- Akhir card-->

        </div>
    </div>
</div><!-- body end -->

<?= $this->endSection(); ?>
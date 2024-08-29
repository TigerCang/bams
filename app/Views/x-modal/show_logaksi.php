<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMselect') ?>">
                <h4 class="modal-title"><?= lang('app.titlelogaksi'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-block mt-2 mb-2">
                <div class="dt-responsive table-responsive">
                    <table id="tabelmodal" class="table table-striped table-hover nowrap">
                        <thead>
                            <?= "
                            <tr class='bghead'>
                                <th scope='col' width='10'>#</th>
                                <th scope='col'>" . lang('app.usernama') . "</th>
                                <th scope='col'>" . lang('app.nama') . "</th>
                                <th scope='col'>" . lang('app.divisi') . "</th>
                                <th scope='col' width='10' class='text-center'>" . lang('app.level') . "</th>
                                <th scope='col'>" . lang('app.aksi') . "</th>
                                <th scope='col'>" . lang('app.catatan') . "</th>
                                <th scope='col' width='10'>" . lang('app.waktu') . "</th>
                            </tr>"; ?>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            foreach ($log as $row) :
                                echo "<tr class='" . ($row->st_seru == 'on' ? 'bgtr2' : '') . "'>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                // echo "<td style='" . ($row->lama == '1' ? 'text-decoration:line-through' : '') . "'>$row->usernama</td>";
                                echo "<td>$row->usernama</td>";
                                echo "<td>$row->pegawai</td>";
                                echo "<td>$row->divisipegawai</td>";
                                echo "<td class='text-center'>$row->level</td>";
                                echo "<td>" . lang('app.' . $row->aksi) . "</td>";
                                echo "<td>$row->catatan</td>";
                                echo "<td>" . formattanggal($row->created_at, '2') . "</td>";
                                echo "</tr>";
                            endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/modal.js"></script>
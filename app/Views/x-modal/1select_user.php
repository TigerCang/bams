<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMselect') ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihuser') ?></h4>
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
                            <th scope='col'>" . lang('app.username') . "</th>
                            <th scope='col'>" . lang('app.nama') . "</th>
                            <th scope='col'>" . lang('app.role') . "</th>
                            <th scope='col' class='text-center' width='10'>" . lang('app.level') . "</th>
                            <th scope='col' class='text-right'>" . lang('app.batas') . "</th>
                            <th scope='col' width='10' data-orderable='false'></th>
                            </tr>"; ?>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            foreach ($user as $row) :
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td>$row->kode</td>";
                                echo "<td>$row->pegawai</td>";
                                echo "<td>$row->role</td>";
                                echo "<td class='text-center'>$row->acc_setuju</td>";
                                echo "<td class='text-right'>" . formatkoma($row->batasacc) . "</td>";
                                echo "<td class='text-center'><button type='button' id='selectuser' class='btn " . lang('app.btnPilih2') . "' data-toggle='tooltip' title='" . lang('app.pilih') . "' data-kode='{$row->kode}' data-level='{$row->acc_setuju}'>" . lang('app.btn_Pilih2') . "</button></td>";
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
<script>
    $(document).ready(function() {
        $(document).on('click', '#selectuser', function() {
            var kode = $(this).data('kode');
            var level = $(this).data('level');
            $('#userid').val(kode);
            $('#xlevel').val(level);
            $('#modal-lampiran').modal('hide');
        })
    });
</script>
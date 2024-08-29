<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMselect'); ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihsuplier'); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-block mb-2 mt-2">
                <div class="dt-responsive table-responsive">
                    <table id="tabselect" class="table table-striped table-hover table-bordered nowrap">
                        <thead>
                            <tr class="bghead">
                                <th scope="col" width="10">#</th>
                                <th scope="col"><?= lang('app.suplier'); ?></th>
                                <th scope="col" class="text-right"><?= lang('app.jlbeli'); ?></th>
                                <th scope="col" class="text-right"><?= lang('app.harga'); ?></th>
                                <th scope="col" class="text-right"><?= lang('app.diskon'); ?></th>
                                <th scope="col" class="text-right"><?= lang('app.total'); ?></th>
                                <th scope="col" class="text-center"><?= lang('app.ppn'); ?></th>
                                <th scope="col"><?= lang('app.catatan'); ?></th>
                                <th scope="col" width="10"><?= lang('app.aksi'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            foreach ($po as $row) :
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td>$row->namasuplier</td>";
                                echo "<td class='text-right'>" . formatrp($row->jlbeli) . "</td>";
                                echo "<td class='text-right'>" . formatrp($row->harga) . "</td>";
                                echo "<td class='text-right'>" . formatrp($row->diskon) . "</td>";
                                echo "<td class='text-right'>" . formatrp($row->total) . "</td>";
                                echo "<td class='text-center'>" . (($row->st_pajak == '1') ? '<i class="fa fa-check"></i>' : '') . "</td>";
                                echo "<td>$row->catatan</td>";
                                echo "<td class='text-center'><button class='btn " . lang('app.btnDel2') . "' data-toggle='tooltip' title='" . lang('app.hapus') . "' onclick=\" hapusdata('" . $row->id . "','" . $row->penerima_id . "')\">" . lang('app.btn_Del2') . "</button>" . '&nbsp';
                                echo "<button id='pilihsuplier' class='btn " . lang('app.btnPilih2') . "' data-toggle='tooltip' title='" . lang('app.pilih') . "' data-anak='" . $row->poanak_id . "' data-harga='" . formatrp($row->harga) . "' data-diskon='" . formatrp($row->diskon) . "' data-total='" . formatrp($row->total) . "' data-suplier='" . $row->penerima_id . "' data-pajak='" . $row->st_pajak . "'>" . (($row->penerima_id == $row->penerima) ? lang('app.btn_Pilih3') : lang('app.btn_Pilih2')) . "</button>";
                                echo "</td></tr>";
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function hapusdata(id, suplier) {
        var url = '/bandingharga/deltawar';
        $('#modal-lampiran').modal('hide');
        Swal.fire({
            title: '<?= lang('app.tanyadel2'); ?>',
            text: "<?= lang('app.infodel'); ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('app.confirmdel'); ?>',
            cancelButtonText: '<?= lang('app.batal'); ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        id: id,
                        suplier: suplier,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            flashdata(response.sukses, 'success', response.judul);
                            datamintabarang();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText);
                        alert(thrownError);
                    }
                });
            }
        })
    }

    $(document).ready(function() {
        $('#tabselect').DataTable({
            "ordering": true,
            "searching": true,
            "autoWidth": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All'],
            ],
            "iDisplayLength": 25,
        });

        $(document).on('click', '#pilihsuplier', function() {
            var url = '/bandingharga/pilihtawar';
            $.ajax({
                type: 'post',
                url: url,
                data: {
                    poanak: $(this).data('anak'),
                    harga: $(this).data('harga'),
                    diskon: $(this).data('diskon'),
                    total: $(this).data('total'),
                    suplier: $(this).data('suplier'),
                    pajak: $(this).data('pajak'),
                },
                dataType: "json",
                success: function(response) {
                    $('#modal-lampiran').modal('hide');
                    datamintabarang();
                    return false;
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText);
                    alert(thrownError);
                }
            });
        })
    });
</script>
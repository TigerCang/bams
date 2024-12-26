<table id="berkas" class="table table-striped table-bordered table-hover">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.suplier'); ?></th>
            <th scope="col"><?= lang('app.deskripsi'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.harga'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.diskon'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.total'); ?></th>
            <th scope="col" width="10"><?= lang('app.ppn'); ?></th>
            <th scope="col"><?= lang('app.catatan'); ?></th>
            <th scope="col" width="10"><?= lang('app.aksi'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1; ?>
        <?php foreach ($bandingharga as $row) : ?>
            <tr>
                <td><?= $nomor++; ?>.</td>
                <td><?= $row->suplier; ?></td>
                <td><?= $row->namasuplier; ?></td>
                <td align="right"><?= formatrp($row->harga); ?></td>
                <td align="right"><?= formatrp($row->diskon); ?></td>
                <td align="right"><?= formatrp($row->total); ?></td>
                <?php if ($row->incpajak == '1') {
                    echo "<td align='center'> &#10004; </td>";
                } else {
                    echo "<td></td>";
                } ?>
                <td><?= $row->keterangan; ?></td>
                <td> <?php if ($row->pilih == "0") { ?>
                        <button type="button" class="btn <?= lang('app.btnHapus'); ?>" onclick="hapus('<?= $row->id ?>','<?= $row->suplier ?>')"><?= lang('app.btn_Hapus'); ?></button>
                    <?php } else { ?>
                        <button type="button" class="btn <?= lang('app.btnPilih'); ?>"><?= lang('app.btn_pilih'); ?></button>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#berkas').DataTable({
            "searching": true,
            "ordering": true,
            "autoWidth": false,
            // "columnDefs": [{
            //     "targets": [1],
            //     "visible": false,
            // }]

        });
    });

    function hapus(id, suplier) {
        var url = '/bandingharga/deltawar';

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
                        if (response.sukses) { //dari msg save lampiran
                            flashdata(response.sukses, 'success', response.judul);
                            datatawarbarang();
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
</script>
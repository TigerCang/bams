<table id="berkas3" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.biaya'); ?></th>
            <th scope="col"><?= lang('app.deskripsi'); ?></th>
            <th scope="col"><?= lang('app.spesifikasi'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.jumlah'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.total'); ?></th>
            <th scope="col"><?= lang('app.catatan'); ?></th>
            <th scope="col" class="text-center" width="10"><?= lang('app.aksi'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($biaya as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>$row->namabiaya</td>";
            echo "<td>$row->namabarang</td>";
            echo "<td>$row->spesifikasi</td>";
            echo "<td class='text-right'>" . formatrp($row->jumlah) . "</td>";
            echo "<td class='text-right'>" . formatrp($row->biaya) . "</td>";
            echo "<td>$row->catatan</td>";
            echo "<td class='text-center'><button class='btn " . lang('app.btnDel2') . " hapusdata' data-id='" . $row->id . "' data-toggle='tooltip' title='" . lang('app.hapus') . "'>" . lang('app.btn_Del2') . "</button></td>";
            echo "</tr>";
        endforeach;
        ?>
    </tbody>
</table>

<script>
    function hapus(id, barang) {
        var url = '/mintabarang/delbarang';
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
                        barang: barang,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) { //dari msg save lampiran
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
</script>
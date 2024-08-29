<table id="berkas3" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.tanggal'); ?></th>
            <th scope="col" width="10"><?= lang('app.jasa'); ?></th>
            <th scope="col"><?= lang('app.deskripsi'); ?></th>
            <th scope="col"><?= lang('app.spesifikasi'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.jumlah'); ?></th>
            <th scope="col" class="text-center"><?= lang('app.satuan'); ?></th>
            <th scope="col"><?= lang('app.tiket'); ?></th>
            <th scope="col"><?= lang('app.nopol'); ?></th>
            <th scope="col"><?= lang('app.supir'); ?></th>
            <th scope="col" class="text-center" width="10"><?= lang('app.aksi'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($barang as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . $row->tanggal . "</td>";
            echo "<td class='text-center'>" . (($row->jenis == '0') ? '<i class="fa fa-check"></i>' : '') . "</td>";
            echo "<td>" . (($row->jenis == '1') ? $row->namabarang : $row->namaakun) . "</td>";
            echo "<td>$row->spesifikasi</td>";
            echo "<td class='text-right'>" . formatrp($row->jl_hasil) . "</td>";
            echo "<td class='text-center'>" . (($row->jenis == '1') ? $row->satuan : '') . "</td>";
            echo "<td>$row->tiket</td>";
            echo "<td>$row->nopol</td>";
            echo "<td>$row->supir</td>";
            echo "<td class='text-center'><button class='btn " . lang('app.btnInfo2') . " infodata' data-id='" . $row->id . "' data-toggle='tooltip' title='" . lang('app.info') . "'>" . lang('app.btn_Info2') . "</button></td>";
            echo "</tr>";
        endforeach; ?>
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
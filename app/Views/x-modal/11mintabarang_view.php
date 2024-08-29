<table id="berkas" class="table table-striped table-bordered table-hover">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.kode'); ?></th>
            <th scope="col"><?= lang('app.nama'); ?></th>
            <th scope="col"><?= lang('app.spesifikasi'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.jumlah'); ?></th>
            <th scope="col"><?= lang('app.catatan'); ?></th>
            <?php if ($button == "1") {
                echo "<th scope='col' width='10'>" . lang('app.aksi') . "</th>";
            } ?>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1; ?>
        <?php foreach ($minta as $row) : ?>
            <tr>
                <td><?= $nomor++; ?>.</td>
                <td><?= $row->kode; ?></td>
                <td><?= $row->namaitem; ?></td>
                <td><?= $row->spesifikasi; ?></td>
                <td align="right"><?= formatrp($row->jumlah); ?> <?= $row->satuan; ?></td>
                <td><?= $row->keterangan; ?></td>
                <?php if ($button == "1") {
                    echo "<td><button type='button' class='btn " . lang('app.btnHapus') . "' onclick=\"hapus('" . $row->id . "','" . $row->kode . "')\">" . lang('app.btn_Hapus') . "</button></td>";
                } ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function hapus(id, nama) {
        var url = '/mintabarang/delminta';

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
                        nama: nama,
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
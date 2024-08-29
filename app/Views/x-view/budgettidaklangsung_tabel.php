<table id="berkas" class="table table-striped table-hover">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.item'); ?></th>
            <th scope="col"><?= lang('app.deskripsi'); ?></th>
            <th scope="col" class="text-center" width="10"><?= ucfirst(lang('app.bulan')); ?></th>
            <th scope="col" class="text-right"><?= lang('app.jumlah'); ?></th>
            <th scope="col" class="text-center"><?= lang('app.satuan'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.harga'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.total'); ?></th>
            <th scope="col"><?= lang('app.catatan'); ?></th>
            <th scope="col" class="text-center" width="10"><?= lang('app.aksi'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($budget as $row) :
            echo "<tr>";
            ($row->level == "4") ? $spasi = "&emsp;&emsp;&emsp;" : (($row->level == "3") ? $spasi = "&emsp;&emsp;" : (($row->level == "2") ? $spasi = "&emsp;" : $spasi = ""));
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . $spasi . $row->biaya . "</td>";
            echo "<td>$row->namabiaya</td>";
            echo "<td class='text-center'>" . (($row->bulan == '0') ? '' : formatrp($row->bulan)) . "</td>";
            echo "<td class='text-right'>" . (($row->jumlah == '0') ? '' : formatrp($row->jumlah)) . "</td>";
            echo "<td class='text-center'>$row->satuan</td>";
            echo "<td class='text-right'>" . (($row->harga_kerja == '0') ? '' : formatrp($row->harga_kerja)) . "</td>";
            echo "<td class='text-right'>" . formatrp($row->total_kerja) . "</td>";
            echo "<td>$row->catatan</td>";
            echo "<td><button class='btn " . lang('app.btnEdit3') . "'>" . lang('app.btn_Edit3') . "</button>" . '&nbsp';
            echo "<button class='btn " . lang('app.btnDel3') . "' onclick=\"hapus('" . $row->id . "')\">" . lang('app.btn_Del3') . "</button></td>";
            echo "</tr>";
        endforeach; ?>
    </tbody>
</table>

<script>
    function hapus(id) {
        var url = '/kaslangsung/delkas';
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
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) {
                            flashdata(response.sukses, 'success', response.judul);
                            datamintakas();
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
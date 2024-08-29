<?php preg_match("/$nstat/i", '013') ? $hid = '' : $hid = 'hidden';
($ed == '1') ? $ehid = '' : $ehid = 'hidden'; ?>

<table id="berkas" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.noakun'); ?></th>
            <th scope="col"><?= lang('app.deskripsi'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.total'); ?></th>
            <th scope="col"><?= lang('app.catatan'); ?></th>
            <th scope="col" class="text-center" <?= $hid; ?> <?= $ehid; ?> width="10"><?= lang('app.aksi'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        $debit = 0;
        foreach ($biaya as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>$row->noakun</td>";
            echo "<td>$row->namaakun</td>";
            echo "<td class='text-right'>" . formatrp($row->debit) . "</td>";
            echo "<td>$row->catatan</td>";
            echo "<td class='text-center' $ehid $hid><button class='btn " . lang('app.btnDel2') . "' data-toggle='tooltip' title='" . lang('app.hapus') . "' onclick=\" hapus('" . $row->id . "','" . $row->noakun . "')\">" . lang('app.btn_Del2') . "</button></td>";
            $debit = $debit + $row->debit;
            echo "</tr>";
        endforeach;
        echo "<tr class='bgtr'>";
        echo "<td colspan='6'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td colspan='2'>" . lang('app.total') . "</td>";
        echo "<td class='text-right'>" . formatrp($debit) . "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>"; ?>
    </tbody>
</table>

<script>
    function hapus(id, noakun) {
        var url = '/<?= $menu; ?>/dellampir';
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
                        akun: noakun,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) { //dari msg save lampiran
                            flashdata(response.sukses, 'success', response.judul);
                            datalampiran();
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
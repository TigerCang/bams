<?php (empty($kas)) ? $stat = '0' : $stat = $kas['0']->status;
preg_match("/$stat/i", '013') ? $hidden = '' : $hidden = 'hidden'; ?>

<table id="berkas" class="table table-striped table-hover">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.ruas'); ?></th>
            <th scope="col"><?= lang('app.item'); ?></th>
            <th scope="col"><?= lang('app.sumberdaya'); ?></th>
            <th scope="col"><?= lang('app.akun'); ?></th>
            <th scope="col"><?= lang('app.kbli'); ?></th>
            <th scope="col"><?= lang('app.deskripsi'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.jumlah'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.harga'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.debit'); ?></th>
            <th scope="col" class="text-right"><?= lang('app.kredit'); ?></th>
            <th scope="col"><?= lang('app.catatan'); ?></th>
            <th scope="col" class="text-center" width="10"><?= lang('app.aksi'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        $debit = 0;
        $kredit = 0;
        foreach ($kas as $row) :
            echo "<tr>"; ?>
            <td><?= $nomor++; ?>.</td>
            <td><?= $row->ruas; ?></td>
            <td><?= $row->biaya; ?></td>
            <td><?= $row->sumberdaya; ?></td>
            <td><?= $row->noakun; ?></td>
            <td><?= $row->kbli; ?></td>
            <td><?= $row->namaakun; ?></td>
            <td class="text-right"><?= formatrp($row->jumlah); ?></td>
            <td class="text-right"><?= formatrp($row->harga); ?></td>
            <td class="text-right"><?= formatrp($row->debit); ?></td>
            <td class="text-right"><?= formatrp($row->kredit); ?></td>
            <td><?= $row->catatan; ?></td>
        <?php
            $debit = $debit + $row->debit;
            $kredit = $kredit + $row->kredit;

            echo "<td><button class='btn " . lang('app.btnEdit3') . "'>" . lang('app.btn_Edit3') . "</button>" . '&nbsp';
            echo "<button class='btn " . lang('app.btnDel3') . "' onclick=\"hapus('" . $row->id . "')\">" . lang('app.btn_Del3') . "</button></td>";
            echo "</tr>";
        endforeach; ?>
        <tr class="bgtr">
            <td colspan="13"></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="8"><?= lang('app.total'); ?></td>
            <td class="text-right"><?= formatrp($debit); ?></td>
            <td class="text-right"><?= formatrp($kredit); ?></td>
            <td colspan="2"></td>
        </tr>
    </tbody>
</table>

<script>
    function hapus(id) {
        var url = '/kasnonlangsung/delkas';

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
                        if (response.sukses) { //dari msg save lampiran
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
<?php
$chid = ((substr($cja, 0, 1) == '1') ? '' : 'hidden');
$phid = ((substr($cja, 1, 1) == '1') ? '' : 'hidden');
$ahid = ((substr($cja, 2, 1) == '1') ? '' : 'hidden'); ?>

<table id="tabellampiran" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <?php
        echo "<tr class='bghead'>";
        echo "<th scope='col' width='10'>#</th>";
        echo "<th scope='col' $phid>" . lang('app.jasa') . "</th>";
        echo "<th scope='col' $chid>" . lang('app.item') . "</th>";
        echo "<th scope='col' $chid>" . lang('app.deskripsi') . "</th>";
        echo "<th scope='col' class='text-right'>" . lang('app.jumlah') . "</th>";
        echo "<th scope='col' class='text-center'>" . lang('app.satuan') . "</th>";
        echo "<th scope='col' class='text-right'>" . lang('app.harga') . "</th>";
        echo "<th scope='col' class='text-right'>" . lang('app.diskon') . "</th>";
        echo "<th scope='col' class='text-right'>" . lang('app.total') . "</th>";
        echo "<th scope='col'>" . lang('app.catatan') . "</th>";
        echo "<th scope='col' class='text-center' width='10' $ahid>" . lang('app.aksi') . "</th>";
        echo "</tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        $total = 0;
        foreach ($sales as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td $phid>$row->namajasa</td>";
            echo "<td $chid>$row->kodebarang</td>";
            echo "<td $chid>$row->namabarang</td>";
            echo "<td class='text-right'>" . formatkoma($row->jumlah, '4') . "</td>";
            echo "<td class='text-center'>$row->satuan</td>";
            echo "<td class='text-right'>" . formatkoma($row->harga) . "</td>";
            echo "<td class='text-right'>" . formatkoma($row->diskon) . "</td>";
            echo "<td class='text-right'>" . formatkoma($row->total) . "</td>";
            $total += $row->total;
            echo "<td>$row->catatan</td>";
            echo "<td $ahid><button class='btn " . lang('app.btnEdit2') . " ubahdata' data-id='" . $row->id . "' data-toggle='tooltip' title='" . lang('app.ubah') . "'>" . lang('app.btn_Edit2') . "</button>" . '&nbsp';
            echo "<button class='btn " . lang('app.btnDel2') . "' data-toggle='tooltip' title='" . lang('app.hapus') . "' onclick=\" hapus('" . $row->id . "','" . $row->namajasa . "')\">" . lang('app.btn_Del2') . "</button></td>";
            echo "</tr>";
        endforeach;
        echo "<tr><td colspan='12'></td></tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td colspan='2' $chid>" . lang('app.total') . "</td>";
        echo "<td colspan='3' $phid>" . lang('app.total') . "</td>";
        echo "<td colspan='3'></td>";
        echo "<td class='text-right'>" . formatkoma($total) . "</td>";
        echo "<td></td>";
        echo "<td $ahid></td>";
        echo "</tr>"; ?>
    </tbody>
</table>

<script>

</script>
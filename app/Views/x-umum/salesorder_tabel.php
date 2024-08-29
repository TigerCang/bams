<?php
$chid = (substr($cepsa, 0, 1) == '1' ? '' : 'hidden');
$ehid = (substr($cepsa, 1, 1) == '1' ? '' : 'hidden');
$phid = (substr($cepsa, 2, 1) == '1' ? '' : 'hidden');
$shid = (substr($cepsa, 3, 1) == '1' ? '' : 'hidden');
$ahid = (substr($cepsa, 4, 1) == '1' ? '' : 'hidden'); ?>

<table id="tabelload" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <?php
        echo "<tr class='bghead'>";
        echo "<th scope='col' width='10'>#</th>";
        echo "<th scope='col' width='100'>" . lang('app.tanggal') . "</th>";
        echo "<th scope='col'>" . lang('app.nodoc') . "</th>";
        echo "<th scope='col'>" . lang('app.divisi') . "</th>";
        echo "<th scope='col' $chid>" . lang('app.camp') . "</th>";
        echo "<th scope='col' $ehid>" . lang('app.penerima') . "</th>";
        echo "<th scope='col' $phid>" . lang('app.proyek') . "</th>";
        echo "<th scope='col' $shid width='10'>" . lang('app.status') . "</th>";
        echo "<th scope='col' $ahid width='10'>" . lang('app.aksi') . "</th>";
        echo "</tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($sales as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . formattanggal($row->tanggal) . "</td>";
            echo "<td>$row->nodoc</td>";
            echo "<td>$row->divisi</td>";
            echo "<td $chid>$row->camp</td>";
            echo "<td $ehid>$row->penerima</td>";
            echo "<td $phid>$row->proyek</td>";

            $status_labels = [
                '0' => ['class' => 'label-inverse', 'text' => lang('app.baru')],
                '1' => ['class' => 'label-inverse', 'text' => lang('app.blmacc')],
                '2' => ['class' => 'label-primary', 'text' => lang('app.proses')],
                '3' => ['class' => 'label-warning', 'text' => lang('app.revisi')],
                '4' => ['class' => 'label-danger', 'text' => lang('app.tolak')],
                '5' => ['class' => 'label-danger', 'text' => lang('app.batal')],
                '6' => ['class' => 'label-success', 'text' => lang('app.siapbayar')],
                '7' => ['class' => 'label-success', 'text' => lang('app.dibayar')]
            ];
            $status = $status_labels[$row->st_jual] ?? ['class' => '', 'text' => ''];
            echo "<td $shid class='text-center'><label class='label " . $status['class'] . "'>" . $status['text'] . "</label></td>";
            echo "<td $ahid class='text-center'><a href='/$menu/input/$row->idunik' class='btn " . lang('app.btnDetil2') . "' data-toggle='tooltip' title='" . lang('app.detil') . "'>" . lang('app.btn_Detil2') . "</a></td>";
            echo "</tr>";
        endforeach ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/loadview.js"></script>
<table id="tabelload" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <?php
        echo "<tr class='bghead'>";
        echo "<th scope='col' width='10' rowspan='2' class='align-middle'>#</th>";
        echo "<th scope='col' width='100' rowspan='2' class='align-middle'>" . lang('app.tanggal') . "</th>";
        echo "<th scope='col' rowspan='2' class='align-middle'>" . lang('app.nodoc') . "</th>";
        echo "<th scope='col' rowspan='2' class='align-middle'>" . lang('app.pegawai') . "</th>";
        echo "<th scope='col' rowspan='2' class='align-middle'>" . lang('app.perusahaan') . "</th>";
        echo "<th scope='col' rowspan='2' class='align-middle'>" . lang('app.divisi') . "</th>";
        echo "<th scope='col' rowspan='2' class='align-middle'>" . lang('app.tglcuti') . "</th>";
        echo "<th scope='col' rowspan='2' class='align-middle'>" . lang('app.hari') . "</th>";
        echo "<th scope='col' colspan='4' class='text-center' width='10'>" . lang('app.status') . "</th>";
        echo "<th scope='col' width='10' rowspan='2' class='align-middle'>" . lang('app.aksi') . "</th>";
        echo "</tr>";
        echo "<tr class='bghead'>";
        echo "<th scope='col' width='10' class='text-center'>" . lang('app.atasan') . "</th>";
        echo "<th scope='col' width='10' class='text-center'>" . lang('app.hrd') . "</th>";
        echo "<th scope='col' width='10' class='text-center'>" . lang('app.bos') . "</th>";
        echo "<th scope='col' width='10'>" . lang('app.status') . "</th>";
        echo "</tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($cuti as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . formattanggal($row->tgl_minta) . "</td>";
            echo "<td>$row->nodoc</td>";
            echo "<td>$row->pegawai</td>";
            echo "<td>$row->perusahaan</td>";
            echo "<td>$row->divisi</td>";
            echo "<td>" . formattanggal($row->tgl_cuti1, '3') . " - " . formattanggal($row->tgl_cuti2, '3') . "</td>";
            echo "<td class='text-center'>$row->lama</td>";
            echo "<td class='text-center'>" . (($row->st_atasan != '') ? "<i class='fa fa-check-square-o'></i>" : "") . "</td>";
            echo "<td class='text-center'>" . (($row->st_hrd != '') ? "<i class='fa fa-check-square-o'></i>" : "") . "</td>";
            echo "<td class='text-center'>" . (($row->st_bos != '') ? "<i class='fa fa-check-square-o'></i>" : "") . "</td>";
            $status_labels = [
                '0' => ['class' => 'label-primary', 'text' => lang('app.proses')],
                '1' => ['class' => 'label-warning', 'text' => lang('app.revisi')],
                '2' => ['class' => 'label-danger', 'text' => lang('app.tolak')],
                '3' => ['class' => 'label-success', 'text' => lang('app.ok')]
            ];
            $status = $status_labels[$row->status] ?? ['class' => '', 'text' => ''];
            echo "<td class='text-center'><label class='label " . $status['class'] . "'>" . $status['text'] . "</label></td>";
            echo "<td class='text-center'><a href='/$menu/input/$row->idunik' class='btn " . lang('app.btnDetil2') . "' data-toggle='tooltip' title='" . lang('app.detil') . "'>" . lang('app.btn_Detil2') . "</a></td>";
            echo "</tr>";
        endforeach ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/loadview.js"></script>
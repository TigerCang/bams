<table id="tabelload" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <?php
        echo "<tr class='bghead'>";
        echo "<th scope='col' width='10'>#</th>";
        echo "<th scope='col'>" . lang('app.kode') . "</th>";
        echo "<th scope='col'>" . lang('app.nip') . "</th>";
        echo "<th scope='col'>" . lang('app.pegawai') . "</th>";
        echo "<th scope='col'>" . lang('app.perusahaan') . "</th>";
        echo "<th scope='col'>" . lang('app.divisi') . "</th>";
        echo "<th scope='col' class='text-center' width='10'>" . lang('app.rating') . "</th>";
        echo "<th scope='col' width='10'>" . lang('app.aksi') . "</th>";
        echo "</tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($nilai as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>$row->kode</td>";
            echo "<td>$row->nip</td>";
            echo "<td>$row->nama</td>";
            echo "<td>$row->perusahaan</td>";
            echo "<td>$row->divisi</td>";
            echo "<td class='text-center'>" . (is_null($row->hrdunik) ? '<i class="fa fa-square-o"></i>' : '<i class="fa fa-check-square-o"></i>') . "</td>";
            echo (!is_null($row->hrdunik)) ? "<td class='text-center'><a href='/$menu/input/{$row->hrdunik}' class='btn " . lang('app.btnDetil2') . "' data-toggle='tooltip' title='" . lang('app.detil') . "'>" . lang('app.btn_Detil2') . "</a></td>" : "<td></td>";
            echo "</tr>";
        endforeach ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/loadview.js"></script>
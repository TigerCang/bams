<div onload="flashdata()"></div>

<table id="berkas" class="table table-striped table-hover">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" width="100"><?= lang('app.tanggal'); ?></th>
            <th scope="col"><?= lang('app.peminta'); ?></th>
            <th scope="col"><?= lang('app.nodoc'); ?></th>
            <th scope="col" width="10"><?= lang('app.pilihan'); ?></th>
            <th scope="col" width="10"><?= lang('app.perusahaan'); ?></th>
            <th scope="col" width="10"><?= lang('app.divisi'); ?></th>
            <th scope="col" width="10" class="text-center"><?= lang('app.level'); ?></th>
            <th scope="col"><?= lang('app.aksi'); ?></th>
            <th scope="col" width="10"><?= lang('app.status'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($kas as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td><a href='/cekkas/input/$row->idunik'>" . formattgl($row->tgl_minta) . "</a></td>";
            echo "<td><a href='/cekkas/input/$row->idunik'>$row->peminta</a></td>";
            echo "<td><a href='/cekkas/input/$row->idunik'>$row->nodoc</a></td>";
            echo "<td><a href='/cekkas/input/$row->idunik'>" . lang('app.' . $row->pilihan) . "</a></td>";
            echo "<td><a href='/cekkas/input/$row->idunik'>$row->perusahaan</a></td>";
            echo "<td><a href='/cekkas/input/$row->idunik'>$row->divisi</a></td>";
            echo "<td class='text-center'><a href='/cekkas/input/$row->idunik'>$row->level_pos</a></td>";
            echo "<td><a href='/cekkas/input/$row->idunik'>" . (($row->aksi == '') ? '' : lang('app.' . $row->aksi)) . "</a></td>";
            switch ($row->status) {
                case '0':
                    echo "<td><label class='label label-inverse'>" . lang('app.blmacc') . "</label></td>";
                    break;
                case '1':
                    echo "<td><label class='label label-inverse-primary'>" . lang('app.baru') . "</label></td>";
                    break;
                case '2':
                    echo "<td><label class='label label-primary'>" . lang('app.proses') . "</label></td>";
                    break;
                case '3':
                    echo "<td><label class='label label-warning'>" . lang('app.revisi') . "</label></td>";
                    break;
                case '4':
                    echo "<td><label class='label label-danger'>" . lang('app.tolak') . "</label></td>";
                    break;
                case '5':
                    echo "<td><label class='label label-inverse-warning'>" . lang('app.keuangan') . "</label></td>";
                    break;
                case '6':
                    echo "<td><label class='label label-inverse-success'>" . lang('app.siapbayar') . "</label></td>";
                    break;
                case '7':
                    echo "<td><label class='label label-success'>" . lang('app.dibayar') . "</label></td>";
                    break;
            }
            echo "</tr>";
        endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#berkas').DataTable({
            "ordering": true,
            "searching": true,
            "buttons": ['copy', 'excel', 'print'],
            dom: 'lBfrtpi',
        });
    });
</script>
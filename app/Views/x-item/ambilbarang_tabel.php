<table id="tabelload" class="table table-striped table-hover nowrap">
    <thead>
        <?= "
        <tr class='bghead'>
            <th scope='col' width='10'>#</th>
            <th scope='col' width='100'>" . lang('app.tanggal') . "</th>
            <th scope='col'>" . lang('app.user') . " : " . lang('app.peminta') . "</th>
            <th scope='col'>" . lang('app.nodoc') . "</th>
            <th scope='col'>" . lang('app.perusahaan') . "</th>
            <th scope='col'>" . lang('app.divisi') . "</th>
            <th scope='col' width='10' class='text-center'>" . lang('app.level') . "</th>
            <th scope='col' width='10'>" . lang('app.status') . "</th>
            <th scope='col' width='10' data-orderable='false'></th>
        </tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($ambil as $row) :
            echo "<tr class='" . ($row->st_seru == 'on' ? 'bgtr2' : '') . ($row->xlog == null ? ' fonbol' : '') . "'>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . formattanggal($row->tanggal) . "</td>";
            echo "<td>$row->kodeuser : $row->kodepeminta</td>";
            echo "<td>$row->nodoc ($row->revisi)</td>";
            echo "<td>$row->perusahaan</td>";
            echo "<td>
                    <div class='d-inline-block align-middle'>
                        <h7>{$row->divisi}</h7>
                        <p class='text-muted m-b-0'>{$row->wilayah}</p>
                    </div>
                </td>";
            echo "<td class='text-center'>$row->level_pos</td>";
            $status = statuslabel('barangpo', $row->status);
            echo "<td class='text-center'><label class='label " . $status['class'] . "'>" . $status['text'] . "</label></td>";
            echo "<td>
                    <div class='dropdown-primary dropdown'>" . lang('app.btnDropdown') . "
                        <div class='dropdown-menu eddm dropdown-menu-right'>
                            <a class='dropdown-item eddi' href='/$menu/input/$row->idunik'>" . lang('app.detil') . "</a>
                        </div>
                    </div>
                </td>";
            echo "</tr>";
        endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
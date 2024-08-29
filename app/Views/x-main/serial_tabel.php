<table id="tabelload" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.noseri') ?></th>
            <!-- <th scope="col"><= lang('app.kode') ?></th> -->
            <th scope="col"><?= lang('app.deskripsi') ?></th>
            <!-- <th scope="col" class="text-center"><= lang('app.perbaikan') ?></th> -->
            <th scope="col" class="text-right"><?= lang('app.harga') ?></th>
            <th scope="col"><?= lang('app.alat') ?></th>
            <th scope="col" width="10"><?= lang('app.status') ?></th>
            <th scope="col" width="10" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($serial as $row) :
            $status = statuslabel('master', ($row->is_aktif == '1' ? $row->is_confirm : 'a')) ?>
            <tr <?= ($row->xlog == null ? " class='fonbol'" : "") ?>>
                <td><?= $nomor++ . "." ?></td>
                <td><?= $row->noseri ?></td>
                <!-- <td><= $row->kodebrg ?></td> -->
                <td><?= $row->barang ?></td>
                <!-- <td class="text-center"><= $row->reparasi ?></td> -->
                <td class="text-right"><?= formatkoma($row->harga) ?></td>
                <td><?= $row->nomoralat ?></td>
                <td class="text-center"><label class="label <?= $status['class'] ?>"><?= $status['text'] ?></label></td>
                <td>
                    <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                        <div class="dropdown-menu eddm dropdown-menu-right">
                            <a class="dropdown-item eddi" href="/noseri/input/<?= $row->idunik ?>"><?= lang('app.detil') ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
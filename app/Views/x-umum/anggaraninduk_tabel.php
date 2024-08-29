<?php $phid = ($menu == 'anggobjek' ? 'hidden' : ''); ?>
<table id="tabelload" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col"><?= lang('app.nodoc') ?></th>
            <!-- <th scope="col"><= lang('app.pilihan') ?></th> -->
            <th scope="col"><?= lang('app.perusahaan') ?></th>
            <th scope="col"><?= ($tujuan == 'proyek' ? lang('app.wilayah') : lang('app.divisi')) ?></th>
            <th scope="col"><?= lang('app.' . $tujuan) ?></th>
            <th scope="col" <?= $phid ?>><?= lang('app.ruas') ?></th>
            <th scope="col"><?= lang('app.deskripsi') ?></th>
            <!-- <th scope="col" class="text-center" <= $phid ?>><= lang('app.tahun') ?></th> -->
            <th scope="col" class="text-center"><?= lang('app.periode') ?></th>
            <th scope="col" class="text-center" width="10"><?= lang('app.revisi') ?></th>
            <th scope="col" class="text-right"><?= lang('app.total') ?></th>
            <th scope="col" width="10"><?= lang('app.status') ?></th>
            <th scope="col" width="10" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        $noalat = $ruas = $tahunproyek = '';
        foreach ($anggaran as $row) :
            $status = statuslabel('biayaang', $row->status);
            switch ($row->tujuan) {
                case 'tool':
                case 'alat':
                    $kodebeban = $row->alat;
                    $deskbeban = $row->namaalat;
                    $noalat = $row->nomoralat;
                    break;
                case 'camp':
                    $kodebeban = $row->camp;
                    $deskbeban = $row->namacamp;
                    break;
                case 'tanah':
                    $kodebeban = $row->tanah;
                    $deskbeban = $row->namatanah;
                    break;
                case 'proyek':
                    $kodebeban = $row->proyek;
                    $deskbeban = $row->paketproyek;
                    $ruas = $row->ruas;
                    $tahunproyek = $row->tahunproyek;
                    break;
            } ?>
            <tr class="<?= ($row->xlog == null ? ' fonbol' : '') ?>">
                <td><?= $nomor++ ?>.</td>
                <td><?= $row->nodoc ?></td>
                <!-- <td><= lang('app.' . $row->pilihan) ?></td> -->
                <td><?= $row->perusahaan ?></td>
                <td>
                    <div class="d-inline-block align-middle">
                        <h7><?= ($tujuan == 'proyek' ? $row->wilayah : $row->divisi) ?></h7>
                        <p class="text-muted m-b-0"><?= ($tujuan == 'proyek' ? $row->divisi : $row->wilayah) ?></p>
                    </div>
                </td>
                <td>
                    <div class="d-inline-block align-middle">
                        <h7><?= $kodebeban ?></h7>
                        <p class="text-muted m-b-0"><?= $noalat ?></p>
                    </div>
                </td>
                <td <?= $phid ?>><?= $ruas ?></td>
                <td><?= $deskbeban ?></td>
                <!-- <td <= $phid ?>><= $tahunproyek ?></td> -->
                <td><?= formattanggal($row->tanggal1) . ' - ' . formattanggal($row->tanggal2) ?></td>
                <td class="text-center"><?= $row->adendum . '.' . $row->revisi ?></td>
                <td class="text-right"><?= formatkoma($row->totallev1) ?></td>
                <td class="text-center"><label class="label <?= $status['class'] ?>"><?= $status['text'] ?></label></td>
                <td>
                    <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                        <div class="dropdown-menu eddm dropdown-menu-right">
                            <a class="dropdown-item eddi" href="/<?= $menu ?>/input/<?= $row->idunik ?>"><?= lang('app.detil') ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
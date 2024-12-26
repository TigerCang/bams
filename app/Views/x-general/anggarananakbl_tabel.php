<?php
[$bhid, $akhid, $mphid, $mhid, $shid, $ahid, $chid, $phid, $khid, $ixhid, $xxx] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($bapmsacpkix)); ?>
<table id="tabelload3" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10" rowspan="2" class="align-middle">#</th>
            <th scope="col" rowspan="2" class="align-middle" <?= $bhid ?>><?= lang('app.itembiaya') ?></th>
            <th scope="col" rowspan="2" class="align-middle" <?= $mphid ?>>M.P.</th>
            <th scope="col" rowspan="2" class="align-middle"><?= lang('app.deskripsi') ?></th>
            <th scope="col" rowspan="2" class="align-middle text-right" <?= $ahid ?>><?= lang('app.jumlah') ?></th>
            <th scope="col" rowspan="2" class="align-middle text-center" <?= $shid ?>><?= lang('app.satuan') ?></th>
            <th scope="col" colspan="2" class="text-center" <?= $ahid ?>><?= lang('app.harga') ?></th>
            <th scope="col" colspan="2" class="text-center" <?= $ahid ?>><?= lang('app.total') ?></th>
            <th scope="col" rowspan="2" class="align-middle text-center" <?= $phid ?>>%</th>
            <th scope="col" rowspan="2" class="align-middle text-right bghead2" <?= $chid ?>><?= lang('app.cco') ?></th>
            <th scope="col" colspan="2" class="text-center bghead2" <?= $chid ?>><?= lang('app.harga') ?></th>
            <th scope="col" colspan="2" class="text-center bghead2" <?= $chid ?>><?= lang('app.total') ?></th>
            <th scope="col" rowspan="2" class="align-middle text-center bghead2" <?= $phid ?>>%</th>
            <th scope="col" rowspan="2" class="align-middle text-center" <?= $khid ?>><?= lang('app.kelompok') ?></th>
            <th scope="col" rowspan="2" class="align-middle"><?= lang('app.catatan') ?></th>
            <th scope="col" rowspan="2" class="align-middle text-center" width="10" data-orderable="false"></th>
        </tr>
        <tr class="bghead">
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.kontrak') ?></th>
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.kerja') ?></th>
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.kontrak') ?></th>
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.kerja') ?></th>
            <th scope="col" class="text-right bghead2" <?= $chid ?>><?= lang('app.kontrak') ?></th>
            <th scope="col" class="text-right bghead2" <?= $chid ?>><?= lang('app.kerja') ?></th>
            <th scope="col" class="text-right bghead2" <?= $chid ?>><?= lang('app.kontrak') ?></th>
            <th scope="col" class="text-right bghead2" <?= $chid ?>><?= lang('app.kerja') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($anggaran as $row) :
            $spasi = str_repeat("&emsp;", $row->levelbiaya - 1);
            $status = statuslabel('warnaang', ($row->levelbiaya == '3' ? '4' : $row->levelbiaya));
            $totkontrak = $row->total_kontrak;
            $persen = ($totkontrak != 0) ? $row->total_kerja / $totkontrak * 100 : '-';
            $persen = ($persen > 1000) ? '-' : ($persen != '-' ? formatkoma((float)$persen) : '-');
            $totkontrakcco = $row->total_kontrak_cco;
            $persencco = ($totkontrakcco != 0) ? $row->total_kerja_cco / $totkontrakcco * 100 : '-';
            $persencco = ($persencco > 1000) ? '-' : ($persencco != '-' ? formatkoma((float)$persencco) : '-') ?>
            <tr class="<?= $status['class'] ?>">
                <td><?= $nomor++ ?>.</td>
                <td><?= $spasi . $row->biaya ?></td>
                <td><?= $row->matabayar ?></td>
                <td><?= $row->namabiaya ?></td>
                <td class="text-right"><?= ($row->jumlah_kontrak == '0' ? '' : formatkoma($row->jumlah_kontrak, '4')) ?></td>
                <td class="text-center"><?= $row->satuan ?></td>
                <td class="text-right"><?= ($row->harga_kontrak == '0' ? '' : formatkoma($row->harga_kontrak)) ?></td>
                <td class="text-right"><?= ($row->harga_kerja == '0' ? '' : formatkoma($row->harga_kerja)) ?></td>
                <td class="text-right"><?= formatkoma($row->total_kontrak) ?></td>
                <td class="text-right"><?= formatkoma($row->total_kerja) ?></td>
                <td class="text-center"><?= $persen ?></td>
                <td class="text-right"><?= ($row->jumlah_cco == '0' ? '' : formatkoma($row->jumlah_cco, '4')) ?></td>
                <td class="text-right"><?= ($row->harga_kontrak_cco == '0' ? '' : formatkoma($row->harga_kontrak_cco)) ?></td>
                <td class="text-right"><?= ($row->harga_kerja_cco == '0' ? '' : formatkoma($row->harga_kerja_cco)) ?></td>
                <td class="text-right"><?= formatkoma($row->total_kontrak_cco) ?></td>
                <td class="text-right"><?= formatkoma($row->total_kerja_cco) ?></td>
                <td class="text-center"><?= $persencco ?></td>
                <td class="text-center"><?= strtoupper(substr($row->kelin, 0, 1)) ?></td>
                <td><?= $row->catatan ?></td>
                <td <?= $ixhid ?>>
                    <?php if ($row->levelbiaya == '3') : ?>
                        <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                            <div class="dropdown-menu eddm dropdown-menu-right">
                                <a class="dropdown-item eddi ubahdata" data-id="<?= $row->id ?>"><?= lang('app.ubah') ?></a>
                                <a class="dropdown-item eddi" onclick="hapus('<?= $row->id ?>', '<?= $row->namabiaya ?>')"><?= lang('app.hapus') ?></a>
                            </div>
                        </div>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
<script>
    function hapus(id, deskripsi) {
        var url = '/anggbiayal/delitem';
        Swal.fire({
            title: '<?= lang('app.tanyadel') ?>',
            text: "<?= lang('app.infodel') ?>",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('app.confirmdel') ?>',
            cancelButtonText: '<?= lang('app.batal') ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        id: id,
                        barang: deskripsi,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) { //dari msg save lampiran
                            flashdata('success', response.sukses);
                            dataitembarang();
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
<?php
[$bhid, $akhid, $mphid, $mhid, $shid, $ahid, $chid, $phid, $khid, $ixhid, $xxx] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($bapmsacpkix)); ?>
<table id="tabelload3" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" <?= $bhid ?>><?= lang('app.itembiaya') ?></th>
            <th scope="col" <?= $akhid ?>><?= lang('app.noakun') ?></th>
            <th scope="col"><?= lang('app.deskripsi') ?></th>
            <th scope="col" class="text-center" <?= $mhid ?>><?= ucfirst(lang('app.bulan')) ?></th>
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.jumlah') ?></th>
            <th scope="col" class="text-center" <?= $shid ?>><?= lang('app.satuan') ?></th>
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.harga') ?></th>
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.total') ?></th>
            <th scope="col"><?= lang('app.catatan') ?></th>
            <th scope="col" width="10" data-orderable="false" <?= $ixhid ?>></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($anggaran as $row) :
            $level = ($tujuan == 'proyek' ? $row->levelbiaya : $row->levelakun);
            $spasi = str_repeat("&emsp;", $level - 1);
            $status = statuslabel('warnaang', $level);
            $deskripsi = ($tujuan == 'proyek' ? $row->namabiaya : $row->namaakun) ?>
            <tr class="<?= $status['class'] ?>">
                <td><?= $nomor++ ?>.</td>
                <td <?= $bhid ?>><?= $spasi . $row->biaya ?></td>
                <td <?= $akhid ?>><?= $spasi . $row->noakun ?></td>
                <td><?= $deskripsi ?></td>
                <td class="text-center" <?= $ahid ?>><?= ($level == '4' ? formatkoma($row->bulan) : '') ?></td>
                <td class="text-right" <?= $ahid ?>><?= ($level == '4' ? formatkoma($row->jumlah_cco, 4) : '') ?></td>
                <td class="text-center" <?= $shid ?>><?= ($level == '4' ? $row->satuan : '') ?></td>
                <td class="text-right" <?= $ahid ?>><?= ($level == '4' ? formatkoma($row->harga_kontrak_cco) : '') ?></td>
                <td class="text-right" <?= $ahid ?>><?= formatkoma($row->total_kontrak_cco) ?></td>
                <td><?= $row->catatan ?></td>
                <td <?= $ixhid ?>>
                    <?php if ($level == '4') : ?>
                        <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                            <div class="dropdown-menu eddm dropdown-menu-right">
                                <a class="dropdown-item eddi ubahdata" data-id="<?= $row->id ?>"><?= lang('app.ubah') ?></a>
                                <a class="dropdown-item eddi" onclick="hapus('<?= $row->id ?>', '<?= $deskripsi ?>')"><?= lang('app.hapus') ?></a>
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
    $('.ubahdata').click(function(e) {
        e.preventDefault();
        var getID = $(this).data('id');
        $.ajax({
            url: "/mintabarang/modalkoreksi",
            data: {
                id: getID,
            },
            dataType: "json",
            success: function(response) {
                $('.modallampiran').html(response.data).show();
                $('#modal-lampiran').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    function hapus(id, deskripsi) {
        var url = '/mintabarang/delitem';
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
<?php
$stat = (preg_match("/$nstat/i", '013') ? '' : 'hidden');
[$jhid, $ahid, $bhid, $ohid, $shid, $khid, $ixhid, $xxx] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($jaboskix)); ?>
<table id="tabelload3" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" width="10"></th>
            <th scope="col"><?= lang('app.deskripsi') ?></th>
            <th scope="col"><?= lang('app.spesifikasi') ?></th>
            <th scope="col" class="text-right" <?= $jhid ?>><?= lang('app.jumlah') ?></th>
            <th scope="col" class="text-right" <?= $ahid ?>><?= lang('app.ada') ?></th>
            <th scope="col" <?= $ahid ?>></th>
            <th scope="col" class="text-right" <?= $bhid ?>><?= lang('app.jlbeli') ?></th>
            <th scope="col" class="text-right" <?= $ohid ?>><?= lang('app.pesan') ?></th>
            <th scope="col" class="text-center" <?= $ohid ?>>&#11206;</th>
            <th scope="col" class="text-center" <?= $shid ?>><?= lang('app.satuan') ?></th>
            <th scope="col" class="text-right" <?= $khid ?>><?= lang('app.konversi') ?></th>
            <th scope="col"><?= lang('app.catatan') ?></th>
            <th scope="col" width="10" data-orderable="false" <?= $ixhid . $stat ?>></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($barang as $row) :
            $deskripsi = ($row->jenis == '1' ? $row->namaitem : $row->namaakun) ?>
            <tr>
                <td><?= $nomor++ ?>.</td>
                <td class="text-center"><?= ($row->jenis == '0' ? '&#8480;' : '') ?></td>
                <td><?= $deskripsi ?></td>
                <td><?= $row->spesifikasi ?></td>
                <td class="text-right" <?= $jhid ?>><?= formatkoma($row->jumlah, 4) ?></td>
                <td class="text-right" <?= $ahid ?>><?= formatkoma($row->ada, 4) ?></td>
                <td class="text-center" <?= $ahid ?>><?= ($row->is_ada == '1' ? '&#9204' : '') ?></td>
                <td class="text-right" <?= $bhid ?>><?= formatkoma($row->jumlah - $row->ada, 4) ?></td>
                <td class="text-right" <?= $ohid ?>>0,00</td>
                <td class="text-center" <?= $ohid ?>><?= $row->jltawar ?></td>
                <td class="text-center" <?= $shid ?>><?= ($row->jenis == '1' ? $row->satuan : '') ?></td>
                <td class="text-right" <?= $khid ?>><?= ($row->konversi == '0' ? '' : formatkoma($row->konversi)) ?></td>
                <td><?= $row->catatan ?></td>
                <td <?= $ixhid . $stat ?>>
                    <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                        <div class="dropdown-menu eddm dropdown-menu-right">
                            <a class="dropdown-item eddi ubahdata" data-id="<?= $row->id ?>"><?= lang('app.ubah') ?></a>
                            <a class="dropdown-item eddi" onclick="hapus('<?= $row->id ?>', '<?= $deskripsi ?>')"><?= lang('app.hapus') ?></a>
                        </div>
                    </div>
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
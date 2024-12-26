<?php
// $stat = (preg_match("/$nstat/i", '013') ? '' : 'hidden');
$stat = '';
[$b1hid, $ahid, $shid, $b2hid, $phid, $rhid, $ixhid, $xxx] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($basbprix)); ?>
<table id="tabelload3" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" <?= $b1hid ?>><?= lang('app.ruas') ?></th>
            <th scope="col" <?= $b1hid ?>><?= lang('app.item') ?></th>
            <th scope="col" <?= $ahid ?>><?= lang('app.noakun') ?></th>
            <th scope="col"><?= lang('app.deskripsi') ?></th>
            <th scope="col" <?= $b1hid ?>><?= lang('app.sumberdaya') ?></th>
            <th scope="col" <?= $b1hid ?>><?= lang('app.deskripsi') ?></th>
            <th scope="col" <?= $shid ?>><?= lang('app.supir') ?></th>
            <th scope="col" <?= $shid ?>><?= lang('app.nama') ?></th>
            <th scope="col" <?= $b2hid ?>><?= lang('app.item') ?></th>
            <th scope="col" <?= $b2hid ?>><?= lang('app.deskripsi') ?></th>
            <th scope="col" class="text-right"><?= lang('app.jumlah') ?></th>
            <th scope="col" class="text-right"><?= lang('app.harga') ?></th>
            <th scope="col" class="text-right"><?= lang('app.total') ?></th>
            <th scope="col"><?= lang('app.catatan') ?></th>
            <th scope="col" <?= $phid ?>></th>
            <th scope="col" <?= $rhid ?>></th>
            <th scope="col" width="10" data-orderable="false" <?= $ixhid . $stat ?>></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        $total = 0;
        foreach ($biaya as $row) :
            $deskripsi = ($row->tujuan == 'proyek' ? $row->namabiaya : $row->namaakun);
            $dk = ($row->kredit > 0 ? -1 * $row->kredit : $row->debit);
            $warna = ($row->kredit > '0' ? 'warnamin' : '');
            $total += $dk; ?>
            <tr>
                <td><?= $nomor++ ?>.</td>
                <td <?= $b1hid ?>><?= $row->ruas ?></td>
                <td <?= $b1hid ?>><?= $row->biaya ?></td>
                <td <?= $ahid ?>><?= $row->noakun ?></td>
                <td><?= $deskripsi ?></td>
                <td <?= $b1hid ?>><?= $row->sumberdaya ?></td>
                <td <?= $b1hid ?>><?= $row->namasumberdaya ?></td>
                <td <?= $shid ?>>supir</td>
                <td <?= $shid ?>>supir</td>
                <td <?= $b2hid ?>>barang</td>
                <td <?= $b2hid ?>>barang</td>
                <td class="text-right"><?= formatkoma($row->jumlah, '4') ?></td>
                <td class="text-right"><?= formatkoma($row->harga) ?></td>
                <td class="text-right <?= $warna ?>"><?= formatkoma($dk) ?></td>
                <td><?= $row->catatan ?></td>
                <td <?= $phid ?>></td>
                <td <?= $rhid ?>></td>
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
        <tr class="bghead2">
            <td></td>
            <td <?= $b1hid ?>></td>
            <td <?= $b1hid ?>></td>
            <td <?= $ahid ?>></td>
            <td></td>
            <td <?= $b1hid ?>></td>
            <td <?= $b1hid ?>></td>
            <td <?= $shid ?>></td>
            <td <?= $shid ?>></td>
            <td <?= $b2hid ?>></td>
            <td <?= $b2hid ?>></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td <?= $phid ?>></td>
            <td <?= $rhid ?>></td>
            <td <?= $ixhid . $stat ?>></td>
        </tr>
        <tr class="fonbol">
            <td></td>
            <td <?= $b1hid ?>></td>
            <td <?= $b1hid ?>></td>
            <td <?= $ahid ?>></td>
            <td>TOTAL</td>
            <td <?= $b1hid ?>></td>
            <td <?= $b1hid ?>></td>
            <td <?= $shid ?>></td>
            <td <?= $shid ?>></td>
            <td <?= $b2hid ?>></td>
            <td <?= $b2hid ?>></td>
            <td></td>
            <td></td>
            <td class='text-right'><?= formatkoma($total) ?></td>
            <td></td>
            <td <?= $phid ?>></td>
            <td <?= $rhid ?>></td>
            <td <?= $ixhid . $stat ?>></td>
        </tr>
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
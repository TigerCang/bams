<?php
[$bhid, $s1hid, $ohid, $mhid, $s2hid, $hhid, $dhid, $thid, $p1hid, $s3hid, $p2hid, $ihid, $xxx] = array_map(function ($hid) {
    return $hid == '1' ? '' : 'hidden';
}, str_split($bsomshdtpspix));
$x = (substr($bsomshdtpspix, -1));
?>
<table id="tabeltok2" class="table table-striped table-hover nowrap">
    <thead>
        <?= "
        <tr class='bghead'>
        <th scope='col' width='10'>#</th>
        <th scope='col' $bhid width='10'></th>
        <th scope='col' $bhid>" . lang('app.deskripsi') . "</th>
        <th scope='col' $s1hid>" . lang('app.spesifikasi') . "</th>
        <th scope='col' $ohid class='text-right'>" . lang('app.jumlah') . "</th>
        <th scope='col' $mhid class='text-right'>" . lang('app.jlmasuk') . "</th>
        <th scope='col' $s2hid class='text-center'>" . lang('app.satuan') . "</th>
        <th scope='col' $hhid class='text-right'>" . lang('app.harga') . "</th>
        <th scope='col' $dhid class='text-right'>" . lang('app.diskon') . "</th>
        <th scope='col' $thid class='text-right'>" . lang('app.total') . "</th>
        <th scope='col' $p1hid class='text-center'>" . lang('app.pajak') . "</th>
        <th scope='col'>" . lang('app.catatan') . "</th>
        <th scope='col' $s3hid>" . lang('app.suplier') . "</th>
        <th scope='col' $p2hid class='text-center'>&#11206;</th>
        <th scope='col' $ihid width='10' data-orderable='false'></th>
        </tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($barang as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td $bhid class='text-center'>" . ($row->jenis == '0' ? '&#8480;' : '') . "</td>";
            $deskripsi = ($row->jenis == '1' ? $row->namaitem : $row->namaakun);
            echo "<td $bhid>" . $deskripsi  . "</td>";
            echo "<td $s1hid>$row->spesifikasi</td>";
            echo "<td $ohid class='text-right'>" . formatkoma($row->jumlah, 4) . "</td>";
            echo "<td $mhid class='text-right'>" . formatkoma($row->jumlah, 4) . "</td>";
            echo "<td $s2hid class='text-center'>" . ($row->jenis == '1' ? $row->satuan : '') . "</td>";
            echo "<td $hhid class='text-right'>" . formatkoma($row->harga) . "</td>";
            echo "<td $dhid class='text-right'>" . formatkoma($row->diskon) . "</td>";
            echo "<td $thid class='text-right'>" . formatkoma($row->total) . "</td>";
            echo "<td $p1hid class='text-center'>" . ($row->st_pajak == '1' ? '<i class="fa fa-check"></i>' : '') . "</td>";
            echo "<td>$row->catatan</td>";
            echo "<td $s3hid>$row->namapenerima</td>";
            echo "<td $p2hid class='text-center'>" . ($row->st_pilih == '0' ? '' : '&#9204') . "</td>";
            echo "<td $ihid>
                    <div class='dropdown-primary dropdown'>" . lang('app.btnDropdown') . "
                        <div class='dropdown-menu eddm dropdown-menu-right'>";
            if ($x == "a") { //edit del
                echo "<a class='dropdown-item eddi ubahdata' data-id='" . $row->id . "', data-poanak='" . $row->poanak_id . "'>" . lang('app.ubah') . "</a>
                    <a class='dropdown-item eddi' onclick=\"hapus('" . $row->id . "','" . $deskripsi . "','" . $row->namapenerima . "')\">" . lang('app.hapus') . "</a>";
            } elseif ($x == "b") { //pilih suplier
                echo "<a class='dropdown-item eddi pilihsuplier' data-id='" . $row->id . "', data-poanak='" . $row->poanak_id . "', data-suplier='" . $row->namapenerima . "'>" . lang('app.pilih') . "</a>";
            }
            echo "</div>
                </div>
            </td>";
            echo "</tr>";
        endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
<script>
    $('.ubahdata').click(function(e) {
        e.preventDefault();
        var getID = $(this).data('id');
        var getPoanak = $(this).data('poanak');
        $.ajax({
            url: "/tawarharga/modalkoreksi",
            data: {
                id: getID,
                poanak: getPoanak,
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

    function hapus(id, deskripsi, suplier) {
        var url = '/tawarharga/delbarang';
        Swal.fire({
            title: '<?= lang('app.tanyadel2') ?>',
            text: "<?= lang('app.infodel') ?>",
            icon: 'warning',
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
                        suplier: suplier,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) { //dari msg save lampiran
                            flashdata('success', response.sukses);
                            datahargasuplier();
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

    $('.pilihsuplier').click(function(e) {
        e.preventDefault();
        var getID = $(this).data('id');
        var getPOanak = $(this).data('poanak');
        var getSuplier = $(this).data('suplier');
        $.ajax({
            type: 'post',
            url: "/pilihharga/suplier",
            data: {
                id: getID,
                anak: getPOanak,
                suplier: getSuplier,
            },
            dataType: "json",
            success: function(response) {
                flashdata('success', response.sukses);
                datahargasuplier();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })
</script>
<table id="tabeltok1" class="table table-striped table-hover nowrap">
    <thead>
        <?= "
        <tr class='bghead'>
            <th scope='col' width='10'>#</th>
            <th scope='col'>" . lang('app.nodoc') . "</th>
            <th scope='col'>" . lang('app.pegawai') . "</th>
            <th scope='col'>" . lang('app.perusahaan') . "</th>
            <th scope='col'>" . lang('app.wilayah') . "</th>
            <th scope='col'>" . lang('app.divisi') . "</th>
            <th scope='col'>" . lang('app.item') . "</th>
            <th scope='col' class='text-right'>" . lang('app.jumlah') . "</th>
            <th scope='col' class='text-center'>" . lang('app.satuan') . "</th>
            <th scope='col'>" . lang('app.catatan') . "</th>
            <th scope='col width='10' data-orderable='false'></th>
        </tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($barang as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>$row->nodoc</td>";
            echo "<td>$row->pegawai</td>";
            echo "<td>$row->perusahaan</td>";
            echo "<td>$row->wilayah</td>";
            echo "<td>$row->divisi</td>";
            echo "<td>$row->barang</td>";
            echo "<td class='text-right'>" . $row->jumlah . "</td>";
            echo "<td class='text-center'>$row->satuan</td>";
            echo "<td>$row->catatan</td>";
            echo "<td>
                    <div class='dropdown-primary dropdown'>" . lang('app.btnDropdown') . "
                        <div class='dropdown-menu eddm dropdown-menu-right'>";
            echo "<a class='dropdown-item eddi ubahdata' data-id='" . $row->id . "'>" . lang('app.ubah') . "</a>
                    <a class='dropdown-item eddi' onclick=\"hapus('" . $row->id . "','" . $row->barang . "')\">" . lang('app.hapus') . "</a>";
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
        $.ajax({
            url: "/ambilbarang/modalkoreksi",
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

    function hapus(id, barang) {
        var url = '/ambilbarang/delitem';
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
                        barang: barang,
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
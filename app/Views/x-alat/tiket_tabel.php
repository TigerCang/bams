<table id="tabellampiran" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <?php
        echo "<tr class='bghead'>";
        echo "<th scope='col' width='10'>#</th>";
        echo "<th scope='col'>" . lang('app.tanggal') . "</th>";
        echo "<th scope='col'>" . lang('app.notiket') . "</th>";
        echo "<th scope='col'>" . lang('app.bahan') . "</th>";
        echo "<th scope='col'>" . lang('app.alat') . "</th>";
        echo "<th scope='col'>" . lang('app.supir') . "</th>";
        echo "<th scope='col' class='text-right'>" . lang('app.jumlah') . "</th>";
        echo "<th scope='col'>" . lang('app.ruas') . "</th>";
        echo "<th scope='col'>" . lang('app.catatan') . "</th>";
        echo "<th scope='col' class='text-center' width='10'>" . lang('app.aksi') . "</th>";
        echo "<th scope='col' class='text-center' width='10'>" . lang('app.aksi') . "</th>";
        echo "<th scope='col' class='text-center' width='10'>" . lang('app.aksi') . "</th>";
        echo "</tr>"; ?>
    </thead>
    <tbody>
        <?php $nomor = 1;
        $total = 0;
        foreach ($tiket as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . formattanggal($row->tanggal, 5) . "</td>";
            echo "<td>$row->notiket</td>";
            echo "<td>$row->namabahan</td>";
            echo "<td>$row->nopol</td>";
            echo "<td>$row->namasupir</td>";
            echo "<td class='text-right'>" . formatkoma($row->jumlah, '0') . "</td>";
            echo "<td>$row->namaruas</td>";
            echo "<td>$row->catatan</td>";
            echo "<td><button class='btn " . lang('app.btnEdit2') . " ubahdata' data-id='" . $row->id . "' data-toggle='tooltip' title='" . lang('app.ubah') . "'>" . lang('app.btn_Edit2') . "</button>" . '&nbsp';
            echo "<button class='btn " . lang('app.btnDel2') . "' data-toggle='tooltip' title='" . lang('app.hapus') . "' onclick=\" hapus('" . $row->id . "','" . $row->notiket . "')\">" . lang('app.btn_Del2') . "</button></td>";
            echo "<td class='text-center'><button class='btn " . lang('app.btnOk2') . " okdata' data-id='" . $row->id . "' data-toggle='tooltip' title='" . lang('app.detil') . "'>" . lang('app.btn_Ok2') . "</button></td>";
            echo "<td class='text-center'><button class='btn " . lang('app.btnOk2') . " okdata' data-id='" . $row->id . "' data-toggle='tooltip' title='" . lang('app.ubah') . "'>" . lang('app.btn_Ok2') . "</button></td>";
            echo "</tr>";
        endforeach ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabellampiran').DataTable({
            "ordering": true,
            "searching": true,
            "autoWidth": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All'],
            ],
            "iDisplayLength": 25,
        });
    });

    function hapus(id, notiket) {
        var url = '/tiketproyek/delitem';
        Swal.fire({
            title: '<?= lang('app.tanyadel2'); ?>',
            text: "<?= lang('app.infodel'); ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= lang('app.confirmdel'); ?>',
            cancelButtonText: '<?= lang('app.batal'); ?>'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: url,
                    data: {
                        id: id,
                        kode: kode,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) { //dari msg save lampiran
                            flashdata('success', response.sukses);
                            datasalesitem();
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
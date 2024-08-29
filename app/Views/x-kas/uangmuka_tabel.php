<table id="piutang" class="table table-striped table-hover table-bordered nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" width="10"><?= lang('app.tanggal'); ?></th>
            <th scope="col"><?= lang('app.dokumen'); ?></th>
            <th scope="col"><?= lang('app.noakun'); ?></th>
            <th scope="col" class="text-right" width="150"><?= lang('app.total'); ?></th>
            <th scope="col" class="text-right" width="150"><?= lang('app.pelunasan'); ?></th>
            <th scope="col" class="text-right" width="150"><?= lang('app.saldo'); ?></th>
            <th scope="col"><?= lang('app.catatan'); ?></th>
            <th scope="col" class="text-center" width="10"><?= lang('app.aksi'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        $debit = 0;
        $kredit = 0;
        foreach ($piutang as $row) :
            echo "<tr>";
            echo "<td>" . $nomor++ . "." . "</td>";
            echo "<td>" . formattgl($row->tanggal) . "</td>";
            echo "<td>$row->nodoc</td>";
            echo "<td>$row->noakun</td>";
            echo "<td class='text-right'>" . formatrp($row->debit) . "</td>";
            $bayar = !empty($row->bayar) ? $row->bayar : "0";
            $sisa = $row->debit - $bayar;
            echo "<td class='text-right'>" . formatrp($bayar) . "</td>";
            echo "<td class='text-right'>" . formatrp($sisa) . "</td>";
            echo "<td>$row->catatan</td>";
            $debit = $debit + $row->debit;
            $kredit = $kredit + $bayar;
            echo "<td class='text-center'><button class='btn " . lang('app.btnEdit2') . " inputdata' data-induk='" . $row->idinduk . "' data-anak='" . $row->id . "' data-akun='" . $row->akun_id . "' data-sisa='" . $sisa . "' data-idu='" . $idunik . "' data-toggle='tooltip' title='" . lang('app.ubah') . "'>" . lang('app.btn_Edit2') . "</button></td>";
            echo "</tr>";
        endforeach;
        echo "<tr class='bgtr'>";
        echo "<td colspan='9'></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "<td colspan='3'>" . lang('app.total') . "</td>";
        echo "<td class='text-right'>" . formatrp($debit) . "</td>";
        echo "<td class='text-right'>" . formatrp($kredit) . "</td>";
        echo "<td class='text-right'>" . formatrp($debit - $kredit) . "</td>";
        echo "<td colspan='2'></td>";
        echo "</tr>"; ?>
    </tbody>
</table>

<script>
    $('.inputdata').click(function(e) {
        e.preventDefault();
        var induk = $(this).data('induk');
        var anak = $(this).data('anak');
        var akun = $(this).data('akun');
        var idunik = $(this).data('idu');
        var sisa = $(this).data('sisa');

        $.ajax({
            url: "/kasnonlangsung/adduangmuka",
            data: {
                idunik: idunik,
                induk: induk,
                anak: anak,
                akun: akun,
                sisa: sisa,
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
</script>
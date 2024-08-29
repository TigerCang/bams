<table id="tabelAwal" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th width="5" hidden></th>
            <th><?= ($beban == 'proyek' ? lang('app.item biaya') : lang('app.noakun')) ?></th>
            <th><?= lang('app.deskripsi') ?></th>
            <th class="text-right"><?= lang('app.bulan') ?></th>
            <th class="text-right"><?= lang('app.jumlah') ?></th>
            <th class="text-right"><?= lang('app.harga') ?></th>
            <th class="text-right"><?= lang('app.total') ?></th>
            <th class="text-right"><?= lang('app.catatan') ?></th>
            <th width="5" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($anggaran as $index => $row) :
            $spasi = str_repeat("&emsp;", $row->level - 1); ?>
            <!-- $status = statuslabel('warnaang', $row->level); ?> -->
            <tr>
                <td hidden><?= $index + 1 ?>.</td>
                <td><?= $row->kode ?></td>
                <td><?= $row->nama ?></td>
                <!-- <td class="text-right">" . ($row->level == '4' ? formatkoma($row->bulan) : '') . "</td> -->
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script src="<?= base_url('libraries') ?>/cang/js/datatable.js"></script>
<script>
    $('.ubahdata').click(function(e) {
        e.preventDefault();
        var getID = $(this).data('id');
        $.ajax({
            url: "/anggaran/modalkoreksi",
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

    function hapus(id, kode) {
        var url = '/anggaran/delitem';
        Swal.fire({
            title: '<?= lang('app.tanyadel'); ?>',
            text: "<?= lang('app.infodel'); ?>",
            icon: 'question',
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
                            databudget();
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
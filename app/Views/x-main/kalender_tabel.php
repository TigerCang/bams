<table id="tabelload" class="table table-striped table-hover nowrap">
    <thead>
        <tr class="bghead">
            <th scope="col" width="10">#</th>
            <th scope="col" width="120"><?= lang('app.tanggal') ?></th>
            <th scope="col"><?= lang('app.deskripsi') ?></th>
            <th scope="col" width="100" class="text-center"><?= lang('app.potongcuti') ?></th>
            <th scope="col" width="150"><?= lang('app.upby') ?></th>
            <th scope="col" width="10" data-orderable="false"></th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 1;
        foreach ($kalender as $row) : ?>
            <tr>
                <td><?= $nomor++ ?>.</td>
                <td><?= formattanggal($row->tanggal) ?></td>
                <td><?= $row->nama ?></td>
                <td class="text-center"><?= ($row->potong_cuti == '1' ? '<i class="fa fa-check-square-o"></i>' : '') ?></td>
                <td><?= $row->user ?></td>
                <td>
                    <div class="dropdown-primary dropdown"><?= lang('app.btnDropdown') ?>
                        <div class="dropdown-menu eddm dropdown-menu-right">
                            <a class="dropdown-item eddi" onclick="hapus('<?= $row->id ?>', '<?= $row->tanggal ?>')"><?= lang('app.hapus') ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/load.js"></script>
<script>
    function hapus(id, tanggal) {
        var url = '/kalender/hapus';
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
                        tanggal: tanggal,
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.sukses) { //dari msg save lampiran
                            flashdata('success', response.sukses);
                            caridata();
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
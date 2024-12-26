<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMselect') ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihtanah') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="card-block mt-2 mb-2">
                <div class="dt-responsive table-responsive">
                    <table id="tabelmodal" class="table table-striped table-hover nowrap">
                        <thead>
                            <?= "
                            <tr class='bghead'>
                                <th scope='col' width='10'>#</th>
                                <th scope='col'>" . lang('app.kode') . "</th>
                                <th scope='col'>" . lang('app.deskripsi') . "</th>
                                <th scope='col'>" . lang('app.perusahaan') . "</th>
                                <th scope='col'>" . lang('app.divisi') . "</th>
                                <th scope='col' width='10' data-orderable='false'></th>
                            </tr>"; ?>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            if ($beban == '0') {
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td><button type='button' id='selectaset' class='btn " . lang(' app.btnSelect') . "' data-idunik='' data-kode='' data-nama='' data-kbli=''>" . lang('app.btn_Select') . "</button></td>";
                                echo "</tr>";
                            }
                            foreach ($tanah as $row) : echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td>$row->kode</td>";
                                echo "<td>$row->nama</td>";
                                echo "<td>$row->perusahaan</td>";
                                echo "<td>
                                        <div class='d-inline-block align-middle'>
                                            <h7>{$row->divisi}</h7>
                                            <p class='text-muted m-b-0'>{$row->wilayah}</p>
                                        </div>
                                    </td>";
                                echo "<td class='text-center'>";
                                $hid1 = ($tuser['akses_perusahaan'] == 'on' || preg_match("/,$row->perusahaan_id,/i", $tuser['perusahaan']) ? '' : 'hidden');
                                $hid2 = ($tuser['akses_divisi'] == 'on' || preg_match("/,$row->divisi_id,/i", $tuser['divisi']) ? '' : 'hidden');
                                $hid3 = ($tuser['akses_aset'] == 'on' || preg_match("/,$row->id,/i", $tuser['aset']) ? '' : 'hidden');
                                if ($beban == '0')
                                    echo "<button type='button' id='selectaset' class='btn " . lang('app.btnSelect') . "' data-idunik='{$row->id}' data-kode='{$row->kode}' data-nama='{$row->nama}' data-kbli='{$row->kbli_id}' data-kodekbli='{$row->kodekbli}' data-namakbli='{$row->namakbli}'>" . lang('app.btn_Select') . "</button>";
                                else
                                    echo "<button type='button' $hid1 $hid2 $hid3 id='selectaset' class='btn " . lang('app.btnSelect') . "' data-idunik='{$row->id}' data-kode='{$row->kode}' data-nama='{$row->nama}' data-kbli='{$row->kbli_id}' data-kodekbli='{$row->kodekbli}' data-namakbli='{$row->namakbli}' data-perusahaan='{$row->perusahaan_id}' data-wilayah='{$row->wilayah_id}' data-divisi='{$row->divisi_id}'>" . lang('app.btn_Select') . "</button>";
                                echo "</td>";
                                echo "</tr>";
                            endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/modal.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#selectaset', function() {
            var idunik = $(this).data('idunik');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            var kbli = $(this).data('kbli');
            var kodekbli = $(this).data('kodekbli');
            var namakbli = $(this).data('namakbli');
            var perusahaan = $(this).data('perusahaan');
            var wilayah = $(this).data('wilayah');
            var divisi = $(this).data('divisi');
            var beban = "<?= $beban ?>";
            // 
            if (beban != '0') {
                $('#idbeban').val(idunik);
                $('#idperusahaan').val(perusahaan);
                $('#idwilayah').val(wilayah);
                $('#iddivisi').val(divisi);
                $("#perusahaan").val(perusahaan).change();
                $("#wilayah").val(wilayah).change();
                $("#divisi").val(divisi).change();
                $('#beban').val(kode);
                $('#namabeban').val(nama);
                if (beban == '2') {
                    $('#xidkbli').val(kbli);
                    $('#xkodekbli').val(kodekbli);
                    $('#xnamakbli').val(namakbli);
                    setkbli();
                }
            }
            $('#modal-lampiran').modal('hide');
        })
    });
</script>
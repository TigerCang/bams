<?php $o = substr($wenbrako, -1); ?>

<div class="modal fade" id="modal-lampiran" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header <?= lang('app.bgMselect') ?>">
                <h4 class="modal-title"><?= lang('app.titlepilihproyek') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--  -->
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
                                <th scope='col'>" . lang('app.wilayah') . "</th>
                                <th scope='col' width='10' data-orderable='false'></th>
                            </tr>"; ?>
                        </thead>
                        <tbody>
                            <?php $nomor = 1;
                            if ($o == '1') {
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td></td>";
                                echo "<td class='text-center'><button type='button' id='selectproyek' class='btn " . lang('app.btncPilih2') . "' data-toggle='tooltip' title='" . lang('app.pilih') . "' data-id='' data-kode='' data-nama='' 
                                        data-perusahaan='' data-wilayah='' data-divisi='' data-kbli='' data-kodekbli='' data-namakbli='' data-tipe='' data-bruto='' data-netto='' data-penerima='' data-pajak=''>" . lang('app.btnPilih2') . "</button></td>";
                                echo "</tr>";
                            }
                            foreach ($proyek as $row) :
                                echo "<tr>";
                                echo "<td>" . $nomor++ . "." . "</td>";
                                echo "<td>$row->kode</td>";
                                echo "<td>
                                        <div class='d-inline-block align-middle'>
                                            <h7>{$row->paket}</h7>
                                            <p class='text-muted m-b-0'>{$row->nama}</p>
                                        </div>
                                    </td>";
                                echo "<td>$row->perusahaan</td>";
                                echo "<td>
                                        <div class='d-inline-block align-middle'>
                                            <h7>{$row->wilayah}</h7>
                                            <p class='text-muted m-b-0'>{$row->divisi}</p>
                                        </div>
                                    </td>";
                                echo "<td class='text-center'>";
                                $hid1 = ($tuser['act_perusahaan'] == '1' || preg_match("/,$row->perusahaan_id,/i", $tuser['perusahaan']) ? '' : 'hidden');
                                $hid2 = ($tuser['act_wilayah'] == '1' || preg_match("/,$row->wilayah_id,/i", $tuser['wilayah']) ? '' : 'hidden');
                                $hid3 = ($tuser['act_divisi'] == '1' || preg_match("/,$row->divisi_id,/i", $tuser['divisi']) ? '' : 'hidden');
                                $hid4 = ($tuser['act_proyek'] == '1' || preg_match("/,$row->id,/i", $tuser['proyek']) ? '' : 'hidden');
                                echo "<button type='button' " . ($o == '0' ? "$hid1 $hid2 $hid3 $hid4" : '') . " id='selectproyek' class='btn " . lang('app.btncPilih2') . "' data-toggle='tooltip' title='" . lang('app.pilih') . "' data-id='{$row->id}' 
                                        data-kode='{$row->kode}' data-nama='{$row->paket}' data-perusahaan='{$row->perusahaan_id}' data-wilayah='{$row->wilayah_id}' data-divisi='{$row->divisi_id}' data-kbli='{$row->kbli_id}' data-kodekbli='{$row->kodekbli}' 
                                        data-namakbli='{$row->namakbli}' data-tipe='{$row->tipe_id}' data-bruto='{$row->ni_bruto}' data-netto='{$row->ni_netto}' data-penerima='{$row->penerimaid}' data-pajak='{$row->is_pajak}'>" . lang('app.btnPilih2') . "</button>";
                                echo "</td>";
                                echo "</tr>";
                            endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--  -->
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= base_url('libraries') ?>/bower_components/extra/js/modal.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#selectproyek', function() {
            var id = $(this).data('id');
            var kode = $(this).data('kode');
            var nama = $(this).data('nama');
            var kbli = $(this).data('kbli');
            var kodekbli = $(this).data('kodekbli');
            var namakbli = $(this).data('namakbli');
            var tipe = $(this).data('tipe');
            var bruto = $(this).data('bruto').toString().replace(".", ",");
            var netto = $(this).data('netto').toString().replace(".", ",");
            var perusahaan = $(this).data('perusahaan');
            var wilayah = $(this).data('wilayah');
            var divisi = $(this).data('divisi');
            var penerima = $(this).data('penerima');
            var pajak = $(this).data('pajak');
            var w01 = "<?= substr($wenbrako, 0, 1) ?>";
            var e01 = "<?= substr($wenbrako, 1, 1) ?>";
            var n01 = "<?= substr($wenbrako, 2, 1) ?>";
            var b01 = "<?= substr($wenbrako, 3, 1) ?>";
            var r01 = "<?= substr($wenbrako, 4, 1) ?>";
            var a01 = "<?= substr($wenbrako, 5, 1) ?>";

            if (w01 == '1') {
                $("#perusahaan").val(perusahaan).change();
                $("#wilayah").val(wilayah).change();
                $("#divisi").val(divisi).change();
            }
            if (e01 == '1') {
                $('#penerimaid').val(penerima);
                loadpenerima1();
            }
            if (n01 == '1') {
                $("#nibruto").val(bruto).autoNumeric('set', bruto.replace(",", "."));
                $("#ninetto").val(netto).autoNumeric('set', netto.replace(",", "."));
            }
            if (b01 == '0') {
                $('#idproyek').val(id);
                $('#kodeproyek').val(kode);
                $('#namapaket').val(nama);
            } else {
                $('#idbeban').val(id);
                $('#kodebeban').val(kode);
                $('#namabeban').val(nama);
            }
            if (r01 == '1') {
                $('#idtipe').val(tipe);
                loadruas();
            }
            if (a01 == '1') loadanggaran();
            $('#modal-lampiran').modal('hide');
        })
    });
</script>
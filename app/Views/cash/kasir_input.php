<div onload="flashdata()"></div>

<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>

<!-- Page-body start -->
<div class="page-body">
    <form action="/<?= $menu; ?>/savedoc/<?= $idunik; ?>" id="myForm" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.header'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <?php $mintapilih = $induk['0']->pilihan;
                        $beban = ($mintapilih == 'proyek') ? $proyek1['0']->kode : (($mintapilih == 'camp') ? $camp1['0']->kode : (($mintapilih == 'alat') ? $alat1['0']->kode : (($mintapilih == 'tanah') ? $tanah1['0']->kode : '')));
                        $namabeban = ($mintapilih == 'proyek') ? $proyek1['0']->paket : (($mintapilih == 'camp') ? $camp1['0']->nama : (($mintapilih == 'alat') ? $alat1['0']->nama : (($mintapilih == 'tanah') ? $tanah1['0']->nama : ''))); ?>

                        <input type="hidden" class="form-control" id="idunik" name="idunik" value="<?= $idunik; ?>">
                        <input type="hidden" class="form-control" id="levsetuju" name="levsetuju" value="<?= $tuser['lev_setuju']; ?>">
                        <input type="hidden" class="form-control" id="iduser" name="iduser" value="<?= $tuser['id'] ?>">
                        <input type="hidden" class="form-control" id="xasal" name="xasal" value="<?= $induk['0']->asal; ?>">
                        <input type="hidden" class="form-control" id="xpilihan" name="xpilihan" value="<?= $induk['0']->pilihan; ?>">
                        <input type="hidden" class="form-control" id="vnilaidk" name="vnilaidk" value="<?= $sumkas['0']->debit - $sumkas['0']->kredit; ?>" />
                        <input type="hidden" class="form-control" id="vtotal" name="vtotal" value="<?= old('vtotal'); ?>" />

                        <div class="form-group row">
                            <label for="perusahaan" class="col-sm-1 col-form-label"><?= lang('app.perusahaan'); ?></label>
                            <div class="col-sm-11">
                                <select id="perusahaan" class="js-example-basic-single" name="perusahaan" disabled>
                                    <option><?= $perusahaan1['0']->kode . '&emsp;=>&emsp;' . $perusahaan1['0']->nama; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="wilayah" class="col-sm-1 col-form-label"><?= lang('app.wilayah'); ?></label>
                            <div class="col-sm-4">
                                <select id="wilayah" class="js-example-basic-single" name="wilayah" disabled>
                                    <option><?= $wilayah1['0']->nama; ?></option>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="divisi" class="col-sm-1 col-form-label"><?= lang('app.divisi'); ?></label>
                            <div class="col-sm-4">
                                <select id="divisi" class="js-example-basic-single" name="divisi" disabled>
                                    <option><?= $divisi1['0']->nama; ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.dokumen'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="userid" class="col-sm-1 col-form-label"><?= lang('app.peminta'); ?></label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="userid" name="userid" value="<?= $induk['0']->peminta; ?>">
                                    <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                </div>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="tanggal" class="col-sm-1 col-form-label"><?= lang('app.tanggal'); ?></label>
                            <div class="col-sm-2">
                                <input type="date" readonly class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d'); ?>">
                            </div>
                            <label for="norev" class="col-sm-1 col-form-label text-right"><?= lang('app.norev'); ?></label>
                            <div class="col-sm-1">
                                <input type="text" readonly class="form-control" id="norev" name="norev" value="<?= $induk['0']->norevisi; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pilihan" class="col-sm-1 col-form-label"><?= lang('app.pilihan'); ?></label>
                            <div class="col-sm-4">
                                <select id="pilihan" class="js-example-basic-single" name="pilihan" disabled>
                                    <option><?= lang('app.' . $induk['0']->pilihan); ?>
                                </select>
                            </div>
                            <div class="col-sm-2"></div>
                            <label for="nodoc" class="col-sm-1 col-form-label"><?= lang('app.nodoc'); ?></label>
                            <div class="col-sm-4">
                                <input type="text" readonly class="form-control" id="nodoc" name="nodoc" value="<?= $induk['0']->nodoc; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="beban" class="col-sm-1 col-form-label"><?= lang('app.cabang'); ?></label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="beban" name="beban" value="<?= $beban; ?>">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" readonly class="form-control" id="namabeban" name="namabeban" value="<?= $namabeban; ?>">
                                    <span class="input-group-addon"><i class="icofont icofont-link-alt" aria-hidden="true"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="penerima" class="col-sm-1 col-form-label"><?= lang('app.penerima'); ?></label>
                            <div class="col-sm-9">
                                <select id="penerima" class="js-example-basic-single" name="penerima" disabled>
                                    <option><?= $penerima1['0']->kode . ' => ' . $penerima1['0']->nama; ?></option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select id="alias" class="js-example-basic-single" name="alias" disabled>
                                    <option><?= lang('app.' . $induk['0']->alias); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->
                <div class="dt-responsive table-responsive tabelkas"></div>

                <div class="card">
                    <div class="card-header <?= lang('app.bgInput'); ?>">
                        <h5><?= lang('app.aksi'); ?></h5>
                        <div class="card-header-right">
                            <ul class="list-unstyled card-option">
                                <li><i class="feather icon-chevrons-down minimize-card"></i></li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-block mt-2">
                        <div class="form-group row">
                            <label for="kasbank" class="col-sm-1 col-form-label"><?= lang('app.kas') . " / " . lang('app.bank'); ?></label>
                            <div class="col-sm-6">
                                <select id="kasbank" class="js-example-basic-single" name="kasbank">
                                    <option value="" selected="true" disabled="disabled"><?= lang('app.pilih-'); ?></option>
                                    <?php foreach ($kelakun as $db) :
                                        echo "<option value='{$db->akun1_id}'" . ((old('kelakun') == $db->akun1_id) ? 'selected' : '') . ">{$db->nama}</option>";
                                    endforeach; ?>
                                </select>
                                <div id="error" class="invalid-feedback d-block"><?= $validation->geterror('kasbank'); ?></div>
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="nobg" class="col-sm-1 col-form-label"><?= lang('app.nobg'); ?>&emsp;</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="nobg" name="nobg">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="total" class="col-sm-1 col-form-label"><?= lang('app.total'); ?>&emsp;</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control form-control-right autonumber fontangkabesar <?= ($validation->hasError('vtotal')) ? 'is-invalid' : ''; ?>" data-a-sep="." data-a-dec="," id="total" name="total" placeholder="<?= lang('app.harusisi'); ?>" value="<?= old('total'); ?>" autocomplete="off" onchange="pembulatan()" />
                                <div class="invalid-feedback"><?= $validation->geterror('vtotal'); ?></div>
                            </div>
                            <div class="col-sm-3"></div>
                            <label for="bulat" class="col-sm-1 col-form-label"><?= lang('app.bulat'); ?>&emsp;</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control form-control-right autonumber" data-a-sep="." data-a-dec="," id="bulat" name="bulat" value="<?= old('bulat'); ?>" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan" class="col-sm-1 col-form-label"><?= lang('app.catatan'); ?></label>
                            <div class="col-sm-11">
                                <textarea class="form-control <?= ($validation->hasError('catatan')) ? 'is-invalid' : ''; ?>" harusisi rows="3" id="catatan" name="catatan" autocomplete="off"><?= old('catatan'); ?></textarea>
                                <div class="invalid-feedback"><?= $validation->geterror('catatan'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <div class="col-4"></div>
                            <div class="col-4 text-center"><button type="submit" class="btn <?= lang('app.btnSave'); ?>"><?= lang('app.btn_Save'); ?></button></div>
                            <div class="col-4"></div>
                        </div>
                    </div>
                </div><!-- Akhir card table-->
            </div>
        </div>

    </form>
</div><!-- body end -->
<div class="modallampiran" style="display: none;"></div>

<script>
    //pembulatan
    function pembulatan() {
        if (document.getElementById('total').value === '') document.getElementById('total').value = '0,00'
        if (document.getElementById('vnilaidk').value === '') document.getElementById('vnilaidk').value = '0,00'

        var total = formatKosong(document.getElementById('total').value);
        var dk = formatKosong(document.getElementById('vnilaidk').value);
        var bulat = parseFloat(dk) - parseFloat(total);
        document.getElementById('bulat').value = formatRupiah(bulat);
        document.getElementById('vtotal').value = parseFloat(total);
    }

    // panggil tabel minta
    function datamintakas() {
        var getIDU = $("#idunik").val();
        var getasal = $("#xasal").val();
        var getPilih = $("#xpilihan").val();

        if (getasal === 'kaslangsung' || getasal === 'kasnonlangsung') paksbex = '1110000';
        else if (getasal === 'kasum') paksbex = '0101100';
        else if (getasal === 'kaspindah') paksbex = '0000000';

        $.ajax({
            url: "/<?= $menu; ?>/tabkas",
            data: {
                idunik: getIDU,
                asal: getasal,
                pilih: getPilih,
                ed: '0',
                paksbex: paksbex,
            },
            dataType: "json",
            success: function(response) {
                $('.tabelkas').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }


    $(document).ready(function() {
        datamintakas();
    });
</script>

<?= $this->endSection(); ?>
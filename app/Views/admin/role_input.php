<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($role[0]->unique ?? '') ?>" />
                <input type="hidden" id="menu1" name="menu1" value="<?= ($role[0]->menu_1 ?? '') ?>" />
                <input type="hidden" id="menu2" name="menu2" value="<?= ($role[0]->menu_2 ?? '') ?>" />
                <input type="hidden" id="menu3" name="menu3" value="<?= ($role[0]->menu_3 ?? '') ?>" />
                <input type="hidden" id="menu4" name="menu4" value="<?= ($role[0]->menu_4 ?? '') ?>" />
                <input type="hidden" id="menu5" name="menu5" value="<?= ($role[0]->menu_5 ?? '') ?>" />
                <input type="hidden" id="menu6" name="menu6" value="<?= ($role[0]->menu_6 ?? '') ?>" />
                <input type="hidden" id="menu7" name="menu7" value="<?= ($role[0]->menu_7 ?? '') ?>" />
                <input type="hidden" id="menu8" name="menu8" value="<?= ($role[0]->menu_8 ?? '') ?>" />
                <input type="hidden" id="menu9" name="menu9" value="<?= ($role[0]->menu_9 ?? '') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>

                <div class="row g-2">
                    <div class="col-12 col-md-4 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="param" name="param" placeholder="" value="<?= lang('app.role')  ?>" />
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8">
                        <div class="form-floating form-floating-outline">
                            <input type="text" <?= (isset($role[0]) && $role[0]->adaptation[0] == '1') ? 'readonly' : '' ?> class="form-control" id="description" name="description" placeholder="<?= lang('app.required') ?>" value="<?= ($role[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($role[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($role[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($role[0]->activeBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 ms-auto text-end">
                        <div class="btn-group" id="dropdown-icon">
                            <button type="button" class="<?= json('btn submit') ?> btn-submit dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><?= json('submit') ?></button>
                            <ul class="dropdown-menu">
                                <li><button type="button" name="action" value="save" class="dropdown-item d-flex align-items-center btn-save" <?= $button['save'] ?>><?= lang('app.btn save') ?></button></li>
                                <li><button type="button" name="action" value="confirm" class="dropdown-item d-flex align-items-center btn-save" <?= $button['confirm'] ?>><?= lang('app.btn confirm') ?></button></li>
                                <li><button type="button" name="action" value="delete" class="dropdown-item d-flex align-items-center btn-save" <?= $button['delete'] ?>><?= lang('app.btn delete') ?></button></li>
                                <li><button type="button" name="action" value="active" class="dropdown-item d-flex align-items-center btn-save" <?= $button['active'] ?>><?= $btn_active ?></button></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card Footer -->
        </div> <!--/ Card -->
    </div> <!-- Col -->
</div> <!-- Row -->
<?= form_close() ?>

<div class="row">
    <!-- Main menu -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card mb-6">
            <div class="card-body tree-view pb-0">
                <h5 class="card-title"><?= lang('app.main data') ?></h5>
                <?php $menu1 = ($role[0]->menu_1 ?? '') ?>
                <div id="jstree-checkbox1">
                    <ul>
                        <li id="A01" data-jstree='{<?= (preg_match("/A01/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.administrator') ?>
                            <ul>
                                <li id="101" data-jstree='{"type":"file" <?= (preg_match("/101/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.database') ?></li>
                                <li id="102" data-jstree='{"type":"file" <?= (preg_match("/102/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.config') ?></li>
                                <li id="103" data-jstree='{"type":"file" <?= (preg_match("/103/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.role') ?></li>
                                <li id="A02" data-jstree='{<?= (preg_match("/A02/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.user') ?>
                                    <ul>
                                        <li id="104" data-jstree='{"type":"file" <?= (preg_match("/104/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.user') ?></li>
                                        <li id="105" data-jstree='{"type":"file" <?= (preg_match("/105/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.token') ?></li>
                                        <li id="106" data-jstree='{"type":"file" <?= (preg_match("/106/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.log user') ?></li>
                                        <li id="107" data-jstree='{"type":"file" <?= (preg_match("/107/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.reset password') ?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> <!-- End Administrator -->
                        <li id="A03" data-jstree='{<?= (preg_match("/A03/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.declaration') ?>
                            <ul>
                                <li id="108" data-jstree='{"type":"file" <?= (preg_match("/108/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.company') ?></li>
                                <li id="109" data-jstree='{"type":"file" <?= (preg_match("/109/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.region division') ?></li>
                                <li id="110" data-jstree='{"type":"file" <?= (preg_match("/110/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.child user') ?></li>
                                <li id="xA03" data-jstree='{"icon":"xx","disabled" : "true"}'><?= json('xLine') ?></li>
                                <li id="111" data-jstree='{"type":"file" <?= (preg_match("/111/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.unit') ?></li>
                                <li id="A04" data-jstree='{<?= (preg_match("/A04/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.project cost') ?>
                                    <ul>
                                        <li id="112" data-jstree='{"type":"file" <?= (preg_match("/112/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.project category') ?></li>
                                        <li id="113" data-jstree='{"type":"file" <?= (preg_match("/113/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.direct cost') ?></li>
                                        <li id="114" data-jstree='{"type":"file" <?= (preg_match("/114/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.indirect cost') ?></li>
                                        <li id="115" data-jstree='{"type":"file" <?= (preg_match("/115/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.resources') ?></li>
                                    </ul>
                                </li>
                                <li id="A05" data-jstree='{<?= (preg_match("/A05/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.formula') ?>
                                    <ul>
                                        <li id="116" data-jstree='{"type":"file" <?= (preg_match("/116/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.distance') ?></li>
                                        <li id="117" data-jstree='{"type":"file" <?= (preg_match("/117/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.tariff') ?></li>
                                        <li id="118" data-jstree='{"type":"file" <?= (preg_match("/118/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.job mix') ?></li>
                                    </ul>
                                </li>
                                <li id="xA03" data-jstree='{"icon":"xx","disabled" : "true"}'><?= json('xLine') ?></li>
                                <li id="119" data-jstree='{"type":"file" <?= (preg_match("/119/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.document') ?></li>
                                <li id="120" data-jstree='{"type":"file" <?= (preg_match("/120/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.default budget') ?></li>
                            </ul>
                        </li> <!-- End Declaration -->
                        <li id="A06" data-jstree='{<?= (preg_match("/A06/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.accounting') ?>
                            <ul>
                                <li id="121" data-jstree='{"type":"file" <?= (preg_match("/120/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.coa') ?></li>
                                <li id="122" data-jstree='{"type":"file" <?= (preg_match("/121/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.group account') ?></li>
                                <li id="123" data-jstree='{"type":"file" <?= (preg_match("/122/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.default account') ?></li>
                                <li id="124" data-jstree='{"type":"file" <?= (preg_match("/123/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.cash bank') ?></li>
                                <li id="125" data-jstree='{"type":"file" <?= (preg_match("/124/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.tax') ?></li>
                                <li id="xA06" data-jstree='{"icon":"xx","disabled" : "true"}'><?= json('xLine') ?></li>
                                <li id="126" data-jstree='{"type":"file" <?= (preg_match("/125/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.other') ?></li>
                            </ul>
                        </li> <!-- End Accounting -->
                        <li id="A07" data-jstree='{<?= (preg_match("/A07/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.branch asset') ?>
                            <ul>
                                <li id="127" data-jstree='{"type":"file" <?= (preg_match("/126/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.branch') ?></li>
                                <li id="A08" data-jstree='{<?= (preg_match("/A08/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.project') ?>
                                    <ul>
                                        <li id="128" data-jstree='{"type":"file" <?= (preg_match("/127/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.project') ?></li>
                                        <li id="129" data-jstree='{"type":"file" <?= (preg_match("/128/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.segment') ?></li>
                                        <li id="130" data-jstree='{"type":"file" <?= (preg_match("/129/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.sub segment') ?></li>
                                    </ul>
                                </li>
                                <li id="A09" data-jstree='{<?= (preg_match("/A09/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.equipment') ?>
                                    <ul>
                                        <li id="131" data-jstree='{"type":"file" <?= (preg_match("/130/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.equipment') ?></li>
                                        <li id="132" data-jstree='{"type":"file" <?= (preg_match("/131/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.tool') ?></li>
                                    </ul>
                                </li>
                                <li id="133" data-jstree='{"type":"file" <?= (preg_match("/132/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.land building') ?></li>
                                <li id="134" data-jstree='{"type":"file" <?= (preg_match("/133/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.inventory') ?></li>
                            </ul>
                        </li> <!-- End Branch Asset -->
                        <li id="A10" data-jstree='{<?= (preg_match("/A10/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.item') ?>
                            <ul>
                                <li id="135" data-jstree='{"type":"file" <?= (preg_match("/135/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.item') ?></li>
                                <li id="136" data-jstree='{"type":"file" <?= (preg_match("/136/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.material') ?></li>
                                <li id="xA10" data-jstree='{"icon":"xx","disabled" : "true"}'><?= json('xLine') ?></li>
                                <li id="137" data-jstree='{"type":"file" <?= (preg_match("/137/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.serial') ?></li>
                                <li id="138" data-jstree='{"type":"file" <?= (preg_match("/138/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.warehouse') ?></li>
                            </ul>
                        </li> <!-- End Item -->
                        <li id="A11" data-jstree='{<?= (preg_match("/A11/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.recipient') ?>
                            <ul>
                                <li id="139" data-jstree='{"type":"file" <?= (preg_match("/139/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.recipient') ?></li>
                                <li id="140" data-jstree='{"type":"file" <?= (preg_match("/140/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.partner vehicle') ?></li>
                                <li id="141" data-jstree='{"type":"file" <?= (preg_match("/141/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.link company') ?></li>
                            </ul>
                        </li> <!-- End Recipient -->
                        <li id="A12" data-jstree='{<?= (preg_match("/A12/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.human resources') ?>
                            <ul>
                                <li id="142" data-jstree='{"type":"file" <?= (preg_match("/142/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.days off') ?></li>
                                <li id="143" data-jstree='{"type":"file" <?= (preg_match("/143/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.calendar') ?></li>
                                <li id="144" data-jstree='{"type":"file" <?= (preg_match("/144/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.announcement') ?></li>
                                <li id="145" data-jstree='{"type":"file" <?= (preg_match("/145/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.rating category') ?></li>
                                <li id="xA12" data-jstree='{"icon":"xx","disabled" : "true"}'><?= json('xLine') ?></li>
                                <li id="A13" data-jstree='{<?= (preg_match("/A13/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.employee') ?>
                                    <ul>
                                        <li id="146" data-jstree='{"type":"file" <?= (preg_match("/146/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.employee') ?></li>
                                        <li id="147" data-jstree='{"type":"file" <?= (preg_match("/147/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.position class') ?></li>
                                    </ul>
                                </li>
                                <li id="A14" data-jstree='{<?= (preg_match("/A14/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.salary') ?>
                                    <ul>
                                        <li id="148" data-jstree='{"type":"file" <?= (preg_match("/148/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.salary attribute') ?></li>
                                        <li id="149" data-jstree='{"type":"file" <?= (preg_match("/149/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.salary') ?></li>
                                    </ul>
                                </li>
                                <li id="A15" data-jstree='{<?= (preg_match("/A15/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.numbering') ?>
                                    <ul>
                                        <li id="150" data-jstree='{"type":"file" <?= (preg_match("/150/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.document code') ?></li>
                                        <li id="151" data-jstree='{"type":"file" <?= (preg_match("/151/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.form number') ?></li>
                                    </ul>
                                </li>
                            </ul>
                        </li> <!-- End Human Resources -->
                    </ul>
                </div>
            </div> <!-- Card Body -->
        </div> <!-- Card -->
    </div> <!-- Col -->

    <!-- General Transaction -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card mb-6">
            <div class="card-body tree-view pb-0">
                <h5 class="card-title"><?= lang('app.data utama') ?></h5>

                <?php $menu1 = ($role[0]->menu_1 ?? '') ?>
                <div id="jstree-checkbox2">
                    <ul>
                        <li id="A01" data-jstree='{<?= (preg_match("/A01/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.deklarasi') ?>
                            <ul>
                                <li id="101" data-jstree='{"type":"file" <?= (preg_match("/101/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.perusahaan') ?></li>
                                <li id="102" data-jstree='{"type":"file" <?= (preg_match("/102/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.wilayah divisi') ?></li>
                                <li id="103" data-jstree='{"type":"file" <?= (preg_match("/103/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.user anak') ?></li>
                                <li id="xA01" data-jstree='{"icon":"xx","disabled" : "true"}'><?= json('xgaris') ?></li>
                                <li id="104" data-jstree='{"type":"file" <?= (preg_match("/104/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.satuan') ?></li>
                                <li id="105" data-jstree='{"type":"file" <?= (preg_match("/105/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.dokumen') ?></li>
                                <li id="A02" data-jstree='{<?= (preg_match("/A02/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.penomoran') ?>
                                    <ul>
                                        <li id="106" data-jstree='{"type":"file" <?= (preg_match("/106/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.kode dokumen') ?></li>
                                        <li id="107" data-jstree='{"type":"file" <?= (preg_match("/107/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.kode form') ?></li>
                                    </ul>
                                </li>
                                <li id="A03" data-jstree='{<?= (preg_match("/A03/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.biaya proyek') ?>
                                    <ul>
                                        <li id="108" data-jstree='{"type":"file" <?= (preg_match("/108/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.kategori proyek') ?></li>
                                        <li id="109" data-jstree='{"type":"file" <?= (preg_match("/109/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.biaya langsung') ?></li>
                                        <li id="110" data-jstree='{"type":"file" <?= (preg_match("/110/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.biaya taklangsung') ?></li>
                                        <li id="111" data-jstree='{"type":"file" <?= (preg_match("/111/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.sumber daya') ?></li>
                                    </ul>
                                </li>
                                <li id="A04" data-jstree='{<?= (preg_match("/A04/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.rumus') ?>
                                    <ul>
                                        <li id="112" data-jstree='{"type":"file" <?= (preg_match("/112/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.jarak') ?></li>
                                        <li id="113" data-jstree='{"type":"file" <?= (preg_match("/113/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.tarif') ?></li>
                                        <li id="114" data-jstree='{"type":"file" <?= (preg_match("/114/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.jobmix') ?></li>
                                    </ul>
                                </li>
                                <li id="115" data-jstree='{"type":"file" <?= (preg_match("/115/i", $menu1)) ? ',"selected":"true"' : '' ?>}'><?= lang('app.anggaran bawaan') ?></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div> <!-- Card Body -->
        </div> <!-- Card -->
    </div> <!-- Col -->
</div> <!-- Row -->

<script>
    handleJsTree('#jstree-checkbox1', '#menu1');
    handleJsTree('#jstree-checkbox2', '#menu2');

    function handleJsTree(treeId, menuId) {
        $(treeId).on("changed.jstree", function(e, data) {
            var selected = [];
            for (var i = 0; i < data.selected.length; i++) {
                selected = selected.concat($(treeId).jstree(true).get_path(data.selected[i], false, true));
                // var node = $(treeId).jstree(true).get_node(data.selected[i]);
            }
            selected = [...new Set(selected)];
            $(menuId).val(selected.join(','));
        });
    }

    $('.btn-save').click(function(e) {
        e.preventDefault(); // Stop  default action form
        var getAction = $(this).val(); // get value button

        if (getAction === 'delete') {
            deleteConfirmation("<?= lang('app.sure') ?>").then((result) => {
                if (result.isConfirmed) {
                    submitForm(getAction);
                } else {
                    return;
                }
            });
        } else {
            submitForm(getAction);
        }
    })

    function submitForm(getAction) {
        var form = $('.form-main')[0];
        var formData = new FormData(form);
        var url = '<?= $link ?>/save';
        formData.append('postAction', getAction);

        $.ajax({
            type: 'post',
            url: url,
            data: formData,
            cache: false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function() {
                $('.btn-submit').attr('disabled', 'disabled');
                $('.btn-submit').html('<i class="ri-loader-5-line ri-spin ri-24px"></i>');
            },
            complete: function() {
                $('.btn-submit').removeAttr('disabled');
                $('.btn-submit').each(function() {
                    $(this).html('<?= json('submit') ?>');
                });
            },
            success: function(response) {
                $('#askDelete, #description').removeClass('is-invalid');
                $('.err_askDelete, .err_description').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('description', response.error.description);
                } else {
                    window.location.href = response.redirect;
                }

                function handleFieldError(field, error) {
                    if (error) {
                        $('#' + field).addClass('is-invalid');
                        $('.err_' + field).html(error);
                    } else {
                        $('#' + field).removeClass('is-invalid');
                    }
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
        return false;
    }
</script>

<?= $this->endSection() ?>
<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= ($employee[0]->unique ?? '') ?>" />
                <input type="hidden" name="pictureName" value="<?= ($employee[0]->picture ?? 'default.png') ?>" />
                <input type="hidden" id="askDelete" name="askDelete" />
                <div id="error" class="invalid-feedback alert alert-danger err_askDelete" role="alert"></div>
                <div class="row g-2">
                    <div class="col-12 col-md-7 col-lg-7 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control text-uppercase" id="code" name="code" <?= (isset($employee[0]->adaptation[0]) && $employee[0]->adaptation[0] == '1' ? 'readonly' : '') ?> placeholder="<?= lang('app.required') ?>" maxlength="16" value="<?= ($employee[0]->code ?? '') ?>" />
                            <label for="code"><?= lang('app.code') ?></label>
                            <div id="error" class="invalid-feedback err_code"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-5 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control eid" id="eid" name="eid" <?= ((isset($employee[0]->adaptation[0]) && $employee[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($employee[0]->eid ?? '') ?>" data-mask="99.99.9999" />
                            <label for="eid"><?= lang('app.eid+') ?></label>
                            <div id="error" class="invalid-feedback err_eid"></div>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="description" name="description" <?= ((isset($employee[0]->adaptation[0]) && $employee[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'readonly') : '') ?> placeholder="<?= lang('app.required') ?>" value="<?= ($employee[0]->name ?? '') ?>" />
                            <label for="description"><?= lang('app.description') ?></label>
                            <div id="error" class="invalid-feedback err_description"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="birthPlace" name="birthPlace" placeholder="" value="<?= ($employee[0]->birth_place ?? '') ?>" />
                            <label for="birthPlace"><?= lang('app.birth place') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="birthDate" name="birthDate" value="<?= ($employee[0]->birth_date ?? '') ?>" />
                            <label for="birthDate"><?= lang('app.birth date') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?= ($employee[0]->email ?? '') ?>" />
                            <label for="email"><?= lang('app.email') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="gender" name="gender">
                                <option value="male" <?= (isset($employee[0]->gender) && $employee[0]->gender == 'male' ? 'selected' : '') ?>><?= lang('app.male') ?></option>
                                <option value="female" <?= (isset($employee[0]->gender) && $employee[0]->gender == 'female' ? 'selected' : '') ?>><?= lang('app.female') ?></option>
                            </select>
                            <label for="gender"><?= lang('app.gender') ?></label>
                        </div>
                    </div>
                    <div class="col-6 col-md-3 col-lg-2 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="blood" name="blood" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($employee[0]->blood) && $employee[0]->blood == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectBlood as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($employee[0]->blood) && $employee[0]->blood == $db->name ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="blood"><?= lang('app.blood') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="address" name="address" placeholder=""><?= ($employee[0]->address ?? '') ?></textarea>
                            <label for="address"><?= lang('app.address') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="contact" name="contact" placeholder=""><?= ($employee[0]->contact ?? '') ?></textarea>
                            <label for="contact"><?= lang('app.contact') ?></label>
                        </div>
                    </div>
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="branch" name="branch" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($branch1) : ?> <option value="<?= $branch1[0]->id ?>" selected data-subtext="<?= $branch1[0]->name ?>"><?= $branch1[0]->code ?></option><?php endif ?>
                            </select>
                            <label for="branch"><?= lang('app.branch') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-8 col-lg-8 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="location" name="location" placeholder="" value="<?= ($employee[0]->location ?? '') ?>" />
                            <label for="location"><?= lang('app.location') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <input type="checkbox" id="osm" name="osm" data-toggle="toggle" data-width="100%" <?= (isset($employee[0]->is_alias) && $employee[0]->is_alias[4] == '1' ? 'checked' : '') ?> data-onlabel="<?= lang('app.osm') ?>" data-offlabel="<?= lang('app.osm') ?>" data-onstyle="primary" />
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card init -->
    </div> <!--/ Column left -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <img class="img-fluid img-preview" src="/assets/picture/employee/<?= ($employee ? $employee[0]->picture : 'default.png') ?>">
                    </div>
                    <div class="col-12 mb-2">
                        <input type="file" class="form-control" id="picture" name="picture" onchange="previewImage()" />
                        <div id="error" class="invalid-feedback err_picture"></div>
                    </div>
                    <span><?= ($employee[0]->picture ?? '') ?></span>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card picture -->
    </div> <!--/ Column right -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="licenseType" name="licenseType" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($employee[0]->license_type) && $employee[0]->license_type == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectGroupSIM as $db1) : ?>
                                    <optgroup label="<?= $db1->group ?>">
                                        <?php foreach ($selectSIM as $db) : ?>
                                            <?php if ($db->group == $db1->group) : ?> <option value="<?= $db->name ?>" <?= (isset($employee[0]->license_type) && $employee[0]->license_type == $db->name ? 'selected' : '') ?>><?= $db->name ?></option><?php endif ?>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <label for="licenseType"><?= lang('app.license driver') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="licenseDate" name="licenseDate" value="<?= ($employee[0]->license_date ?? '') ?>" />
                            <label for="licenseDate"><?= lang('app.license date') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control" id="licenseNumber" name="licenseNumber" placeholder="" value="<?= ($employee[0]->license_number ?? '') ?>" />
                            <label for="licenseNumber"><?= lang('app.license number') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card identity -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="employeeStatus" name="employeeStatus">
                                <?php foreach ($selectEmployeeStatus as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($employee[0]->employee_st) && $employee[0]->employee_st == $db->name ? 'selected' : '') ?> data-subtext="<?= $db->group ?>"><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="EmployeeStatus"><?= lang('app.employee status') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="ptkp" name="ptkp" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($employee[0]->worker) && $employee[0]->worker == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectGroupPTKP as $db1) : ?>
                                    <optgroup label="<?= $db1->group ?>">
                                        <?php foreach ($selectPTKP as $db) : ?>
                                            <?php if ($db->group == $db1->group) : ?> <option value="<?= $db->name ?>" <?= (($employee && $employee[0]->worker == $db->name) ? 'selected' : '') ?>><?= $db->name ?></option><?php endif ?>
                                        <?php endforeach ?>
                                    </optgroup>
                                <?php endforeach ?>
                            </select>
                            <label for="ptkp">PTKP</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="joinDate" name="joinDate" value="<?= ($employee[0]->join_date ?? '') ?>" />
                            <label for="joinDate"><?= lang('app.join date') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="contractDate1" name="contractDate1" value="<?= ($employee[0]->contract_date_1 ?? '') ?>" />
                            <label for="contractDate1"><?= lang('app.start contract') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="contractDate2" name="contractDate2" value="<?= ($employee[0]->contract_date_2 ?? '') ?>" />
                            <label for="contractDate2"><?= lang('app.end contract') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card contract -->
    </div> <!--/ Column left -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="diploma" name="diploma" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($employee[0]->diploma) && $employee[0]->diploma == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectDiploma as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($employee[0]->diploma) && $employee[0]->diploma == $db->name ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="diploma"><?= lang('app.diploma') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-tokenizer form-select" id="major" name="major" data-allow-clear="true" data-placeholder="<?= lang('app.selectCreate') ?>">
                                <option value="" <?= (isset($employee[0]->major) && $employee[0]->major == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectMajor as $db) : ?>
                                    <option value="<?= $db->major ?>" <?= (isset($employee[0]->major) && $employee[0]->major == $db->major ? 'selected' : '') ?>><?= $db->major ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="major"><?= lang('app.major') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="diplomaStatus" name="diplomaStatus" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($employee[0]->diplomaStatus) && $employee[0]->diplomaStatus == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectDiplomaStatus as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($employee[0]->diploma_st) && $employee[0]->diploma_st == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="diplomaStatus"><?= lang('app.diploma status') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="diplomaDate" name="diplomaDate" value="<?= ($employee[0]->diploma_date ?? '') ?>" />
                            <label for="diplomaDate"><?= lang('app.date') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card certificate -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="outSelect" name="outSelect" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($employee[0]->out_select) && $employee[0]->out_select == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($selectOut as $db) : ?>
                                    <option value="<?= $db->name ?>" <?= (isset($employee[0]->out_select) && $employee[0]->out_select == $db->name ? 'selected' : '') ?>><?= lang('app.' . $db->name) ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="outSelect"><?= lang('app.out company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="date" class="form-control" id="outDate" name="outDate" value="<?= ($employee[0]->out_date ?? '') ?>" />
                            <label for="outDate"><?= lang('app.date') ?></label>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="outReason" name="outReason" placeholder=""><?= ($employee[0]->out_reason ?? '') ?></textarea>
                            <label for="outReason"><?= lang('app.reason') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card out company -->
    </div> <!--/ Column center -->

    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="company" name="company" <?= (isset($employee[0]->adaptation[0]) && $employee[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($company as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($employee[0]->company_id) && $employee[0]->company_id == $db->id ? 'selected' : '') ?> data-subtext="<?= $db->name ?>"><?= $db->code ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="company"><?= lang('app.company') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="region" name="region" <?= ((isset($employee[0]->adaptation[0]) && $employee[0]->adaptation[0] == '1') ? (thisUser()['act_access'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php foreach ($region as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($employee[0]->region_id) && $employee[0]->region_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="region"><?= lang('app.region') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="division" name="division" <?= (isset($employee[0]->adaptation[0]) && $employee[0]->adaptation[0] == '1' ? 'disabled' : '') ?>>
                                <?php foreach ($division as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($employee[0]->division_id) && $employee[0]->division_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="division"><?= lang('app.division') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card company -->

        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="username" name="username" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($user1) : ?><option value="<?= $user1[0]->id ?>" selected><?= $user1[0]->code ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_username"></div>
                            <label for="username"><?= lang('app.username') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="supervisor" name="supervisor" data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($supervisor1) : ?><option value="<?= $supervisor1[0]->code ?>" selected data-subtext="<?= $supervisor1[0]->name ?>"><?= $supervisor1[0]->code ?></option><?php endif ?>
                            </select>
                            <div id="error" class="invalid-feedback err_supervisor"></div>
                            <label for="supervisor"><?= lang('app.supervisor') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card user-->
    </div> <!--/ Column right -->
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="groupAccount" name="groupAccount">
                                <?php foreach ($selectGroup as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($employee[0]->group_account_employee) && $employee[0]->group_account_employee == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="groupAccount"><?= lang('app.group account') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="salary" name="salary" <?= (isset($employee[0]->adaptation[0]) && $employee[0]->adaptation[0] == '1' ? (thisUser()['act_access'][8] == '1' ? '' : 'disabled') : '') ?>>
                                <?php foreach ($salary as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($employee[0]->salary_id) && $employee[0]->salary_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="salary"><?= lang('app.salary group') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="position" name="position">
                                <?php foreach ($position as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($employee[0]->position_id) && $employee[0]->position_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="position"><?= lang('app.position') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="class" name="class">
                                <?php foreach ($class as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= (isset($employee[0]->class_id) && $employee[0]->class_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="class"><?= lang('app.class') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="insurance" name="insurance" placeholder=""><?= ($employee[0]->insurance ?? '') ?></textarea>
                            <label for="insurance"><?= lang('app.insurance') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <textarea class="form-control h-px-100" id="notes" name="notes" placeholder=""><?= ($employee[0]->notes ?? '') ?></textarea>
                            <label for="notes"><?= lang('app.notes') ?></label>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($employee[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($employee[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-4">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($employee[0]->activeBy ?? '') ?></div>
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
        </div> <!--/ End Card -->
    </div>
</div> <!--/ Row-->

<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="card-header pb-0 mb-4">
                <div class="d-flex justify-content-between align-items-center row py-0 gap-3 gap-md-0">
                    <div class="col-4 col-md-9 col-lg-10">
                        <button type="button" class="<?= json('btn create') ?> input-attachment <?= ($employee ? '' : 'disabled') ?>" <?= (thisUser()['act_button'][0] == '0' ? 'disabled' : '') ?>><?= lang('app.btn add') ?></button>
                    </div>
                </div>
                <div id="alertContainer4" class="mt-2"></div>
            </div><!--/ Card Header -->
            <div class="card-datatable table-responsive viewTable4"></div>
        </div><!--/ Card -->
    </div><!--/ Col -->
</div><!--/ Row -->
<?= form_close() ?>
<div class="modal-input" style="display: none;"></div>

<script>
    $(document).ready(function() {
        callAttachment();
        $('#branch').select2({
            ajax: {
                url: "/load/branch",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });

        $('#username').select2({
            ajax: {
                url: "/load/user",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        employee: '',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
        });

        $('#supervisor').select2({
            ajax: {
                url: "/load/person",
                type: "POST",
                dataType: "json",
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        choose: '00010',
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            },
            <?= json('min input') ?>,
            <?= json('template 1') ?>,
            <?= json('template 2') ?>,
        });
    });

    $('.btn-save').click(function(e) {
        e.preventDefault();
        var getAction = $(this).val();
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
            type: 'POST',
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
                $('#askDelete, #code, #eid, #description, #picture, #username, #supervisor').removeClass('is-invalid');
                $('.err_askDelete, .err_code, .err_eid, .err_description, .err_picture, .err_username, .err_supervisor').html('');
                if (response.error) {
                    handleFieldError('askDelete', response.error.askDelete);
                    handleFieldError('code', response.error.code);
                    handleFieldError('eid', response.error.eid);
                    handleFieldError('description', response.error.description);
                    handleFieldError('picture', response.error.picture);
                    handleFieldError('username', response.error.username);
                    handleFieldError('supervisor', response.error.supervisor);
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

    $('.input-attachment').click(function(e) {
        e.preventDefault();
        var getUnique = $('#unique').val();
        $.ajax({
            url: "/attachment/modal",
            data: {
                unique: getUnique,
                object: 'employee',
                ska: '1',
            },
            dataType: "json",
            success: function(response) {
                $('.modal-input').html(response.data).show();
                $('#modal-input').modal('show')
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    })

    function callAttachment() {
        var getUnique = $("#unique").val();
        $.ajax({
            url: "/attachment/table",
            data: {
                unique: getUnique,
                object: 'employee',
                table: 'm_person',
            },
            dataType: "json",
            success: function(response) {
                $('.viewTable4').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText);
                alert(thrownError);
            }
        });
    }
</script>

<?= $this->endSection() ?>
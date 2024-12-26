<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<?= form_open('', ['class' => 'form-main']) ?>
<?= csrf_field() ?>
<div class="row">
    <!-- username & limit -->
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card mb-6">
            <div class="card-body">
                <input type="hidden" id="unique" name="unique" value="<?= $user[0]->unique ?>" />
                <div class="row g-2">
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="username" name="username" value="<?= $user[0]->code ?>" />
                            <label for="username"><?= lang('app.username') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <input type="text" readonly class="form-control" id="person" name="person" value="<?= ($token[0]->person ?? '') ?>" />
                            <label for="person"><?= lang('app.person') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="role" name="role" data-allow-clear="true" data-placeholder="<?= lang('app.select-') ?>">
                                <option value="" <?= (isset($user[0]->role_id) && $user[0]->role_id == '' ? 'selected' : '') ?>></option>
                                <?php foreach ($role as $db) : ?>
                                    <option value="<?= $db->id ?>" <?= ($user && $user[0]->role_id == $db->id ? 'selected' : '') ?>><?= $db->name ?></option>
                                <?php endforeach ?>
                            </select>
                            <label for="role"><?= lang('app.role') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-non form-select" id="supervisor" name="supervisor" <?= ($link == '/auser' ? 'disabled' : '') ?> data-allow-clear="true" data-placeholder="<?= lang('app.selectSearch') ?>">
                                <?php if ($supervisor) : ?><option value="<?= $supervisor[0]->id ?>" selected><?= "{$supervisor[0]->code}" ?></option><?php endif ?>
                            </select>
                            <label for="supervisor"><?= lang('app.supervisor') ?></label>
                            <div id="error" class="invalid-feedback err_supervisor"></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 mb-2">
                        <div class="form-floating form-floating-outline">
                            <select class="select2-subtext form-select" id="approve" name="approve">
                                <?php for ($i = 0; $i <= $this_level; $i++) : ?>
                                    <?php $description = ($i == '1' ? ' (' . lang('app.high') . ')' : ($i == $this_level ? ' (' . lang('app.low') . ')' : '')) ?>
                                    <option value="<?= $i ?>" <?= ($user[0]->act_approve == $i ? 'selected' : '') . ($i == '0' ? '' : ($link == '/auser' ? ($supervisor[0]->act_approve == '0' ? 'disabled' : ($supervisor[0]->act_approve <= $i ?  '' : 'disabled')) : '')) ?> data-subtext="Level <?= $i . $description ?>"><?= $i ?></option>
                                <?php endfor ?>
                                <option disabled data-subtext="">-------------------------------------------</option>
                                <option value="101" <?= ($user[0]->act_approve == '101' ? 'selected' : '') . ($link == '/auser' ? ($supervisor[0]->act_approve >= '100' ? '' : 'disabled') : '') ?> data-subtext=""><?= lang('app.finance') ?></option>
                                <option value="102" <?= ($user[0]->act_approve == '102' ? 'selected' : '') . ($link == '/auser' ? ($supervisor[0]->act_approve >= '100' ? '' : 'disabled') : '') ?> data-subtext=""><?= lang('app.inspector') ?></option>
                            </select>
                            <label for="approve"><?= lang('app.approve') ?></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-floating form-floating-outline">
                            <input type="text" class="form-control autonumber" data-a-sep="." data-a-dec="," id="limit" name="limit" placeholder="<?= lang('app.limit') ?>" value="<?= $user[0]->act_limit ?>" />
                            <label for="limit"><?= lang('app.limit') ?></label>
                            <div id="error" class="invalid-feedback err_limit"></div>
                        </div>
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card init -->

        <!-- checkbox all or select -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="company" name="company" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[0] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[0] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.company') ?> (1)" data-offlabel="<?= lang('app.company') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="region" name="region" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[1] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[1] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.region') ?> (1)" data-offlabel="<?= lang('app.region') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="division" name="division" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[2] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[2] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.division') ?> (1)" data-offlabel="<?= lang('app.division') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="salary" name="salary" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[3] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[3] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.salary group') ?> (1)" data-offlabel="<?= lang('app.salary group') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="project" name="project" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[4] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[4] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.project') ?> (1)" data-offlabel="<?= lang('app.project') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="branch" name="branch" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[5] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[5] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.branch') ?> (1)" data-offlabel="<?= lang('app.branch') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="tool" name="tool" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[6] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[6] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.equipment tool') ?> (1)" data-offlabel="<?= lang('app.equipment tool') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                    <div class="col-6 col-md-3 col-lg-3">
                        <input type="checkbox" id="land" name="land" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[7] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[7] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.land building') ?> (1)" data-offlabel="<?= lang('app.land building') ?> (0)" data-onstyle="primary" data-offstyle="warning" />
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card -->
    </div> <!--/ Column right -->

    <!-- action button for main menu -->
    <div class="col-12 col-md-12 col-lg-4">
        <div class="card mb-6">
            <div class="card-header">
                <h6 class="card-title mb-0"><?= lang('app.action') ?></h6>
            </div>

            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="create" name="create" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[0] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_button[0] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn make') ?>" data-offlabel="<?= lang('app.btn make') ?>" data-onstyle="primary" />
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="read" name="read" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[1] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_button[1] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn read') ?>" data-offlabel="<?= lang('app.btn read') ?>" data-onstyle="info" />
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="edit" name="edit" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[2] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_button[2] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn edit') ?>" data-offlabel="<?= lang('app.btn edit') ?>" data-onstyle="warning" />
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="delete" name="delete" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[3] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_button[3] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn delete') ?>" data-offlabel="<?= lang('app.btn delete') ?>" data-onstyle="danger" />
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="confirm" name="confirm" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[4] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_button[4] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn confirm') ?>" data-offlabel="<?= lang('app.btn confirm') ?>" data-onstyle="success" />
                    </div>
                    <div class="col-6 col-md-4 col-lg-6">
                        <input type="checkbox" id="active" name="active" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_button[5] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_button[5] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.btn active') ?>" data-offlabel="<?= lang('app.btn active') ?>" data-onstyle="light" />
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card action -->

        <!-- additional -->
        <div class="card mb-6">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6 col-md-4 col-lg-12">
                        <input type="checkbox" id="super" name="super" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[8] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[8] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.super+') ?>" data-offlabel="<?= lang('app.super+') ?>" data-onstyle="danger" />
                    </div>
                    <div class="col-6 col-md-4 col-lg-12">
                        <input type="checkbox" id="saring" name="saring" data-toggle="toggle" data-width="100%" <?= ($user[0]->act_access[9] == '1' ? 'checked' : '') . ($link == '/auser' && $supervisor[0]->act_access[9] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.saring+') ?>" data-offlabel="<?= lang('app.saring+') ?>" data-onstyle="danger" />
                    </div>
                </div>
            </div> <!--/ Card body  -->
        </div> <!--/ Card -->
    </div> <!--/ Column -->
</div> <!--/ Row-->

<div class="row">
    <!-- tab for selection -->
    <div class="col-12">
        <div class="card">
            <div class="card-header p-2">
                <div class="nav-align-top">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-company" aria-controls="navs-top-company" aria-selected="true"><?= lang('app.company') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-region" aria-controls="navs-top-region" aria-selected="false"><?= lang('app.region') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-division" aria-controls="navs-top-division" aria-selected="false"><?= lang('app.division') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-salary" aria-controls="navs-top-salary" aria-selected="false"><?= lang('app.salary group') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-project" aria-controls="navs-top-project" aria-selected="true"><?= lang('app.project') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-branch" aria-controls="navs-top-branch" aria-selected="false"><?= lang('app.branch') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-tool" aria-controls="navs-top-tool" aria-selected="false"><?= lang('app.equipment tool') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-land" aria-controls="navs-top-land" aria-selected="false"><?= lang('app.land building') ?></button></li>
                        <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-cash" aria-controls="navs-top-cash" aria-selected="false"><?= lang('app.cash bank') ?></button></li>
                    </ul>
                </div>
            </div> <!-- title header tab -->

            <div class="card-body mb-6">
                <div class="tab-content p-2">
                    <div class="tab-pane fade show active" id="navs-top-company" role="tabpanel">
                        <div class="row w-100">
                            <?php $nCompany = (explode(",", trim($user[0]->company, ',')))  ?>
                            <ul class="list-group">
                                <?php foreach ($company as $index => $db) :
                                    $condition = '';
                                    $nCek = '0';
                                    foreach ($nCompany as $field) {
                                        list($nid, $nStatus) = array_pad(explode(":", trim($field)), 2, '0'); // Set value default ke '0' if null
                                        // list($nid, $nStatus) = explode(":", trim($field));
                                        if ($nid == $db->id) {
                                            $condition = 'checked';
                                            $nCek = $nStatus;
                                            break;
                                        }
                                    } ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="companyBox_<?= $db->id ?>" name="listCompany[]" value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[0] == '0' ? (preg_match("/(^|,)" . $db->id . "(:|$)/i", $supervisor[0]->company) ? '' : 'disabled') : '') : '')) ?> />
                                            <label class="form-check-label" for="companyBox_<?= $db->id ?>"><?= $db->code . '&emsp;' . $db->name ?></label>
                                        </div>
                                        <div class="new-size">
                                            <input type="checkbox" data-toggle="toggle" id="company_<?= $db->id ?>" name="company_<?= $db->id ?>" <?= ($nCek == '1' ? 'checked' : '') ?> <?= ($link == '/auser' && preg_match("/(^|,)" . $db->id . ":(0|1)(,|$)/i", $supervisor[0]->company, $matches) && $matches[2] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.all access') ?>" data-offlabel="<?= lang('app.read') ?>" data-onstyle="success" data-offstyle="info" />
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-region" role="tabpanel">
                        <div class="row w-100">
                            <?php $nRegion = (explode(",", trim($user[0]->region, ',')))  ?>
                            <ul class="list-group">
                                <?php foreach ($region as $index => $db) :
                                    $condition = '';
                                    $nCek = '0';
                                    foreach ($nRegion as $field) {
                                        list($nid, $nStatus) = array_pad(explode(":", trim($field)), 2, '0');
                                        if ($nid == $db->id) {
                                            $condition = 'checked';
                                            $nCek = $nStatus;
                                            break;
                                        }
                                    } ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="regionBox_<?= $db->id ?>" name="listRegion[]" value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[1] == '0' ? (preg_match("/(^|,)" . $db->id . "(:|$)/i", $supervisor[0]->region) ? '' : 'disabled') : '') : '')) ?> />
                                            <label class="form-check-label" for="regionBox_<?= $db->id ?>"><?= $db->name ?></label>
                                        </div>
                                        <div class="new-size">
                                            <input type="checkbox" data-toggle="toggle" id="region_<?= $db->id ?>" name="region_<?= $db->id ?>" <?= ($nCek == '1' ? 'checked' : '') ?> <?= ($link == '/auser' && preg_match("/(^|,)" . $db->id . ":(0|1)(,|$)/i", $supervisor[0]->region, $matches) && $matches[2] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.all access') ?>" data-offlabel="<?= lang('app.read') ?>" data-onstyle="success" data-offstyle="info" />
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-division" role="tabpanel">
                        <div class="row w-100">
                            <?php $nDivision = (explode(",", trim($user[0]->division, ',')))  ?>
                            <ul class="list-group">
                                <?php foreach ($division as $index => $db) :
                                    $condition = '';
                                    $nCek = '0';
                                    foreach ($nDivision as $field) {
                                        list($nid, $nStatus) = array_pad(explode(":", trim($field)), 2, '0');
                                        if ($nid == $db->id) {
                                            $condition = 'checked';
                                            $nCek = $nStatus;
                                            break;
                                        }
                                    } ?>
                                    <li class="list-group-item d-flex align-items-center justify-content-between">
                                        <div class="form-check form-check-primary">
                                            <input class="form-check-input" type="checkbox" id="divisionBox_<?= $db->id ?>" name="listDivision[]" value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[2] == '0' ? (preg_match("/(^|,)" . $db->id . "(:|$)/i", $supervisor[0]->division) ? '' : 'disabled') : '') : '')) ?> />
                                            <label class="form-check-label" for="divisionBox_<?= $db->id ?>"><?= $db->name ?></label>
                                        </div>
                                        <div class="new-size">
                                            <input type="checkbox" data-toggle="toggle" id="division_<?= $db->id ?>" name="division_<?= $db->id ?>" <?= ($nCek == '1' ? 'checked' : '') ?> <?= ($link == '/auser' && preg_match("/(^|,)" . $db->id . ":(0|1)(,|$)/i", $supervisor[0]->division, $matches) && $matches[2] == '0' ? 'disabled' : '') ?> data-onlabel="<?= lang('app.all access') ?>" data-offlabel="<?= lang('app.read') ?>" data-onstyle="success" data-offstyle="info" />
                                        </div>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-salary" role="tabpanel">
                        <div class="row w-100">
                            <?php $nSalary = (explode(",", $user[0]->salary)) ?>
                            <select id="listSalary" class="searchable" multiple="multiple" name="listSalary[]">
                                <?php foreach ($salary as $db) : $condition = '';
                                    foreach ($nSalary as $field) if ($field == $db->id) $condition = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[3] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $supervisor[0]->salary) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->name}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-project" role="tabpanel">
                        <div class="row w-100">
                            <?php $nProject = (explode(",", $user[0]->project)) ?>
                            <select id="listProject" class="searchable" multiple="multiple" name="listProject[]">
                                <?php foreach ($project as $db) : $condition = '';
                                    foreach ($nProject as $field) if ($field == $db->id) $condition = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[4] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $supervisor[0]->project) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->code} &emsp; {$db->package_name}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-branch" role="tabpanel">
                        <div class="row w-100">
                            <?php $nBranch = (explode(",", $user[0]->branch)) ?>
                            <select id="listBranch" class="searchable" multiple="multiple" name="listBranch[]">
                                <?php foreach ($branch as $db) : $condition = '';
                                    foreach ($nBranch as $field) if ($field == $db->id) $condition = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[5] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $supervisor[0]->branch) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->code} &emsp; {$db->name}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-tool" role="tabpanel">
                        <div class="row w-100">
                            <?php $nTool = (explode(",", $user[0]->tool)) ?>
                            <select id="listTool" class="searchable" multiple="multiple" name="listTool[]">
                                <?php foreach ($tool as $db) : $condition = '';
                                    foreach ($nTool as $field) if ($field == $db->id) $condition = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[6] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $supervisor[0]->tool) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->code} &emsp; {$db->name}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-land" role="tabpanel">
                        <div class="row w-100">
                            <?php $nLand = (explode(",", $user[0]->land)) ?>
                            <select id="listLand" class="searchable" multiple="multiple" name="listLand[]">
                                <?php foreach ($land as $db) : $condition = '';
                                    foreach ($nLand as $field) if ($field == $db->id) $condition = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[7] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $supervisor[0]->land) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->code} &emsp; {$db->name}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-top-cash" role="tabpanel">
                        <div class="row w-100">
                            <?php $nCash = (explode(",", $user[0]->cash)) ?>
                            <select id="listCash" class="searchable" multiple="multiple" name="listCash[]">
                                <?php foreach ($cash as $db) : $condition = '';
                                    foreach ($nCash as $field) if ($field == $db->id) $condition = 'selected' ?>
                                    <option value="<?= $db->id ?>" <?= ($condition . ($link == '/auser' ? ($supervisor[0]->act_access[8] == '0' ? (preg_match("/(^|,)" . $db->id . "(,|$)/i", $supervisor[0]->cash) ? '' : 'disabled') : '') : '')) ?>><?= "{$db->name}" ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div> <!--/ Tab content  -->
            </div> <!--/ Card body  -->

            <div class="card-footer">
                <div class="row w-100">
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= lang("app.save by") ?> :</small>
                        <div class="form-text"><?= ($user[0]->saveBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= lang("app.confirm by") ?> :</small>
                        <div class="form-text"><?= ($user[0]->confirmBy ?? '') ?></div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-3 mb-2">
                        <small class="text-light fw-medium d-block"><?= $active_by ?> :</small>
                        <div class="form-text"><?= ($user[0]->activeBy ?? '') ?></div>
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
            </div> <!--/ Card footer  -->
        </div> <!--/ Card -->
    </div> <!--/ Column -->
</div> <!--/ Row-->
<?= form_close() ?>

<script>
    $(document).ready(function() {
        $('#supervisor').select2({
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
        var resultCompany = [];
        var resultRegion = [];
        var resultDivision = [];
        formData.getAll('listCompany[]').forEach(function(value) {
            var companyID = 'company_' + value;
            var companyCheck = formData.has(companyID) ? 1 : 0;
            resultCompany.push(value + ':' + companyCheck);
        });
        formData.getAll('listRegion[]').forEach(function(value) {
            var regionID = 'region_' + value;
            var regionCheck = formData.has(regionID) ? 1 : 0;
            resultRegion.push(value + ':' + regionCheck);
        });
        formData.getAll('listDivision[]').forEach(function(value) {
            var divisionID = 'division_' + value;
            var divisionCheck = formData.has(divisionID) ? 1 : 0;
            resultDivision.push(value + ':' + divisionCheck);
        });

        var accessCompany = resultCompany.join(',');
        var accessRegion = resultRegion.join(',');
        var accessDivision = resultDivision.join(',');
        formData.append('accessCompany', accessCompany);
        formData.append('accessRegion', accessRegion);
        formData.append('accessDivision', accessDivision);
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
                $('#supervisor, #limit').removeClass('is-invalid');
                $('.err_supervisor, .err_limit').html('');
                if (response.error) {
                    handleFieldError('supervisor', response.error.supervisor);
                    handleFieldError('limit', response.error.limit);
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
<?= $this->extend($template == 'vertical' ? 'layouts/template-vertical' : 'layouts/template-horizontal') ?>
<?= $this->section('content') ?>

<!-- Header -->
<div class="row">
    <div class="col-12">
        <div class="card mb-6">
            <div class="user-profile-header-banner">
                <img src="<?= base_url('assets/image/bg-img/banner.png') ?>" alt="Banner image" class="rounded-top" />
            </div>
            <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-5">
                <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                    <img src="<?= base_url('assets/picture/user/' . session()->avatar) ?>" alt="user image" class="d-block h-auto ms-0 ms-sm-5 rounded-4 user-profile-img" />
                </div>
                <div class="flex-grow-1 mt-4 mt-sm-12">
                    <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-6">
                        <div class="user-profile-info">
                            <h4 class="mb-2"><?= decrypt(session()->username) ?></h4>
                            <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                                <li class="list-inline-item"><i class="ri-signpost-line me-2 ri-24px"></i><span class="fw-medium"><?= $person[0]->eid ?></span></li>
                                <li class="list-inline-item"><i class="ri-building-4-line me-2 ri-24px"></i><span class="fw-medium"><?= $company[0]->code ?></span></li>
                                <li class="list-inline-item"><i class="ri-calendar-line me-2 ri-24px"></i><span class="fw-medium"><?= lang('app.joined'); ?> <?= date('d F Y', strtotime($person[0]->join_date)) ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/ Header -->

<!-- Navbar pills -->
<div class="row">
    <div class="col-md-12">
        <div class="nav-align-top">
            <ul class="nav nav-pills flex-column flex-sm-row mb-6 row-gap-2">
                <li class="nav-item"><button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-profile" aria-controls="navs-top-profile" aria-selected="false"><i class="ri-user-3-line me-2"></i><?= lang('app.profile') ?></button>
                <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-access" aria-controls="navs-top-access" aria-selected="false"><i class="ri-key-2-line me-2"></i><?= lang('app.access rights') ?></button>
                <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-salary" aria-controls="navs-top-salary" aria-selected="false"><i class="ri-cash-line me-2"></i><?= lang('app.salary') ?></button>
                <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-evaluation" aria-controls="navs-top-evaluation" aria-selected="false"><i class="ri-survey-line me-2"></i><?= lang('app.evaluation') ?></button>
                <li class="nav-item"><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-letter" aria-controls="navs-top-letter" aria-selected="false"><i class="ri-mail-line me-2"></i><?= lang('app.letter') ?></button>
            </ul>
        </div>
    </div>
</div>
<!--/ Navbar pills -->

<!-- User Profile Content -->
<div class="row">
    <div class="col-xl-4 col-lg-5 col-md-5">
        <!-- About User -->
        <div class="card mb-6">
            <div class="card-body">
                <small class="card-text text-uppercase text-muted small">About</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-user-3-line ri-24px"></i><span class="fw-medium mx-2">Full Name:</span>
                        <span>John Doe</span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-check-line ri-24px"></i><span class="fw-medium mx-2">Status:</span>
                        <span>Active</span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-star-smile-line ri-24px"></i><span class="fw-medium mx-2">Role:</span>
                        <span>Developer</span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-flag-2-line ri-24px"></i><span class="fw-medium mx-2">Country:</span>
                        <span>USA</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="ri-translate-2 ri-24px"></i><span class="fw-medium mx-2">Languages:</span>
                        <span>English</span>
                    </li>
                </ul>
                <small class="card-text text-uppercase text-muted small">Contacts</small>
                <ul class="list-unstyled my-3 py-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-phone-line ri-24px"></i><span class="fw-medium mx-2">Contact:</span>
                        <span>(123) 456-7890</span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-wechat-line ri-24px"></i><span class="fw-medium mx-2">Skype:</span>
                        <span>john.doe</span>
                    </li>
                    <li class="d-flex align-items-center mb-2">
                        <i class="ri-mail-open-line ri-24px"></i><span class="fw-medium mx-2">Email:</span>
                        <span>john.doe@example.com</span>
                    </li>
                </ul>
                <small class="card-text text-uppercase text-muted small">Teams</small>
                <ul class="list-unstyled mb-0 mt-3 pt-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-github-line ri-24px text-body me-2"></i>
                        <div class="d-flex flex-wrap">
                            <span class="fw-medium me-2">Backend Developer</span><span>(126 Members)</span>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ri-reactjs-line ri-24px text-body me-2"></i>
                        <div class="d-flex flex-wrap">
                            <span class="fw-medium me-2">React Developer</span><span>(98 Members)</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!--/ About User -->
        <!-- Profile Overview -->
        <div class="card mb-6">
            <div class="card-body">
                <small class="card-text text-uppercase text-muted small">Overview</small>
                <ul class="list-unstyled mb-0 mt-3 pt-1">
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-check-line ri-24px"></i><span class="fw-medium mx-2">Task Compiled:</span>
                        <span>13.5k</span>
                    </li>
                    <li class="d-flex align-items-center mb-4">
                        <i class="ri-user-3-line ri-24px"></i><span class="fw-medium mx-2">Projects Compiled:</span>
                        <span>146</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="ri-star-smile-line ri-24px"></i><span class="fw-medium mx-2">Connections:</span>
                        <span>897</span>
                    </li>
                </ul>
            </div>
        </div>
        <!--/ Profile Overview -->
    </div>
    <div class="col-xl-8 col-lg-7 col-md-7">

    </div>
</div>
<!--/ User Profile Content -->

<?= $this->endSection() ?>
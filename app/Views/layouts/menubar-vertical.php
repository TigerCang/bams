<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="/" class="app-brand-link">
            <img src="<?= base_url('assets/image/logo-trans.png') ?>" height="30" class="me-4">
            <span class="app-brand-text demo menu-text fw-bold ms-2">BAMS</span>
        </a>
        <a href="javascript:void(0);" class="highlight-menu layout-menu-toggle menu-link text-large ms-auto">
            <svg class="clickThis" width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.4854 4.88844C11.0081 4.41121 10.2344 4.41121 9.75715 4.88844L4.51028 10.1353C4.03297 10.6126 4.03297 11.3865 4.51028 11.8638L9.75715 17.1107C10.2344 17.5879 11.0081 17.5879 11.4854 17.1107C11.9626 16.6334 11.9626 15.8597 11.4854 15.3824L7.96672 11.8638C7.48942 11.3865 7.48942 10.6126 7.96672 10.1353L11.4854 6.61667C11.9626 6.13943 11.9626 5.36568 11.4854 4.88844Z" fill="currentColor" fill-opacity="0.6" />
                <path d="M15.8683 4.88844L10.6214 10.1353C10.1441 10.6126 10.1441 11.3865 10.6214 11.8638L15.8683 17.1107C16.3455 17.5879 17.1192 17.5879 17.5965 17.1107C18.0737 16.6334 18.0737 15.8597 17.5965 15.3824L14.0778 11.8638C13.6005 11.3865 13.6005 10.6126 14.0778 10.1353L17.5965 6.61667C18.0737 6.13943 18.0737 5.36568 17.5965 4.88844C17.1192 4.41121 16.3455 4.41121 15.8683 4.88844Z" fill="currentColor" fill-opacity="0.38" />
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <!-- Administrator -->
        <li class="menu-item" <?= ((preg_match("/A01/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-user-gear me-3"></i>
                <div data-i18n="<?= lang('app.administrator') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/101/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="" class="menu-link">
                        <div data-i18n="<?= lang('app.database') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/102/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/config" class="menu-link">
                        <div data-i18n="<?= lang('app.config') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/103/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/role" class="menu-link">
                        <div data-i18n="<?= lang('app.role') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/A02/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.user') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/104/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/user" class="menu-link">
                                <div data-i18n="<?= lang('app.user') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/105/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/token" class="menu-link">
                                <div data-i18n="<?= lang('app.token') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/loguser" class="menu-link">
                                <div data-i18n="<?= lang('app.user log') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/107/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/resetpassword" class="menu-link">
                                <div data-i18n="<?= lang('app.reset password') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li> <!--/ Administrator -->

        <!-- Main Data -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.main data') ?>"></span></li>
        <!-- Declaration -->
        <li class="menu-item" <?= ((preg_match("/A03/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-signs-post me-3"></i>
                <div data-i18n="<?= lang('app.declaration') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/108/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/company" class="menu-link">
                        <div data-i18n="<?= lang('app.company') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/109/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/division" class="menu-link">
                        <div data-i18n="<?= lang('app.region division') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/110/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/auser" class="menu-link">
                        <div data-i18n="<?= lang('app.child user') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xLine') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/111/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/unit" class="menu-link">
                        <div data-i18n="<?= lang('app.unit') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/A04/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.project cost') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/112/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/groupproject" class="menu-link">
                                <div data-i18n="<?= lang('app.project category') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/113/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/directcost" class="menu-link">
                                <div data-i18n="<?= lang('app.direct cost') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/114/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/indirectcost" class="menu-link">
                                <div data-i18n="<?= lang('app.indirect cost') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/115/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/resources" class="menu-link">
                                <div data-i18n="<?= lang('app.resources') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/A05/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.formula') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/116/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/distance" class="menu-link">
                                <div data-i18n="<?= lang('app.distance') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/117/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/tariff" class="menu-link">
                                <div data-i18n="<?= lang('app.tariff') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/118/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/jobmix" class="menu-link">
                                <div data-i18n="<?= lang('app.job mix') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div data-i18n="<?= json('xLine') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/119/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/document" class="menu-link">
                        <div data-i18n="<?= lang('app.document') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/120/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/defaultbudget" class="menu-link">
                        <div data-i18n="<?= lang('app.default budget') ?>"></div>
                    </a>
                </li>
            </ul>
        </li><!--/ Declaration -->

        <!-- Accounting -->
        <li class="menu-item" <?= ((preg_match("/A06/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-scale-balanced me-3"></i>
                <div data-i18n="<?= lang('app.accounting') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/121/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/accounting" class="menu-link">
                        <div data-i18n="<?= lang('app.coa') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/122/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/groupaccount" class="menu-link">
                        <div data-i18n="<?= lang('app.group account') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/123/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/defaultaccount" class="menu-link">
                        <div data-i18n="<?= lang('app.default account') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/124/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cashaccount" class="menu-link">
                        <div data-i18n="<?= lang('app.cash bank') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/125/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/taxaccount" class="menu-link">
                        <div data-i18n="<?= lang('app.tax') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xLine') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/126/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/otherstandard" class="menu-link">
                        <div data-i18n="<?= lang('app.other standard') ?>"></div>
                    </a>
                </li>
            </ul>
        </li><!--/ Accounting -->

        <!-- Branch -->
        <li class="menu-item" <?= ((preg_match("/A07/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-sitemap me-3"></i>
                <div data-i18n="<?= lang('app.branch asset') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/127/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/branch" class="menu-link">
                        <div data-i18n="<?= lang('app.branch') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/A08/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.project') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/128/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/project" class="menu-link">
                                <div data-i18n="<?= lang('app.project') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/129/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/segment" class="menu-link">
                                <div data-i18n="<?= lang('app.segment') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/130/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/subsegment" class="menu-link">
                                <div data-i18n="<?= lang('app.sub segment') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/A09/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.equipment tool') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/131/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/equipment" class="menu-link">
                                <div data-i18n="<?= lang('app.equipment') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/132/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/tool" class="menu-link">
                                <div data-i18n="<?= lang('app.tool') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/133/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/landbuilding" class="menu-link">
                        <div data-i18n="<?= lang('app.land building') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/134/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/inventory" class="menu-link">
                        <div data-i18n="<?= lang('app.inventory') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Branch -->

        <!-- Item -->
        <li class="menu-item" <?= ((preg_match("/A10/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-boxes-stacked me-3"></i>
                <div data-i18n="<?= lang('app.item') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/135/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/item" class="menu-link">
                        <div data-i18n="<?= lang('app.item') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/136/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/material" class="menu-link">
                        <div data-i18n="<?= lang('app.material') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xLine') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/137/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/serial" class="menu-link">
                        <div data-i18n="<?= lang('app.serial') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/138/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/warehouse" class="menu-link">
                        <div data-i18n="<?= lang('app.warehouse') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Item -->

        <!-- Recipient -->
        <li class="menu-item" <?= ((preg_match("/A11/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-handshake me-3"></i>
                <div data-i18n="<?= lang('app.recipient') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/139/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/recipient" class="menu-link">
                        <div data-i18n="<?= lang('app.recipient') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/140/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/partnervehicle" class="menu-link">
                        <div data-i18n="<?= lang('app.partner vehicle') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/141/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/linkcompany" class="menu-link">
                        <div data-i18n="<?= lang('app.link company') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Recipient -->

        <!-- Human Resources -->
        <li class="menu-item" <?= ((preg_match("/A12/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <!-- <i class="fa-solid fa-people-group me-3"></i> -->
                <i class="fa-solid fa-user-group me-3"></i>
                <div data-i18n="<?= lang('app.human resources') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/142/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/daysoff" class="menu-link">
                        <div data-i18n="<?= lang('app.days off') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/143/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/calendar" class="menu-link">
                        <div data-i18n="<?= lang('app.holiday calendar') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/144/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/announcement" class="menu-link">
                        <div data-i18n="<?= lang('app.announcement') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/145/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/ratingcategory" class="menu-link">
                        <div data-i18n="<?= lang('app.rating category') ?>"></div>
                    </a>
                </li>
                <li>
                    <div data-i18n="<?= json('xLine') ?>"></div>
                </li>
                <li class="menu-item" <?= ((preg_match("/A13/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.employee') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/146/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/employee" class="menu-link">
                                <div data-i18n="<?= lang('app.employee') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/147/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/position" class="menu-link">
                                <div data-i18n="<?= lang('app.position class') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/A14/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.salary') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/148/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/salaryattribute" class="menu-link">
                                <div data-i18n="<?= lang('app.salary attribute') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/149/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/salary" class="menu-link">
                                <div data-i18n="<?= lang('app.salary') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/A15/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.numbering') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/150/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/formcode" class="menu-link">
                                <div data-i18n="<?= lang('app.document code') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/151/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/formnumber" class="menu-link">
                                <div data-i18n="<?= lang('app.form number') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li> <!--/ SDM -->

        <!-- General Transaction -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.general transaction') ?>"></span></li>
        <!-- Budget -->
        <li class="menu-item" <?= ((preg_match("/A01/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-calculator me-3"></i>
                <div data-i18n="<?= lang('app.budget') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/A08/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.project') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/127/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/directbudget" class="menu-link">
                                <div data-i18n="<?= lang('app.direct budget') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/128/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/indirectbudget" class="menu-link">
                                <div data-i18n="<?= lang('app.indirect budget') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/129/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/resourcebudget" class="menu-link">
                                <div data-i18n="<?= lang('app.resource budget') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/accountbudget" class="menu-link">
                        <div data-i18n="<?= lang('app.account budget') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="<?= lang('app.revision') ?>"></div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisibiayalangsung" class="menu-link">
                                <div data-i18n="<?= lang('app.biayalangsung') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisibiayataklangsung" class="menu-link">
                                <div data-i18n="<?= lang('app.biayataklangsung') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisisumberdaya" class="menu-link">
                                <div data-i18n="<?= lang('app.satuandetil') ?>"></div>
                            </a>
                        </li>
                        <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                            <a href="/revisinonproyek" class="menu-link">
                                <div data-i18n="<?= lang('app.nonproyek') ?>"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/accanggaran" class="menu-link">
                        <div data-i18n="<?= lang('app.tandatangan') ?>"></div>
                    </a>
                </li>

            </ul>
        </li>

        <!-- Item Transaction -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksibarang') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Divition Transaction -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksidivisi') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Cash Transaction -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.cash transaction') ?>"></span></li>
        <!-- Cash Request -->
        <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-money-bill me-3"></i>
                <div data-i18n="<?= lang('app.cash request') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/directcash" class="menu-link">
                        <div data-i18n="<?= lang('app.direct cash') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/advancepayment" class="menu-link">
                        <div data-i18n="<?= lang('app.advance payment') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cashtransfer" class="menu-link">
                        <div data-i18n="<?= lang('app.cash transfer') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/kastaklangsung" class="menu-link">
                        <div data-i18n="<?= lang('app.kas taklangsung') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Minta kas -->

        <!-- Pengecekan -->
        <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="fa-solid fa-money-bill me-3"></i>
                <div data-i18n="<?= lang('app.cek kas') ?>"></div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cekkas" class="menu-link">
                        <div data-i18n="<?= lang('app.tanda tangan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/keuangan" class="menu-link">
                        <div data-i18n="<?= lang('app.keuangan') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/potongpph" class="menu-link">
                        <div data-i18n="<?= lang('app.potong pph') ?>"></div>
                    </a>
                </li>
                <li class="menu-item" <?= ((preg_match("/106/i", thisMenu()['menu_1'])) ? '' : 'hiddena') ?>>
                    <a href="/cekkasir" class="menu-link">
                        <div data-i18n="<?= lang('app.cek kasir') ?>"></div>
                    </a>
                </li>
            </ul>
        </li> <!--/ Cek kas -->

        <!-- Transaksi Akuntansi -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksiakuntansi') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Transaksi SDM -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.transaksisdm') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Laporan -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.laporan') ?>"></span></li>
        <!-- Menu Anggaran -->

        <!-- Lain Lain -->
        <li class="menu-header fw-medium mt-4"><span class="menu-header-text" data-i18n="<?= lang('app.lainlain') ?>"></span></li>
        <li class="menu-item">
            <a href="/faq" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-lifebuoy"></i>
                <div data-i18n="<?= lang('app.faq') ?>"></div>
            </a>
        </li>

        <li class="menu-item">
            <a href="" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-lifebuoy"></i>
                <div data-i18n="<?= lang('app.help') ?>"></div>
            </a>
        </li>
        <li class="menu-item">
            <a href="" target="_blank" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-lifebuoy"></i>
                <div data-i18n="<?= lang('app.dukungan') ?>"></div>
            </a>
        </li>



    </ul>
</aside>
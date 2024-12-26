<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// $routes->GET('/', 'Home::index');

// Login ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->GET('/logout', 'Login::logout');
$routes->GET('/signup', 'Login::viewSignup');
$routes->GET('/forget', 'Login::viewPassword');
$routes->group('login', function ($routes) {
    $routes->GET('/', 'Login');
    $routes->POST('auth', 'Login::auth');
    $routes->POST('reset', 'Login::resetPassword');
    $routes->POST('signup', 'Login::processSignup');
});

// Home ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->get('/', 'Home::index', ['filter' => 'auth']);
$routes->get('/home', function () {
    return redirect()->to('/');
});
$routes->GET('/profile', 'Home::profilpegawai', ['filter' => 'auth']);
$routes->POST('/changepassword', 'Home::changePassword', ['filter' => 'auth']);
$routes->GET('/logactivity', 'Home::logData', ['filter' => 'auth']);
$routes->GET('/lang/{locale}', 'Home::bahasa');

// Administrator ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('config', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\Config::index');
    $routes->GET('input', 'admin\Config::inputData');
    $routes->POST('save', 'admin\Config::saveData');
});
$routes->group('role', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\Role::index');
    $routes->GET('input', 'admin\Role::inputData');
    $routes->POST('save', 'admin\Role::saveData');
});
$routes->group('user', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\User::index');
    $routes->GET('input', 'admin\User::inputData');
    $routes->POST('save', 'admin\User::saveData');
});
$routes->group('token', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\Token::index');
    $routes->GET('input', 'admin\Token::inputData');
    $routes->POST('save', 'admin\Token::saveData');
});
$routes->group('loguser', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\LogUser::index');
});
$routes->group('resetpassword', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'admin\ResetPassword::index');
    $routes->POST('reset', 'admin\ResetPassword::resetData');
});

// Mix ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('search', ['filter' => 'auth'],  function ($routes) {
    $routes->POST('log', 'mix\LoadMain::searchLog');
    $routes->POST('cost', 'mix\LoadMain::searchCost');
    $routes->POST('tool', 'mix\LoadMain::searchTool');
    $routes->POST('item', 'mix\LoadMain::searchItem');
    $routes->POST('distance', 'mix\LoadMain::searchDistance');
});
$routes->group('show', ['filter' => 'auth'],  function ($routes) {
    $routes->POST('unit', 'mix\loadMain::showUnit');
});
$routes->group('attachment', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('table', 'mix\Attachment::table');
    $routes->GET('modal', 'mix\Attachment::modal');
    $routes->GET('modal2', 'mix\Attachment::modal2');
    $routes->POST('save', 'mix\Attachment::save');
    $routes->POST('delete', 'mix\Attachment::delete');
});
$routes->group('load', ['filter' => 'auth'],  function ($routes) {
    $routes->POST('account', 'mix\LoadMain::loadAccount');
    $routes->POST('standard', 'mix\LoadMain::loadStandard');
    $routes->POST('cost', 'mix\LoadMain::loadCost');
    $routes->POST('user', 'mix\LoadMain::loadUser');
    $routes->POST('person', 'mix\LoadMain::loadPerson');
    $routes->POST('item', 'mix\LoadMain::loadItem');
    $routes->POST('project', 'mix\LoadMain::loadProject');
    $routes->POST('branch', 'mix\LoadMain::loadBranch');
    $routes->POST('tool', 'mix\LoadMain::loadTool');
    $routes->POST('object', 'mix\LoadMain::loadObject');
});
$routes->group('outfocus', ['filter' => 'auth'],  function ($routes) {
    $routes->POST('person', 'mix\LoadMain::OutFocusPerson');
});


// $routes->get('getUnique', 'mix\loadTransaction::CreateUnique');

// Declaration ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('company', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\Company::index');
    $routes->GET('input', 'main\declaration\Company::inputData');
    $routes->POST('save', 'main\declaration\Company::saveData');
    $routes->GET('inputmodal/(:any)', 'main\declaration\Company::inputModal/$1');
    $routes->POST('savemodal/(:any)', 'main\declaration\Company::saveModal/$1');
    $routes->GET('tablemodal', 'main\declaration\Company::tableModal');
});
$routes->group('division', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\Division::index');
    $routes->GET('input', 'main\declaration\Division::inputData');
    $routes->POST('save', 'main\declaration\Division::saveData');
});
$routes->group('auser', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\aUser::index');
    $routes->GET('input', 'main\declaration\aUser::inputData');
    $routes->POST('save', 'main\declaration\aUser::saveData');
});
$routes->group('unit', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\Unit::index');
    $routes->GET('input', 'main\declaration\Unit::inputData');
    $routes->POST('save', 'main\declaration\Unit::saveData');
});
$routes->group('groupproject', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\GroupProject::index');
    $routes->GET('input', 'main\declaration\GroupProject::inputData');
    $routes->POST('save', 'main\declaration\GroupProject::saveData');
});
$routes->group('directcost', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\DirectCost::index');
    $routes->GET('input', 'main\declaration\DirectCost::inputData');
    $routes->POST('save', 'main\declaration\DirectCost::saveData');
});
$routes->group('indirectcost', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\IndirectCost::index');
    $routes->GET('input', 'main\declaration\IndirectCost::inputData');
    $routes->POST('save', 'main\declaration\IndirectCost::saveData');
});
$routes->group('resources', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\Resources::index');
    $routes->GET('input', 'main\declaration\Resources::inputData');
    $routes->POST('save', 'main\declaration\Resources::saveData');
});
$routes->group('distance', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\Distance::index');
    $routes->GET('input', 'main\declaration\Distance::inputData');
    $routes->POST('save', 'main\declaration\Distance::saveData');
    $routes->POST('outFocusProject', 'main\asset\Segment::outFocusProject');
});
$routes->group('defaultbudget', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\declaration\DefaultBudget::index');
    $routes->GET('input', 'main\declaration\DefaultBudget::inputData');
    $routes->GET('table', 'main\declaration\DefaultBudget::tableData');
    $routes->POST('add', 'main\declaration\DefaultBudget::addData');
    $routes->GET('modal', 'main\declaration\DefaultBudget::modalData');
    // $routes->GET('edit', 'main\declaration\DefaultBudget::editData');

    // $routes->POST('save', 'main\deklarasi\SetAnggaran::saveData');
    // $routes->GET('/', 'file\deklarasi\Anggaran::index');
    // $routes->GET('input', 'file\deklarasi\Anggaran::crany');
    // $routes->GET('input/(:any)', 'file\deklarasi\Anggaran::showdata/$1');
    // $routes->POST('additem', 'file\deklarasi\Anggaran::tambahdata');
    // $routes->POST('edititem', 'file\deklarasi\Anggaran::updatedata');
    // $routes->POST('delitem', 'file\deklarasi\Anggaran::deletedata');
    // $routes->POST('save', 'file\deklarasi\Anggaran::savedata');  
    // $routes->GET('modalkoreksi', 'file\deklarasi\Anggaran::modaldata');
    // $routes->POST('akun', 'extra\Loadfile::loadakun');
    // $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
    // $routes->GET('tabbudget', 'file\deklarasi\Anggaran::tabelbudget');
});

// Accounting ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('accounting', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\accounting\Accounting::index');
    $routes->GET('input', 'main\accounting\Accounting::inputData');
    $routes->POST('search', 'main\accounting\Accounting::searchData');
    $routes->POST('save', 'main\accounting\Accounting::saveData');
});
$routes->group('groupaccount', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\accounting\GroupAccount::index');
    $routes->GET('input', 'main\accounting\GroupAccount::inputData');
    $routes->POST('save', 'main\accounting\GroupAccount::saveData');
});
$routes->group('cashaccount', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\accounting\CashAccount::index');
    $routes->GET('input', 'main\accounting\CashAccount::inputData');
    $routes->POST('save', 'main\accounting\CashAccount::saveData');
});
$routes->group('taxaccount', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\accounting\TaxAccount::index');
    $routes->GET('input', 'main\accounting\TaxAccount::inputData');
    $routes->POST('save', 'main\accounting\TaxAccount::saveData');
});
$routes->group('otherstandard', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\accounting\Standard::index');
    $routes->GET('input', 'main\accounting\Standard::inputData');
    $routes->POST('search', 'main\accounting\Standard::searchData');
    $routes->POST('save', 'main\accounting\Standard::saveData');
});

// Asset ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('branch', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\Branch::index');
    $routes->GET('input', 'main\asset\Branch::inputData');
    $routes->POST('save', 'main\asset\Branch::saveData');
});
$routes->group('project', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\Project::index');
    $routes->GET('input', 'main\asset\Project::inputData');
    $routes->POST('search', 'main\asset\Project::searchData');
    $routes->POST('save', 'main\asset\Project::saveData');
    $routes->POST('district', 'main\asset\Project::loadDistrict');
    $routes->POST('offFocusProject', 'main\asset\Project::offFocusProject');
});
$routes->group('segment', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\Segment::index');
    $routes->GET('input', 'main\asset\Segment::inputData');
    $routes->POST('save', 'main\asset\Segment::saveData');
    $routes->POST('outFocusProject', 'main\asset\Segment::outFocusProject');
});
$routes->group('subsegment', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\SubSegment::index');
    $routes->GET('input', 'main\asset\SubSegment::inputData');
    $routes->POST('save', 'main\asset\SubSegment::saveData');
    $routes->POST('outFocusProject', 'main\asset\Segment::outFocusProject');
});
$routes->group('equipment', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\Equipment::index');
    $routes->GET('input', 'main\asset\Equipment::inputData');
    $routes->POST('save', 'main\asset\Equipment::saveData');
});
$routes->group('tool', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\Tool::index');
    $routes->GET('input', 'main\asset\Tool::inputData');
    $routes->POST('save', 'main\asset\Tool::saveData');
});
$routes->group('landbuilding', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\LandBuilding::index');
    $routes->GET('input', 'main\asset\LandBuilding::inputData');
    $routes->POST('search', 'main\asset\LandBuilding::searchData');
    $routes->POST('save', 'main\asset\LandBuilding::saveData');
});
$routes->group('inventory', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\Inventory::index');
    $routes->GET('input', 'main\asset\Inventory::inputData');
    $routes->POST('search', 'main\asset\Inventory::searchData');
    $routes->POST('save', 'main\asset\Inventory::saveData');
});
$routes->group('document', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\asset\Document::index');
    $routes->GET('input', 'main\asset\Document::inputData');
    $routes->POST('search', 'main\asset\Document::searchData');
    $routes->POST('save', 'main\asset\Document::saveData');
    $routes->POST('outFocusObject', 'main\asset\Document::outFocusObject');
});

// Item ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('item', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\item\Item::index');
    $routes->GET('input', 'main\item\Item::inputData');
    $routes->POST('save', 'main\item\Item::saveData');
});
$routes->group('material', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\item\Material::index');
    $routes->GET('input', 'main\item\Material::inputData');
    $routes->POST('save', 'main\item\Material::saveData');
});
$routes->group('serial', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\item\Serial::index');
    $routes->GET('input', 'main\item\Serial::inputData');
    $routes->POST('search', 'main\item\Serial::searchData');
    $routes->POST('save', 'main\item\Serial::saveData');
});
$routes->group('warehouse', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\item\Warehouse::index');
    $routes->GET('input', 'main\item\Warehouse::inputData');
    $routes->POST('save', 'main\item\Warehouse::saveData');
});

// Recipient ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('recipient', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\person\Recipient::index');
    $routes->GET('input', 'main\person\Recipient::inputData');
    $routes->POST('search', 'main\person\Recipient::searchData');
    $routes->POST('save', 'main\person\Recipient::saveData');
});
$routes->group('partnervehicle', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\person\PartnerVehicle::index');
    $routes->GET('input', 'main\person\PartnerVehicle::inputData');
    $routes->POST('save', 'main\person\PartnerVehicle::saveData');
});
$routes->group('linkcompany', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\person\LinkCompany::index');
    $routes->GET('input', 'main\person\LinkCompany::inputData');
    $routes->POST('save', 'main\person\LinkCompany::saveData');
});


// HRD ___________________________________________________________________________________________________________________________________________________________________________________________
$routes->group('daysoff', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\hrd\DaysOff::index');
    $routes->GET('input', 'main\hrd\DaysOff::inputData');
    $routes->POST('save', 'main\hrd\DaysOff::saveData');
});
$routes->group('calendar', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\hrd\Calendar::index');
    $routes->GET('input', 'main\hrd\Calendar::inputData');
    $routes->POST('save', 'main\hrd\Calendar::saveData');
    $routes->POST('delete', 'main\hrd\Calendar::deleteData');
});
$routes->group('ratingcategory', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\hrd\RatingCategory::index');
    $routes->GET('input', 'main\hrd\RatingCategory::inputData');
    $routes->POST('save', 'main\hrd\RatingCategory::saveData');
});
$routes->group('pengumuman', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'file\sdm\Pengumuman::index');
    $routes->POST('save', 'file\sdm\Pengumuman::savedata');
});
$routes->group('employee', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\hrd\Employee::index');
    $routes->GET('input', 'main\hrd\Employee::inputData');
    $routes->POST('search', 'main\hrd\Employee::searchData');
    $routes->POST('save', 'main\hrd\Employee::saveData');
});
$routes->group('position', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\hrd\Position::index');
    $routes->GET('input', 'main\hrd\Position::inputData');
    $routes->POST('save', 'main\hrd\Position::saveData');
});
$routes->group('formcode', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\hrd\FormCode::index');
    $routes->GET('input', 'main\hrd\FormCode::inputData');
    $routes->POST('save', 'main\hrd\FormCode::saveData');
});
$routes->group('formnumber', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'main\hrd\FormNumber::index');
    $routes->GET('input', 'main\hrd\FormNumber::inputData');
    $routes->POST('save', 'main\hrd\FormNumber::saveData');
});

// General Transaction ___________________________________________________________________________________________________________________________________________________________________________________________
// $routes->group('anggbiayal', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'trumum\anggaran\Biayalangsung::index');
//     $routes->GET('input', 'trumum\anggaran\Biayalangsung::crany');
//     $routes->GET('input/(:any)', 'trumum\anggaran\Biayalangsung::showdata/$1');
//     $routes->POST('additem', 'trumum\anggaran\Biayalangsung::tambahdata');
//     // $routes->POST('edititem', 'trumum\anggaran\Cabang::updatedata');
//     // $routes->POST('delitem', 'trumum\anggaran\Cabang::deletedata');

//     // $routes->POST('addbudget', 'umum\anggaran\Cabang::tambahdata');
//     // $routes->POST('savedoc', 'umum\anggaran\Cabang::savedokumen');
//     // // $routes->GET('bataldoc/(:any)', 'umum\anggaran\Biayatidaklangsung::canceldokumen/$1');
//     $routes->GET('tabinduk', 'extra\Loadtran::tabelanggaraninduk');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
//     $routes->POST('biaya', 'extra\Loadfile::loadbiaya');

//     $routes->GET('tabbiaya', 'extra\Loadtran::tabeldataanggaran');
//     $routes->POST('savedoc', 'trumum\anggaran\Biayalangsung::savedata');
//     $routes->GET('modalbatal', 'trumum\anggaran\Biayalangsung::modalbatal');

//     $routes->POST('bataldoc', 'trumum\anggaran\Biayalangsung::canceldata');

//     // $routes->POST('loadbudget', 'umum\anggaran\Cabang::loadbudgetbawaan');
//     // // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
//     // // $routes->POST('delbudget', 'umum\anggaran\Camp::deletedata');
// });

$routes->group('indirectbudget', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trgeneral\budget\IndirectBudget::index');
    $routes->GET('input', 'trgeneral\budget\IndirectBudget::inputData');
    $routes->GET('table', 'trgeneral\budget\AccountBudget::tableData');
    $routes->POST('add', 'trgeneral\budget\IndirectBudget::addData');
});

$routes->group('accountbudget', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trgeneral\budget\AccountBudget::index');
    $routes->GET('input', 'trgeneral\budget\AccountBudget::inputData');
    $routes->GET('table', 'trgeneral\budget\AccountBudget::tableData');
    $routes->POST('add', 'trgeneral\budget\AccountBudget::addData');
    $routes->POST('save', 'trgeneral\budget\AccountBudget::saveData');
    // $routes->POST('edititem', 'trumum\anggaran\Objek::updatedata');
    // $routes->POST('delitem', 'trumum\anggaran\Objek::deletedata');



    // $routes->group('defaultbudget', ['filter' => 'auth'],  function ($routes) {
    //     $routes->GET('/', 'main\declaration\DefaultBudget::index');
    //     $routes->GET('input', 'main\declaration\DefaultBudget::inputData');

    // $routes->GET('/', 'main\declaration\Company::index');
    // $routes->GET('input', 'main\declaration\Company::inputData');
    // $routes->POST('save', 'main\declaration\Company::saveData');
    // $routes->GET('inputmodal/(:any)', 'main\declaration\Company::inputModal/$1');
    // $routes->POST('savemodal/(:any)', 'main\declaration\Company::saveModal/$1');
    // $routes->GET('tablemodal', 'main\declaration\Company::tableModal');
    // $routes->POST('addbudget', 'umum\anggaran\Cabang::tambahdata');
    // $routes->POST('savedoc', 'umum\anggaran\Cabang::savedokumen');
    // // $routes->GET('bataldoc/(:any)', 'umum\anggaran\Biayatidaklangsung::canceldokumen/$1');
    $routes->GET('tabinduk', 'extra\Loadtran::tabelanggaraninduk');
    $routes->GET('beban', 'extra\Loadfile::modalbeban');
    $routes->POST('akun', 'extra\Loadfile::loadakun');
    $routes->POST('biaya', 'extra\Loadfile::loadbiaya');

    $routes->GET('tabbiaya', 'extra\Loadtran::tabeldataanggaran');
    // $routes->POST('loadbudget', 'umum\anggaran\Cabang::loadbudgetbawaan');
    // // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
    // // $routes->POST('delbudget', 'umum\anggaran\Camp::deletedata');
});


// $routes->group('sojual', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'umum\penjualan\SOJual::index');
//     $routes->GET('input', 'umum\penjualan\SOJual::crany');
//     $routes->GET('input/(:any)', 'umum\penjualan\SOJual::showdata/$1');
//     $routes->POST('addjual', 'umum\penjualan\SOJual::tambahdata');
//     // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
//     $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
//     $routes->GET('camp', 'extra\Loadfile::modalcamp');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
//     $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
//     $routes->POST('barang', 'extra\Loadfile::loadbarang');
//     $routes->POST('alat', 'extra\Loadfile::loadalat');
//     $routes->POST('tanah', 'extra\Loadfile::loadtanah');
//     $routes->POST('inventaris', 'extra\Loadfile::loadinventaris');
//     $routes->POST('satuan', 'umum\penjualan\SOJual::loadsatuan');
//     $routes->POST('bentuk', 'umum\penjualan\SOJual::loadbentuk');
//     $routes->POST('loadcamp', 'umum\penjualan\SOJual::loadcamp');
//     $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

//     // $routes->POST('biaya', 'Komponen::loadbiaya');
//     // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
//     // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
// });

// $routes->group('sosewa', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'umum\penjualan\SOSewa::index');
//     $routes->GET('input', 'umum\penjualan\SOSewa::crany');
//     $routes->GET('input/(:any)', 'umum\penjualan\SOSewa::showdata/$1');
//     $routes->POST('addjual', 'umum\penjualan\SOSewa::tambahdata');
//     // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
//     $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
//     $routes->GET('camp', 'extra\Loadfile::modalcamp');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
//     $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
//     $routes->POST('barang', 'extra\Loadfile::loadbarang');
//     $routes->POST('alat', 'extra\Loadfile::loadalat');
//     $routes->POST('tanah', 'extra\Loadfile::loadtanah');
//     $routes->POST('inventaris', 'extra\Loadfile::loadinventaris');
//     $routes->POST('satuan', 'umum\penjualan\SOSewa::loadsatuan');
//     $routes->POST('bentuk', 'umum\penjualan\SOSewa::loadbentuk');
//     $routes->POST('loadcamp', 'umum\penjualan\SOSewa::loadcamp');
//     $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

//     // $routes->POST('biaya', 'Komponen::loadbiaya');
//     // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
//     // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
// });

// Transaksi Item____________________________________________________________________________________________________________________________
$routes->group('mintabarang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Mintabarang::index');
    $routes->GET('input', 'tritem\pembelian\Mintabarang::crany');
    $routes->GET('input/(:any)', 'tritem\pembelian\Mintabarang::showdata/$1');
    $routes->POST('peminta', 'extra\Loadfile::loaduser');
    $routes->POST('additem', 'tritem\pembelian\Mintabarang::tambahdata');
    $routes->POST('edititem', 'tritem\pembelian\Mintabarang::updatedata');
    $routes->POST('delitem', 'tritem\pembelian\Mintabarang::deletedata');
    $routes->POST('item', 'extra\Loadfile::loadbarang');
    $routes->POST('jasa', 'extra\Loadfile::loadakun');
    $routes->POST('satuan', 'tritem\pembelian\Mintabarang::loadsatuan');
    $routes->GET('modalkoreksi', 'tritem\pembelian\Mintabarang::modaldata');
    $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'tritem\pembelian\Mintabarang::savedata');
    $routes->POST('bataldoc', 'tritem\pembelian\Mintabarang::canceldata');
    $routes->POST('confdoc', 'tritem\pembelian\Mintabarang::confirmdata');
});
$routes->group('cekada', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Cekada::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Cekada::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->POST('additem', 'tritem\pembelian\Cekada::tambahdata');
    $routes->POST('savedoc', 'tritem\pembelian\Cekada::savedata');
    $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
});
$routes->group('cekbarang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Cekbarang::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Cekbarang::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'tritem\pembelian\Cekbarang::savedata');
});
$routes->group('tawarharga', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Tawarharga::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Tawarharga::showdata/$1');
    $routes->POST('additem', 'tritem\pembelian\Tawarharga::tambahdata');
    $routes->POST('edititem', 'tritem\pembelian\Tawarharga::updatedata');
    $routes->POST('delitem', 'tritem\pembelian\Tawarharga::deletedata');
    $routes->POST('suplier', 'extra\Loadfile::loadpenerima');
    $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
    $routes->GET('msuplier', 'extra\Loadfile::modalpenerima');
    $routes->GET('modalkoreksi', 'tritem\pembelian\Tawarharga::modaldata');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarang');
    $routes->GET('tabharga', 'extra\Loadtran::tabelhargatawar');
    // $routes->POST('savedoc', 'tritem\pembelian\Tawarharga::savedata');
});
$routes->group('pilihharga', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pembelian\Pilihharga::index');
    $routes->GET('input/(:any)', 'tritem\pembelian\Pilihharga::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
    $routes->GET('tabharga', 'extra\Loadtran::tabeltawar');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('suplier', 'tritem\pembelian\Pilihharga::pilihpenawaran');
    // $routes->POST('savedoc', 'tritem\pembelian\Pilihharga::savedata');
});

// $routes->group('bandingharga', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'tritem\pembelian\Bandingharga::index');
//     $routes->GET('input/(:any)', 'tritem\pembelian\Bandingharga::showdata/$1');
//     $routes->GET('tabminta', 'extra\Loadtran::tabelmintabarang');
// $routes->GET('showitem', 'Komponen::modalitem');
// $routes->POST('save', 'pembelian\Bandingharga::savedata');
// $routes->POST('penerima', 'Komponen::loadpenerima');
// $routes->GET('tabbarang', 'Komponen::tabelbarang');
// $routes->GET('tabtawar', 'pembelian\Bandingharga::modalpenawaran');
// $routes->POST('deltawar', 'pembelian\Bandingharga::deletepenawaran');
// $routes->POST('pilihtawar', 'pembelian\Bandingharga::pilihpenawaran');
// });
// $routes->group('pesanbarang', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'pembelian\Pesanbarang::index');
//     $routes->GET('input', 'pembelian\Pesanbarang::crany');
//     $routes->GET('input/(:any)', 'pembelian\Pesanbarang::showdata/$1');
//     $routes->GET('tabpesan', 'Komponen::tabelpesanbarang');
//     $routes->POST('penerima', 'Komponen::loadpenerima');
//     $routes->POST('biaya', 'Komponen::loadakun');
//     $routes->GET('dokumen', 'pembelian\Pesanbarang::modaldokumen');
//     $routes->GET('tabbarang', 'pembelian\Pesanbarang::tabelbarang');
//     $routes->GET('tabbiaya', 'pembelian\Pesanbarang::tabelbiaya');
//     $routes->POST('addbiaya', 'pembelian\Pesanbarang::savebiaya');
//     $routes->POST('save/(:any)', 'pembelian\Pesanbarang::savedata/$1');
// });
// $routes->group('terimabarang', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'pembelian\Terimabarang::index');
//     $routes->GET('input/(:any)', 'pembelian\Terimabarang::showdata/$1');
//     $routes->GET('tabpesan', 'Komponen::tabelpesanbarang');
//     $routes->GET('tabbarang', 'pembelian\Terimabarang::tabelbarang');
//     $routes->GET('tabmasuk', 'pembelian\Terimabarang::tabelpomasuk');
//     $routes->POST('save', 'pembelian\Terimabarang::savedata');
// });
// $routes->group('cekpo', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'pembelian\Cekpo::index');
//     $routes->GET('tabpesan', 'Komponen::tabelpesanbarang');
//     $routes->GET('input/(:any)', 'pembelian\Cekpo::showdata/$1');
//     $routes->GET('tabbarang', 'pembelian\Cekpo::tabelbarang');
//     $routes->POST('save', 'pembelian\Cekpo::savedata');
//     $routes->GET('logaksi', 'Komponen::tabellogaksi');
// });

$routes->group('ambilbarang', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'tritem\pengambilan\Ambilbarang::index');
    $routes->GET('input', 'tritem\pengambilan\Ambilbarang::showdata');
    $routes->POST('additem', 'tritem\pengambilan\Ambilbarang::tambahdata');
    $routes->POST('edititem', 'tritem\pengambilan\Ambilbarang::updatedata');
    $routes->POST('delitem', 'tritem\pengambilan\Ambilbarang::deletedata');

    $routes->POST('pegawai', 'extra\Loadfile::loadpenerima');
    $routes->POST('perusahaan', 'tritem\pengambilan\Ambilbarang::loadperusahaan');
    $routes->POST('atk', 'tritem\pengambilan\Ambilbarang::loadatk');
    $routes->POST('atkm', 'tritem\pengambilan\Ambilbarang::loadatk');
    // $routes->POST('satuan', 'tritem\pembelian\Mintabarang::loadsatuan');
    // $routes->GET('modalkoreksi', 'tritem\pembelian\Mintabarang::modaldata');
    // $routes->GET('mbarang', 'extra\Loadfile::modalbarang');
    $routes->GET('tabambil', 'extra\Loadtran::tabelambilbarang');
    $routes->GET('tabbarang', 'extra\Loadtran::tabeldatabarangambil');
    $routes->GET('modalinput', 'tritem\pengambilan\Ambilbarang::modalinput');
    $routes->GET('modalkoreksi', 'tritem\pengambilan\Ambilbarang::modaldata');

    // $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('saveatk', 'tritem\pengambilan\Ambilbarang::saveatk');
    // $routes->POST('bataldoc', 'tritem\pembelian\Mintabarang::canceldata');
    // $routes->POST('confdoc', 'tritem\pembelian\Mintabarang::confirmdata');

});

// Proyek____________________________________________________________________________________________________________________________
// $routes->group('anggproyekbl', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'proyek\anggaran\BiayaL::index');
//     $routes->GET('input', 'proyek\anggaran\BiayaL::crany');
//     $routes->GET('input/(:any)', 'proyek\anggaran\BiayaL::showdata/$1');
//     $routes->POST('addbudget', 'proyek\anggaran\BiayaL::tambahdata');
//     $routes->POST('savedoc', 'proyek\anggaran\BiayaL::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'proyek\anggaran\Biayatidaklangsung::canceldokumen/$1');
//     $routes->GET('tabanginduk', 'extra\Loadtran::tabelanggaraninduk');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
//     $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
//     $routes->GET('tabbudget', 'extra\Loadtran::tabelanggarananak');
//     $routes->POST('loadbudget', 'proyek\anggaran\BiayaL::loadbudgetbawaan');
//     // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
//     $routes->POST('delbudget', 'proyek\anggaran\BiayaL::deletedata');
// });
// $routes->group('anggproyekbtl', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'proyek\anggaran\BiayaTL::index');
//     $routes->GET('input', 'proyek\anggaran\BiayaTL::crany');
//     $routes->GET('input/(:any)', 'proyek\anggaran\BiayaTL::showdata/$1');
//     $routes->POST('addbudget', 'proyek\anggaran\BiayaTL::tambahdata');
//     $routes->POST('savedoc', 'proyek\anggaran\BiayaTL::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'proyek\anggaran\Biayatidaklangsung::canceldokumen/$1');
//     $routes->GET('tabanginduk', 'extra\Loadtran::tabelanggaraninduk');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
//     $routes->GET('tabbudget', 'extra\Loadtran::tabelanggarananak');
//     $routes->POST('loadbudget', 'proyek\anggaran\BiayaTL::loadbudgetbawaan');
//     // $routes->GET('editkas', 'proyek\anggaran\Biayatidaklangsung::modalkoreksikas');
//     $routes->POST('delbudget', 'proyek\anggaran\BiayaTL::deletedata');
// });
// $routes->group('accbudget', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'proyek\anggaran\Accbudget::index');
//     $routes->GET('input/(:any)', 'proyek\anggaran\Accbudget::showdata/$1');
//     $routes->POST('addbudget', 'proyek\anggaran\Accbudget::tambahdata');
//     $routes->POST('savedoc', 'proyek\anggaran\Accbudget::savedokumen');
//     $routes->GET('bataldoc/(:any)', 'proyek\anggaran\Accbudget::canceldokumen/$1');
//     $routes->GET('tabbudget', 'extra\Loadtran::tabelbudgetinduk');
//     $routes->GET('proyek', 'extra\Loadfile::modalproyek');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
//     $routes->POST('biaya', 'extra\Loadfile::loadbiaya');
//     $routes->GET('tabbudgetitem', 'extra\Loadtran::tabelbudgetanak');

//     // $routes->GET('editkas', 'proyek\anggaran\Biayalangsung::modalkoreksikas');
//     $routes->POST('delitem', 'proyek\anggaran\Biayalangsung::deletedata');
// });

// ALAT____________________________________________________________________________________________________________________________
$routes->group('sewaalat', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\order\Sewaalat::index');
    $routes->GET('input', 'alat\order\Sewaalat::crany');
    $routes->GET('input/(:any)', 'alat\order\Sewaalat::showdata/$1');
    $routes->POST('addjual', 'alat\order\Sewaalat::tambahdata');
    // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
    // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
    $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
    $routes->GET('proyek', 'extra\Loadfile::modalproyek');
    $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
    $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
    $routes->POST('alat', 'extra\Loadfile::loadalat');
    $routes->POST('bentuk', 'alat\order\Sewaalat::loadbentuk');
    $routes->POST('loadcamp', 'alat\order\Sewaalat::loadcamp');
    $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});
$routes->group('tiketproyek', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\tiket\Tiketproyek::index');
    $routes->POST('addtiket', 'alat\tiket\Tiketproyek::tambahdata');
    $routes->GET('camp', 'extra\Loadfile::modalcamp');
    $routes->POST('docjual', 'alat\tiket\Tiketproyek::loadsojual');
    $routes->POST('gantidocjual', 'alat\tiket\Tiketproyek::outfocusdocjual');
    $routes->POST('gantiruas', 'alat\tiket\Tiketproyek::outfocusruas');
    $routes->POST('gantidocsewa', 'alat\tiket\Tiketproyek::outfocusdocsewa');
    $routes->POST('gantijasa', 'alat\tiket\Tiketproyek::outfocusjasa');
    $routes->POST('gantibarang', 'alat\tiket\Tiketproyek::outfocusbarang');
    $routes->POST('alat', 'alat\tiket\Tiketproyek::loadalat');
    $routes->POST('gantialat', 'alat\tiket\Tiketproyek::outfocusalat');
    $routes->POST('supir', 'extra\Loadfile::loadpenerima');
    $routes->POST('gantisupir', 'alat\tiket\Tiketproyek::outfocussupir');
    $routes->GET('tabtiket', 'extra\Loadtran::tabeltiket');

    // $routes->GET('beban', 'Komponen::modalbeban');
    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('tabitembiaya', 'Komponen::tabelbudgetanak');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});
$routes->group('cektiket', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\tiket\Cektiket::index');
    $routes->POST('notiket', 'alat\tiket\Cektiket::loadtiket');
    $routes->POST('datatiket', 'alat\tiket\Cektiket::outfocustiket');
    $routes->POST('save', 'alat\tiket\Cektiket::savedata');

    // $routes->GET('camp', 'extra\Loadfile::modalcamp');

    // $routes->GET('input', 'camp\tiket\Cektiket::showdata');
    // $routes->POST('loadproyek', 'file\aset\Ruas::loadproyek');
    // $routes->POST('gantidokumen', 'camp\tiket\Cektiket::outfocusdokumen');
    // $routes->GET('tabtiket', 'extra\Loadtran::tabeltiket');
    // $routes->POST('loadproyek', 'extra\Loadfile::loadproyek');
});

$routes->group('tsproyek', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'alat\tiket\Tsproyek::index');
    // $routes->POST('addtiket', 'alat\tiket\Tsproyek::tambahdata');
    // $routes->GET('camp', 'extra\Loadfile::modalcamp');
    $routes->POST('docsewa', 'alat\tiket\Tsproyek::loadsosewa');
    // $routes->POST('gantidocjual', 'alat\tiket\Tsproyek::outfocusdocjual');
    // $routes->POST('gantiruas', 'alat\tiket\Tsproyek::outfocusruas');
    // $routes->POST('gantidocsewa', 'alat\tiket\Tsproyek::outfocusdocsewa');
    // $routes->POST('gantibahan', 'alat\tiket\Tsproyek::outfocusbahan');
    // $routes->POST('alat', 'alat\tiket\Tsproyek::loadalat');
    // $routes->POST('gantialat', 'alat\tiket\Tsproyek::outfocusalat');
    // $routes->POST('supir', 'extra\Loadfile::loadpenerima');
    // $routes->POST('gantisupir', 'alat\tiket\Tsproyek::outfocussupir');
    // $routes->GET('tabtiket', 'extra\Loadtran::tabeltiket');

    // $routes->GET('beban', 'Komponen::modalbeban');
    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('tabitembiaya', 'Komponen::tabelbudgetanak');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});
// CAMP____________________________________________________________________________________________________________________________
$routes->group('jualbahan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'camp\order\Jualbahan::index');
    $routes->GET('input', 'camp\order\Jualbahan::crany');
    $routes->GET('input/(:any)', 'camp\order\Jualbahan::showdata/$1');
    $routes->POST('addjual', 'camp\order\Jualbahan::tambahdata');
    // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
    // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
    $routes->GET('tabsales', 'extra\Loadtran::tabelsalesinduk');
    $routes->GET('camp', 'extra\Loadfile::modalcamp');
    $routes->GET('proyek', 'extra\Loadfile::modalproyek');
    $routes->POST('penerima1', 'extra\Loadfile::loadpenerima1');
    $routes->POST('pelanggan', 'extra\Loadfile::loadpenerima');
    $routes->POST('item', 'extra\Loadfile::loadbarang');
    $routes->POST('satuan', 'camp\order\Jualbahan::loadsatuan');
    $routes->POST('loadcamp', 'camp\order\Jualbahan::loadcamp');
    $routes->GET('tabsalesitem', 'extra\Loadtran::tabelsalesanak');

    // $routes->POST('biaya', 'Komponen::loadbiaya');
    // $routes->GET('editkas', 'camp\Biayalangsung::modalkoreksikas');
    // $routes->POST('delitem', 'camp\Biayalangsung::deletedata');
});

// Cash Transaction ___________________________________________________________________________________________________________________________________________________________________________________________
// $routes->group('kaspindah', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\mintakas\KasPindah::index');
//     $routes->GET('input', 'kas\mintakas\KasPindah::inputData');
//     $routes->POST('cari', 'campur\LoadTransaksi::tabelKasinduk');
//     $routes->POST('save', 'kas\mintakas\KasPindah::saveData');
//     $routes->GET('klikbeban', 'campur\LoadMain::modalBeban');
//     $routes->POST('peminta', 'campur\LoadMain::loadUser');
//     $routes->POST('penerima', 'campur\LoadMain::loadPenerima');
//     $routes->POST('akun', 'campur\LoadMain::loadAkun');
// });

// $routes->group('project', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'main\asset\Project::index');
//     $routes->GET('input', 'main\asset\Project::inputData');
//     $routes->POST('search', 'main\asset\Project::searchData');
//     $routes->POST('save', 'main\asset\Project::saveData');
//     $routes->POST('district', 'main\asset\Project::loadDistrict');
//     $routes->POST('offFocusProject', 'main\asset\Project::offFocusProject');
// });

$routes->group('directcash', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trcash\expense\Directcash::index');
    $routes->GET('input', 'trcash\expense\Directcash::inputData');
    $routes->GET('table1', 'trcash\expense\Directcash::tableAP');
    $routes->GET('table2', 'trcash\expense\Directcash::tableCash');
    $routes->POST('add', 'trcash\expense\Directcash::addData');
    // $routes->POST('save', 'trgeneral\budget\AccountBudget::saveData');


    // $routes->GET('input', 'trgeneral\budget\AccountBudget::inputData');
    // $routes->GET('table', 'trgeneral\budget\AccountBudget::tableData');
    // $routes->POST('save', 'trgeneral\budget\AccountBudget::saveData');
    // // $routes->POST('edititem', 'trumum\anggaran\Objek::updatedata');

    // $routes->POST('save', 'trcash\expense\Directcash::saveData');
    // $routes->POST('cancel', 'trcash\expense\Directcash::cancelData');
});
$routes->group('advancepayment', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trcash\expense\Advancepayment::index');
    $routes->GET('input', 'trcash\expense\Advancepayment::inputData');
    // $routes->POST('save', 'trcash\expense\Advancepayment::saveData');
    // $routes->POST('cancel', 'trcash\expense\Advancepayment::cancelData');
});
$routes->group('cashtransfer', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trcash\expense\Cashtransfer::index');
    $routes->GET('input', 'trcash\expense\Cashtransfer::inputData');
    // $routes->POST('save', 'trcash\expense\Cashtransfer::saveData');
    // $routes->POST('cancel', 'trcash\expense\Cashtransfer::cancelData');
});

$routes->group('uangjalan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'kas\mintakas\UangJalan::index');
    $routes->GET('input', 'kas\mintakas\UangJalan::inputData');
    $routes->POST('cari', 'campur\LoadTransaksi::tabelKasinduk');
    $routes->POST('save', 'kas\mintakas\UangJalan::saveData');
    $routes->POST('penerima', 'campur\LoadMain::loadPenerima');
    $routes->POST('supir', 'campur\LoadMain::loadPenerima');
    $routes->POST('klikpenerima', 'kas\mintakas\UangJalan::outfocusPenerima');
    $routes->POST('kliksupir', 'kas\mintakas\UangJalan::outfocusSupir');
});
// ____________________________________________________________________________________________________________________________
$routes->group('cekkas', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'kas\cekkas\CekKas::index');
    $routes->GET('input', 'kas\cekkas\CekKas::inputData');
    $routes->POST('cari', 'campur\LoadTransaksi::tabelKasinduk');
    $routes->POST('save', 'kas\cekkas\CekKas::saveData');
});
// $routes->group('kaspindah', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kaspindah::index');
//     $routes->GET('input', 'kas\Kaspindah::crany');
//     $routes->GET('input/(:any)', 'kas\Kaspindah::showdata/$1');
//     $routes->POST('save', 'kas\Kaspindah::savedata');
//     $routes->GET('bataldoc/(:any)', 'kas\Kaspindah::canceldokumen/$1');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('beban', 'Komponen::modalbeban');
//     $routes->POST('akun', 'Komponen::loadakun');
//     $routes->GET('tabkas', 'Komponen::tabelkas');
//     $routes->GET('addlampir', 'kas\Kaspindah::modallampiran');
//     $routes->POST('savelampir', 'kas\Kaspindah::savelampiran');
//     $routes->POST('dellampir', 'kas\Kaspindah::deletelampiran');
// });


// $routes->group('kaslangsung', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'trkas\pengeluaran\Kaslangsung::index');
//     $routes->GET('input', 'trkas\pengeluaran\Kaslangsung::crany');
//     $routes->GET('input/(:any)', 'trkas\pengeluaran\Kaslangsung::showdata/$1');
//     $routes->POST('peminta', 'extra\Loadfile::loaduser');

//     $routes->POST('additem', 'trkas\pengeluaran\Kaslangsung::tambahdata');
//     // $routes->POST('edititem', 'trkas\pengeluaran\Kaslangsung::updatedata');
//     // $routes->POST('delitem', 'trkas\pengeluaran\Kaslangsung::deletedata');

//     // $routes->POST('savedoc', 'kas\Kaslangsung::savedokumen');
//     // $routes->GET('bataldoc/(:any)', 'kas\Kaslangsung::canceldokumen/$1');
//     // $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     // $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('tabminta', 'extra\Loadtran::tabelmintakas');

//     $routes->GET('beban', 'extra\Loadfile::modalbeban');
//     $routes->POST('penerima', 'extra\Loadfile::loadpenerima');
//     $routes->POST('ruas', 'extra\Loadfile::loadruas');
//     $routes->POST('anggaran', 'extra\Loadtran::loadanggaran');
//     // $routes->POST('biaya', 'extra\Loadfile::loadbiaya');

//     // $routes->POST('akun', 'extra\Loadfile::loadakun');

//     // $routes->POST('ruas', 'Komponen::loadruas');
//     // $routes->POST('biaya', 'Komponen::loadbiaya');
//     $routes->POST('sumberdaya', 'extra\loadfile::loadbiaya');
//     // $routes->POST('akun', 'Komponen::loadakun');

//     $routes->GET('tabkas', 'extra\loadtran::tabeldatakas');
//     // $routes->GET('editkas', 'kas\Kaslangsung::modalkoreksikas');
//     // $routes->POST('delkas', 'kas\Kaslangsung::deletedata');
//     // $routes->GET('tabbiaya', 'extra\Loadtran::tabelbiayaanggaran');
// });

// $routes->group('kasum', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kasum::index');
//     $routes->GET('input', 'kas\Kasum::crany');
//     $routes->GET('input/(:any)', 'kas\Kasum::showdata/$1');
//     $routes->POST('save', 'kas\Kasum::savedata');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('beban', 'Komponen::modalbeban');
//     $routes->POST('penerima', 'Komponen::loadpenerima');
//     $routes->POST('akun', 'kas\Kasum::loadakun');
//     $routes->POST('supir', 'Komponen::loadpegawai');
//     $routes->POST('barang', 'Komponen::loadbarang');
//     $routes->GET('tabkas', 'Komponen::tabelkas');
//     $routes->POST('delkas', 'kas\Kasum::deletekas');
// });
// $routes->group('kasnonlangsung', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kasnonlangsung::index');
//     $routes->GET('input', 'kas\Kasnonlangsung::crany');
//     $routes->GET('input/(:any)', 'kas\Kasnonlangsung::showdata/$1');
//     $routes->POST('save', 'kas\Kasnonlangsung::savedata');
//     $routes->POST('updatedoc', 'kas\Kasnonlangsung::updatedokumen');
//     $routes->GET('bataldoc/(:any)', 'kas\Kasnonlangsung::canceldokumen/$1');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('user', 'Komponen::modaluser');
//     $routes->GET('beban', 'Komponen::modalbeban');
//     $routes->POST('penerima', 'Komponen::loadpenerima');
//     $routes->POST('ruas', 'Komponen::loadruas');
//     $routes->POST('biaya', 'Komponen::loadbiaya');
//     $routes->POST('sumberdaya', 'Komponen::loadbiaya');
//     $routes->POST('akun', 'Komponen::loadakun');
//     $routes->POST('kbli', 'Komponen::loadkbli');
//     $routes->GET('tabkas', 'Komponen::tabelkas');
//     $routes->GET('koreksikas', 'kas\Kaslangsung::modalkoreksi');
//     $routes->POST('delkas', 'kas\Kaslangsung::deletekas');
//     $routes->GET('tabuangmuka', 'kas\Kasnonlangsung::tabeluangmuka');
//     $routes->GET('adduangmuka', 'kas\Kasnonlangsung::modaluangmuka');
//     $routes->POST('saveuangmuka', 'kas\Kasnonlangsung::saveuangmuka');
// });

$routes->group('keuangan', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trkas\pengeluaran\Keuangan::index');
    $routes->GET('input/(:any)', 'trkas\pengeluaran\Keuangan::showdata/$1');
    $routes->POST('pajakitem', 'trkas\pengeluaran\Keuangan::pajakdata');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintakas');
    $routes->GET('tabkas', 'extra\loadtran::tabeldatakas');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'trkas\pengeluaran\Keuangan::savedata');
});
$routes->group('potongpajak', ['filter' => 'auth'],  function ($routes) {
    $routes->GET('/', 'trkas\pengeluaran\Potongpajak::index');
    $routes->GET('input/(:any)', 'trkas\pengeluaran\Potongpajak::showdata/$1');
    $routes->GET('tabminta', 'extra\Loadtran::tabelmintakas');
    $routes->GET('tabkas', 'extra\loadtran::tabeldatakas');
    $routes->GET('logaksi', 'extra\Loadtran::tabellogaksi');
    $routes->POST('savedoc', 'trkas\pengeluaran\Potongpajak::savedata');
});
// $routes->group('kasir', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'kas\Kasir::index');
//     $routes->GET('tabminta', 'Komponen::tabelmintakas');
//     $routes->GET('input/(:any)', 'kas\Kasir::showdata/$1');
//     $routes->GET('tabkas', 'Komponen::tabeldatakas');
//     $routes->POST('savedoc/(:any)', 'kas\Kasir::savedokumen/$1');
// });

// HRD____________________________________________________________________________________________________________________________


// $routes->group('itmk', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'hrd\Itmk::index');
//     $routes->GET('input', 'hrd\Itmk::crany');
//     $routes->GET('input/(:any)', 'hrd\Itmk::showdata/$1');
//     $routes->POST('save/(:any)', 'hrd\Itmk::savedata/$1');
//     $routes->POST('pegawai', 'Komponen::loadpegawai');
//     $routes->POST('detilpegawai', 'hrd\Itmk::loadpegawai');
//     $routes->GET('tabminta', 'Komponen::tabelmintacuti');
// });
// $routes->group('cekitmk', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'hrd\Cekitmk::index');
//     $routes->GET('input/(:any)', 'hrd\Cekitmk::showdata/$1');
//     $routes->POST('save/(:any)', 'hrd\Cekitmk::savedata/$1');
//     $routes->GET('tabminta', 'Komponen::tabelmintacuti');
//     $routes->GET('logaksi', 'Komponen::tabellogaksi');
// });
// $routes->group('nilaipegawai', ['filter' => 'auth'],  function ($routes) {
//     $routes->GET('/', 'hrd\Nilaipegawai::index');
//     $routes->GET('input', 'hrd\Nilaipegawai::crany');
//     $routes->GET('input/(:any)', 'hrd\Nilaipegawai::showdata/$1');
//     // $routes->POST('save/(:any)', 'hrd\Nilaipegawai::savedata/$1');
//     $routes->POST('pegawai', 'Komponen::loadpegawai');
//     $routes->POST('detilpegawai', 'hrd\Itmk::loadpegawai');
//     $routes->GET('tabminta', 'Komponen::tabelnilaipegawai');
// });
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

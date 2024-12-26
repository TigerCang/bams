<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Libraries\Menu;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $session;
    protected $validation;
    protected $user;
    protected $menu;
    protected $level;

    // protected $language;
    // protected $logModel;
    // protected $userModel;
    // protected $roleModel;
    // protected $configModel;
    // protected $iduModel;
    // protected $mainModel;
    // protected $tranModel;

    // protected $urls;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    // protected $helpers = [];
    protected $helpers = ['url', 'form', 'mix_helper', 'data_helper', 'generate_helper'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        // Preload any models, libraries, etc, here.

        // Initialization request dan session
        $this->request = $request;
        $this->session = session();

        // Initialization model dan another library 
        $this->userModel = new \App\Models\admin\UserModel();
        $this->roleModel = new \App\Models\admin\RoleModel();
        $this->configModel = new \App\Models\admin\ConfigModel();
        $this->logModel = new \App\Models\admin\LogModel();
        $this->mainModel = new \App\Models\mix\MainModel();
        $this->transModel = new \App\Models\mix\TransModel();

        // Set language based on session
        $this->language = service('language');
        $this->language->setLocale($this->session->lang);
        $this->validation = \Config\Services::validation();

        $this->user = $this->userModel->getUser(decrypt($this->session->username));
        $this->menu = $this->roleModel->getRole($this->user['role_id'] ?? '');
        $this->level = $this->configModel->getConfig('level approve');
        $this->urls = explode('/', $_SERVER['REQUEST_URI']);

        // Language
        // $request = \Config\Services::request();
        // $this->session = \Config\Services::session();

        // $this->anu = $this->konfigurasiModel->getKonfigurasi();
        // $this->levacc = (isset($this->user['acc_setuju']) ? ($this->user['acc_setuju'] == '0' ? $this->level[0]['nilai'] : $this->user['acc_setuju'] - 1) : '0');
        $menuData = $this->menu ?? ['menu_1' => '', 'menu_2' => '', 'menu_3' => '', 'menu_4' => '', 'menu_5' => '', 'menu_6' => '', 'menu_7' => '', 'menu_8' => '', 'menu_9' => ''];
        Menu::setMenu($menuData);
        Menu::setUser($this->user);
        helper(['text', 'session', 'filesystem']);
    }

    /**
     * Method to render views with common data.
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    protected function render($view, $data = [])
    {
        $commonData = [
            'template' => (splitUser('template', $this->user)[0]),
            'this_level' => $this->level[0]['value'],
        ];
        $data = array_merge($commonData, $data);
        echo view($view, $data);
    }
}

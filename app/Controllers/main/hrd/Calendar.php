<?php

namespace App\Controllers\main\hrd;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\CalendarModel;

class Calendar extends BaseController
{
    protected $calendarModel;
    public function __construct()
    {
        $this->calendarModel = new CalendarModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function index()
    {
        checkPage('143');
        $year = date('Y');
        $data = [
            't_title' => lang('app.holiday calendar'),
            't_span' => lang('app.span holiday calendar'),
            'link' => '/calendar',
            'calendar' => $this->mainModel->getCalendar($year),
        ];
        $this->render('main/hrd/calendar_list', $data);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function inputData()
    {
        if ($this->request->isAJAX()) {
            checkPage('143', '', 'y', 'n');
            $data = [
                't_modal' => lang('app.holiday calendar'),
                'link' => "/calendar",
            ];
            $msg = ['data' => view('main/hrd/calendar_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function saveData()
    {
        if ($this->request->isAJAX()) {
            $validationRules = [
                'dateStart' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'description' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'dateStart' => $this->validation->getError('dateStart'),
                        'description' => $this->validation->getError('description'),
                    ]
                ];
            } else {
                $dateStart = strtotime($this->request->getVar('dateStart'));
                $dateEnd = strtotime($this->request->getVar('dateEnd'));
                $dayInput = date('N', strtotime($this->request->getVar('dateStart')));
                $dayDate = array();

                do {
                    $day = date('N', $dateStart);
                    if ($day == $dayInput) $dayDate[] = date('Y-m-d', $dateStart);
                    $dateStart = strtotime('+1 day', $dateStart);
                } while ($dateStart <= $dateEnd);

                foreach ($dayDate as $date) {
                    $data = [
                        'unique' => create_Unique(),
                        'name' => $this->request->getVar('description'),
                        'cut_day' => ($this->request->getVar('cut') == 'on' ? '1' : '0'),
                        'save_by' => $this->user['id'],
                    ];
                    $db = $this->mainModel->getDate($date);
                    if (empty($db)) $this->calendarModel->save(['day_date' => $date] + $data);
                }
                $menu = $this->mainModel->searchID('m_calendar', 'last');
                $strDate = date('d/m/Y', strtotime($this->request->getVar('dateStart')));
                $this->logModel->saveLog('Save', $menu[0]->id, $strDate);
                $this->session->setFlashdata(['message' => $strDate . " " . lang("app.title save")]);
                $msg = ['redirect' => '/calendar'];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function deleteData()
    {
        if ($this->request->isAJAX()) {
            $db1 = $this->mainModel->getData('m_calendar', $this->request->getVar('unique'));
            $id = $db1[0]->id ?? '';
            $dateDay = (date('d-m-Y', strtotime($this->request->getVar('date'))));
            $this->calendarModel->delete($id);
            $this->logModel->saveLog('Save', $this->request->getVar('unique'), $dateDay);
            $this->session->setFlashdata(['message' => $dateDay . ' ' . lang("app.title delete")]);
            $msg = ['redirect' => '/calendar'];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }
}

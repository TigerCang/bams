<?php

namespace App\Controllers\mix;

use Config\App;
use App\Controllers\BaseController;
use App\Models\main\AttachmentModel;

class Attachment extends BaseController
{
    protected $attachmentModel;
    public function __construct()
    {
        $this->attachmentModel = new AttachmentModel();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function table()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'attachment' => $this->attachmentModel->getAttachment($this->request->getVar('object'), $this->request->getVar('unique')),
                'objHidden' => $this->request->getVar('object'),
            ];
            $msg = ['data' => view('x-main/attachment_table', $data)];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function modal()
    {
        if ($this->request->isAJAX()) {
            $ska = $this->request->getVar('ska');
            $data = [
                't_modal' => 'Attachment',
                'unique' => $this->request->getVar('unique'),
                'object' => $this->request->getVar('object'),
                'selectAssociation' => $this->mainModel->distItem('m_attachment', 'association', 'object', 'employee'),
                'ska' => $ska,
                'sHid' => ($ska == '0' ? 'hidden' : ''),
                'tHid' => ($ska == '1' ? 'hidden' : ''),
            ];
            $msg = ['data' => view('x-modal/attachment_input', $data)];
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function save()
    {
        if ($this->request->isAJAX()) {
            $ruleA = ($this->request->getVar('skat') == '1' ? 'required' : 'permit_empty');
            $ruleB = ($this->request->getVar('skat') == '0' ? 'required' : 'permit_empty');
            $validationRules = [
                'qualificationAttachment' => ['rules' => $ruleA, 'errors' => ['required' => lang("app.err blank")]],
                'registrationNumber' => ['rules' => $ruleA, 'errors' => ['required' => lang("app.err blank")]],
                'titleAttachment' => ['rules' => $ruleB, 'errors' => ['required' => lang("app.err blank")]],
                'descriptionAttachment' => ['rules' => $ruleB, 'errors' => ['required' => lang("app.err blank")]],
                'startDate' => ['rules' => 'required', 'errors' => ['required' => lang("app.err blank")]],
                'attachment' => [
                    'rules' => 'uploaded[attachment]|max_size[attachment,20480]|ext_in[attachment,pdf]',
                    'errors' => ['uploaded' => lang("app.err blank"), 'max_size' => lang("app.err file20"), 'ext_in' => lang("app.err fileExt")]
                ]
            ];

            if (!$this->validate($validationRules)) {
                $msg = [
                    'error' => [
                        'qualificationAttachment' => $this->validation->getError('qualificationAttachment'),
                        'registrationNumber' => $this->validation->getError('registrationNumber'),
                        'titleAttachment' => $this->validation->getError('titleAttachment'),
                        'descriptionAttachment' => $this->validation->getError('descriptionAttachment'),
                        'startDate' => $this->validation->getError('startDate'),
                        'attachment' => $this->validation->getError('attachment'),
                    ]
                ];
            } else {
                $valueSka = ($this->request->getVar('skat') == '1' ? $this->request->getVar('ska') : '');
                $valueLevel = ($this->request->getVar('skat') == '1' ? $this->request->getVar('levelAttachment') : '');
                $attachment = $this->request->getFile('attachment');
                $attachment->move('assets/attachment/' . $this->request->getVar('object'));
                $attachment_name = $attachment->getName();

                $this->attachmentModel->save([
                    'unique' => create_Unique(),
                    'object' => $this->request->getVar('object'),
                    'object_uniq' => $this->request->getVar('unique'),
                    'title' => $this->request->getVar('titleAttachment'),
                    'description' => $this->request->getVar('descriptionAttachment'),
                    'ska' => $valueSka,
                    'level' => $valueLevel,
                    'qualification' => $this->request->getVar('qualificationAttachment'),
                    'registration_number' => $this->request->getVar('registrationNumber'),
                    'association' => $this->request->getVar('associationAttachment') ?? '',
                    'year' => $this->request->getVar('yearAttachment'),
                    'start_date' => $this->request->getVar('startDate'),
                    'end_date' => $this->request->getVar('endDate'),
                    'attachment' => $attachment_name,
                    'is_active' => '1',
                    'save_by' => $this->user['id'],
                ]);
                $msg = ['message' => "{$this->request->getVar('titleAttachment')}" . lang('app.title add')];
            }
            return $this->response->setJSON($msg);
        } else {
            exit('out');
        }
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $this->lampiranModel->delete($id);
            unlink('assets/berkas/' . $this->request->getVar('xpilih') . '/' . $this->request->getVar('lampiran')); //hapus file lama
            $msg = ['sukses' => $this->request->getVar('judul') . ' ' . lang("app.judulhapus")];
            echo json_encode($msg);
        } else {
            exit('out');
        }
    }
}

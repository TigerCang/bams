<?php

namespace App\Models\mix;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\MySQLi\Builder;

class MainModel
{
    protected $db;
    public function __construct()
    {
        $this->db = \config\Database::connect(); //change with db_connect();
        // $this->db = db_connect();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function getData($table, $data, $log = 'n', $field = 'unique', $active = false, $delete = false)
    {
        if ($log == 'u') {
            $builder = $this->db->table("$table a");
            $builder->select('a.*, p.code as saveBy, q.code as confirmBy, r.code as activeBy');
            $builder->where("a.$field", $data)->where(['a.deleted_at' => null]);
            // if ($aktif == true) $builder->where('is_confirm', '1')->where('is_aktif', '1');
            $builder->join('m_user p', 'p.id = a.save_by', 'left');
            $builder->join('m_user q', 'q.id = a.confirm_by', 'left');
            $builder->join('m_user r', 'r.id = a.active_by', 'left');
        } else {
            $builder = $this->db->table($table);
            $builder->where("$field", $data);
            if ($active == true) $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
            // if ($delete == false) $builder->where(['deleted_at' => null]);
        }
        return $builder->get()->getResult();
    }
    public function cekData($table, $fieldFilter, $fieldSearch, $fieldFilter2, $fieldSearch2, $unique)
    {
        $builder = $this->db->table("$table");
        $builder->where($fieldFilter, $fieldSearch);
        if ($fieldFilter2 != '') $builder->where($fieldFilter2, $fieldSearch2);
        $builder->where('unique !=', $unique)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function cekLink($table, $fieldFilter, $fieldSearch, $fieldFilter2 = false, $fieldSearch2 = false)
    {
        $builder = $this->db->table("$table");
        $builder->where($fieldFilter, $fieldSearch);
        if ($fieldFilter2 == true) $builder->where($fieldFilter2, $fieldSearch2);
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function searchID($table, $model)
    {
        $builder = $this->db->table($table);
        if ($model == 'last') {
            $builder->orderBy('id desc');
            $builder->limit(1);
            return $builder->get()->getResult();
        } elseif ($model == 'count') {
            $builder->where(['deleted_at' => null]);
            return $builder->countAllResults();
        }
    }

    public function distSelect($param, $group = false)
    {
        $builder = $this->db->table('m_select');
        ($group == false) ? $builder->select('*') : $builder->select('group')->distinct();
        $builder->where('param', $param);
        $builder->orderBy('number');
        return $builder->get()->getResult();
    }
    public function distItem($table, $field, $field_filter = false, $field_search = false)
    {
        $builder = $this->db->table($table);
        $builder->select('*')->where("$field !=", '');
        if ($field_filter == true) $builder->where($field_filter, $field_search);
        $builder->where(['deleted_at' => null]);
        $builder->groupBy($field)->orderBy($field);
        return $builder->get()->getResult();
    }

    public function updateData($table, $field, $data, $filter1, $data_filter1, $filter2 = false, $data_filter2 = false)
    {
        $builder = $this->db->table($table);
        $builder->set($field, $data);
        $builder->where($filter1, $data_filter1);
        if ($filter2 == true) $builder->where($filter2, $data_filter2);
        $builder->update();
    }
    public function updateDeletedAt($table, $id, $delete = false)
    {
        $builder = $this->db->table($table);
        $builder->where('id', $id);
        $builder->update(['deleted_at' => null]);
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function getRole($menu, $active = false)
    {
        $builder = $this->db->table('m_role a');
        $builder->select('a.*, (select count(b.id) from m_user b where b.role_id = a.id) as sumUser, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_user b', 'b.role_id = a.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.name');
        return $builder->get()->getResult();
    }
    public function cekRole($name, $unique)
    {
        $builder = $this->db->table('m_role');
        $builder->where('name', $name)->where('unique !=', $unique);
        return $builder->get()->getResult();
    }

    public function getUser($menu, $supervisor = false, $active = false)
    {
        $builder = $this->db->table('m_user a');
        $builder->select('a.*, b.name as role, c.name as person_name, d.person as person, x.id as xLog');
        if ($supervisor == true) $builder->where('a.supervisor_id', $supervisor);
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('m_role b', 'a.role_id = b.id', 'left');
        $builder->join('m_person c', 'a.id = c.user_id', 'left');
        $builder->join('user_token d', 'a.token_id = d.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->where(['a.deleted_at' => null]);
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }
    public function get1User($data, $declaration = false)
    {
        $builder = $this->db->table('m_user a');
        $builder->select('a.*, b.name as role, c.name as employee_name');
        $builder->where('a.id', $data)->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($declaration == false) $builder->where('substring(c.adaptation, 2, 1)', '1')->where('substring(c.adaptation, 3, 1)', '1');
        $builder->join('m_role b', 'a.role_id=b.id', 'left');
        $builder->join('m_person c', 'a.id=c.user_id', 'left');
        $builder->where(['a.deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function loadUser($isi, $idUser = false, $employee = false)
    {
        $builder = $this->db->table('m_user a');
        $builder->select('a.*, b.name as role, c.id as employee_id, c.name as employeeName');
        ($idUser == true ? $builder->where('a.id', $idUser) : $builder->where("(a.code like \"%$isi%\" or c.name like \"%$isi%\")"));
        $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $joinCondition = ($employee != '' ? 'inner' : 'left');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_role b', 'a.role_id=b.id', 'left');
        $builder->join('m_person c', 'a.id=c.user_id', $joinCondition);
        $builder->orderBy('a.code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }

    public function getToken($menu, $id = false)
    {
        $builder = $this->db->table('user_token a');
        $builder->select('a.*, b.code as user');
        if ($id == true) $builder->where('a.id', $id);
        $builder->join('m_user b', 'a.save_by = b.id', 'left');
        $builder->groupBy('a.id')->orderBy('a.created_at desc');
        return $builder->get()->getResult();
    }
    public function cekToken($token)
    {
        $builder = $this->db->table('user_token');
        $builder->where('token', $token)->where('is_use', '0');
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }

    public function getLog($isi, $username = false, $source = 'a')
    {
        $builder = $this->db->table('user_log');
        $builder->where("(menu like \"%$isi%\" or data like \"%$isi%\")");
        if ($username == true) $builder->where('username', $username);
        $builder->where('source', $source);
        $builder->orderBy('id desc');
        $builder->limit(25 * quantityLimit);
        return $builder->get()->getResult();
    }

    public function getUserReset()
    {
        $builder = $this->db->table('m_user a');
        $builder->select('a.code, a.unique as unique, b.code as code_employee, b.eid, b.name, c.code as company, d.name as region, e.name as division');
        $builder->where('is_reset',  '1');
        $builder->join('m_person b', 'b.user_id = a.id', 'left');
        $builder->join('m_company c', 'b.company_id = c.id', 'left');
        $builder->join('m_file d', 'b.region_id = d.id', 'left');
        $builder->join('m_file e', 'b.division_id = e.id', 'left');
        $builder->orderBy('a.code');
        return $builder->get()->getResult();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function getCompany($menu, $active = false)
    {
        $builder = $this->db->table('m_company a');
        $builder->select('a.*, b.code as person_code, b.name as person_name, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('m_person b', 'b.id = a.person_id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->where(['a.deleted_at' => null]);
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }
    public function getCompanyAddress($company)
    {
        $builder = $this->db->table('company_address');
        $builder->where('company_id', $company)->where(['deleted_at' => null]);
        $builder->orderBy('status desc');
        return $builder->get()->getResult();
    }
    public function getCompanyPerson($company, $param)
    {
        $builder = $this->db->table('company_person');
        $builder->where('company_id', $company)->where(['deleted_at' => null]);
        $builder->where('param', $param);
        $builder->orderBy('id');
        return $builder->get()->getResult();
    }
    public function sumCompany($company)
    {
        $builder = $this->db->table('company_person');
        $builder->select('sum(quantity) as subQuantity');
        $builder->where('company_id', $company)->where('param', 'share')->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }

    public function getFile($menu, $param, $active = false, $set_default = false)
    {
        $builder = $this->db->table('m_file a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division, p.code as save_by, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($set_default == true) $builder->where('a.set_default', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('m_company b', 'b.id = a.company_id', 'left');
        $builder->join('m_file c', 'c.id = a.region_id', 'left');
        $builder->join('m_file d', 'd.id = a.division_id', 'left');
        $builder->join('m_user p', 'p.id = a.save_by', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->where('a.param',  $param)->where(['a.deleted_at' => null]);
        $builder->groupBy('a.id')->orderBy('a.name');
        return $builder->get()->getResult();
    }
    public function getFile2($menu, $group)
    {
        $builder = $this->db->table('m_file a');
        $builder->select('a.*, x.id as xLog');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('m_select b', 'b.name = a.param', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->where('b.group',  $group)->where(['a.deleted_at' => null]);
        $builder->groupBy('a.id')->orderBy('a.param, a.name');
        return $builder->get()->getResult();
    }
    public function getParam($param, $subParam)
    {
        $builder = $this->db->table('m_file');
        $builder->where('param',  $param)->where('sub_param',  $subParam)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }

    public function getCost($menu, $param, $category)
    {
        $builder = $this->db->table('m_cost a');
        $builder->select('a.*, x.id as xLog');
        ($param == 'direct cost') ? $builder->where('a.category_id', $category) : $builder->like('a.code', $category, 'after');
        $builder->where('a.param', $param)->where(['a.deleted_at' => null]);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }
    public function distinctCost($param)
    {
        $builder = $this->db->table('m_cost');
        $builder->select('code, name')->distinct();
        $builder->where('param',  $param)->where('level', '1')->where(['deleted_at' => null]);
        $builder->orderBy('code');
        return $builder->get()->getResult();
    }
    public function loadCost($param, $level, $category, $isi, $start = false)
    {
        $builder = $this->db->table('m_cost');
        $builder->where('param', $param);
        if ($category != '') $builder->where('category_id', $category);
        if ($start == true) $builder->like('code', $start, 'after');
        $builder->where("(code like \"%$isi%\" or name like \"%$isi%\")");
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        $builder->where('level', $level)->where(['deleted_at' => null]);
        $builder->orderBy('code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }
    public function cekParentCost($param, $parent, $level, $category)
    {
        $builder = $this->db->table('m_cost');
        $builder->where('param', $param)->where('code', $parent)->where('level', $level)->where('category_id', $category);
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function getParentCost($param, $cost)
    {
        if ($param == 'account') {
            $builder = $this->db->table('m_account a');
            $builder->select('a.*, b.id as idLevel3, c.id as idLevel2, d.id as idLevel1');
            $builder->join('m_account b', 'a.parent_id=b.id', 'left');
            $builder->join('m_account c', 'b.parent_id=c.id', 'left');
            $builder->join('m_account d', 'c.parent_id=d.id', 'left');
        } else {
            $builder = $this->db->table('m_cost a');
            if ($param == 'direct') {
                $builder->select('a.*, c.id as idLevel2, d.id as idLevel1');
                $builder->join('m_cost c', 'a.parent_id=c.id', 'left');
                $builder->join('m_cost d', 'c.parent_id=d.id', 'left');
            } else { // indirect
                $builder->select('a.*, b.id as idLevel3, c.id as idLevel2, d.id as idLevel1');
                $builder->join('m_cost b', 'a.parent_id=b.id', 'left');
                $builder->join('m_cost c', 'b.parent_id=c.id', 'left');
                $builder->join('m_cost d', 'c.parent_id=d.id', 'left');
            }
        }
        $builder->where('a.id', $cost);
        return $builder->get()->getResult();
    }

    public function getBudget($menu, $global = '1', $unique = false, $object = false)
    {
        $builder = $this->db->table('m_budget1 a');
        if ($global == '1') { // Default Budget for list
            $builder->select('a.*, b.name as typeCode, sum(distinct c.total) as allTotal, x.id as xLog');
            $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
            $builder->join('m_cost b', 'a.type = b.code',  'left');
            $builder->join('m_budget2 c', 'a.id = c.parent_id',  'left');
            $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
            $builder->where('c.level', '1');
            $builder->where(['a.deleted_at' => null]);
            $builder->groupBy('a.id')->orderBy("a.object, a.title");
        } elseif ($global == '0') { // Default Budget for detail item
            $builder->select('c.*, b.code as code, b.name as description, b.level as level');
            $builder->join('m_budget2 c', 'c.parent_id = a.id',  'left');
            $builder->where('a.unique', $unique)->where(['c.deleted_at' => null]);
            if ($object == 'project')
                $builder->join('m_cost b', 'c.cost_id=b.id', 'left');
            else
                $builder->join('m_account b', 'c.account_id=b.id', 'left');
            $builder->groupBy('c.id')->orderBy("b.code, c.id");
        } elseif ($global == 'mi') { // Default Budget on Modal Import
            $builder->where('a.source', $unique)->where('a.object', $object); // String unique use on field source
            $builder->where(['a.deleted_at' => null]);
            $builder->orderBy("a.title");
        }
        return $builder->get()->getResult();
        // return $builder->getCompiledSelect();
    }
    public function cekBudget($parent, $data1, $data2)
    {
        $builder = $this->db->table('m_budget2');
        $builder->where('parent_id', $parent)->where($data1, $data2);
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function budgetTotal($table, $idBudget, $parent, $level = '0')
    {
        $builder = $this->db->table('m_budget2 a');
        $builder->select('sum(a.total) as subtotal');
        $builder->where('a.parent_id', $idBudget)->where(['a.deleted_at' => null]);
        if ($level == '0') {
            $builder->where('b.parent_id', $parent);
            // ($table == 'account') ? $builder->join('m_account b', 'a.account_id = b.id', 'left') : $builder->join('m_cost b', 'a.cost_id = b.id', 'left');
            $builder->join("m_{$table} b", "a.{$table}_id = b.id", 'left');
            $builder->groupBy('b.parent_id');
        } else {
            $builder->where('a.level', '1');
            $builder->join('m_budget1 b', 'a.parent_id = b.id', 'left');
        }
        return $builder->get()->getResult();
    }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function getAccount($menu, $category)
    {
        $builder = $this->db->table('m_account a');
        $builder->select('a.*, x.id as xLog');
        if ($category != '') $builder->where('a.category', $category);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }
    public function loadAccount($isi, string $start)
    {

        $startArray = explode(',', $start);
        $builder = $this->db->table('m_account');
        // $builder->like('code', $start, 'after');
        $builder->groupStart();
        foreach ($startArray as $prefix) {
            $builder->orLike('code', $prefix, 'after');
        }
        $builder->groupEnd();
        $builder->where("(code like \"%$isi%\" or name like \"%$isi%\")");
        $builder->where('level', '4')->where(['deleted_at' => null]);
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        $builder->orderBy('code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }

    // public function getCashAccount(string $cash)
    // {
    //     $cash = trim($cash, ',');
    //     $builder = $this->db->table('m_user a');
    //     $builder->select('b.name as groupName, c.id as accountID, c.code as accountCode, c.name as accountName');
    //     $builder->join('group_account b', "FIND_IN_SET(b.id, a.cash) > 0", 'inner');
    //     $builder->join('m_account c', 'b.account1_id = c.id', 'left');
    //     return $builder->get()->getResult();
    // }


    public function cekAccount($accountNumber, $level)
    {
        $builder = $this->db->table('m_account');
        $builder->where('code', $accountNumber)->where('level', $level);
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        $builder->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function loadGA_COA($AccountID, $field)
    {
        $builder = $this->db->table('group_account a');
        $builder->select('b.id, b.code, b.name');
        $builder->where('a.id', $AccountID)->where(['a.deleted_at' => null]);
        $builder->where(['b.deleted_at' => null]);
        $builder->join('m_account b', 'a.' . $field . ' = b.id', 'left');
        return $builder->get()->getResult();
    }

    public function getGroupAccount($menu, $source, $active = false)
    {
        $builder = $this->db->table('group_account a');
        $builder->select('a.*, b.code as company, x.id as xLog');
        $builder->where('a.source', $source)->where(['a.deleted_at' => null]);
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('m_company b', 'a.company_id = b.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.param, a.sub_param, a.name');
        return $builder->get()->getResult();
    }
    // public function getCashAccount(string $cash)
    // {
    //     $builder = $this->db->table('m_user a');
    //     $builder->select('b.name as groupName, c.code as accountCode, c.name as accountName');
    //     $builder->join('group_account b', "FIND_IN_SET(b.id, TRIM(BOTH ',' FROM a.$cash))", 'inner');
    //     $builder->join('m_account c', 'b.account1_id = c.id', 'left');
    //     return $builder->get()->getResult();
    // }
    // public function getCashAccount(string $cash)
    // {
    //     $cash = trim($cash, ',');
    //     $builder = $this->db->table('m_user a');
    //     $builder->select('b.name as groupName, c.code as accountCode, c.name as accountName');
    //     $builder->join('group_account b', "FIND_IN_SET(b.id, a.$cash) > 0", 'inner');
    //     $builder->join('m_account c', 'b.account1_id = c.id', 'left');
    //     return $builder->get()->getResult();
    // }

    // public function getCashAccount(string $cash)
    // {
    //     $cash = trim($cash, ',');
    //     $builder = $this->db->table('m_user a');
    //     $builder->select('b.name as groupName, c.code as accountCode, c.name as accountName');
    //     $builder->join('group_account b', "FIND_IN_SET(b.id, a.$cash) > 0", 'inner');
    //     $builder->join('m_account c', 'b.account1_id = c.id', 'left');
    //     return $builder->get()->getResult();
    // }
    public function getCashAccount(string $cash)
    {
        $cash = trim($cash, ',');
        $builder = $this->db->table('m_user a');
        $builder->select('b.name as groupName, c.id as accountID, c.code as accountCode, c.name as accountName');
        $builder->join('group_account b', "FIND_IN_SET(b.id, a.cash) > 0", 'inner');
        $builder->join('m_account c', 'b.account1_id = c.id', 'left');
        return $builder->get()->getResult();
    }




    // public function cekKelakun($subparam, $nama, $idunik)
    // {
    //     $builder = $this->db->table('m_kelakun');
    //     $builder->where('sub_param', $subparam)->where('nama', $nama);
    //     $builder->where('idunik !=', $idunik)->where(['deleted_at' => null]);
    //     return $builder->get()->getResult();
    // }
    public function loadGroupAccount($param, $subparam, $source = false)
    {
        $builder = $this->db->table('group_account');
        $builder->where('param', $param);
        if ($subparam != '') $builder->where('sub_param', $subparam);
        if ($source == true) $builder->where('source', $source);
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        $builder->where(['deleted_at' => null]);
        $builder->orderBy('name');
        return $builder->get()->getResult();
    }



    public function getStandard($menu, $param, $active = false)
    {
        $builder = $this->db->table('m_standard a');
        $builder->select('a.*, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($param != '') $builder->where('a.param', $param);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.name');
        return $builder->get()->getResult();
    }
    public function cekStandard($param, $code, $unique)
    {
        $builder = $this->db->table('m_standard');
        $builder->where('param', $param)->where('code', $code);
        $builder->where('unique !=', $unique)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function loadStandard($isi, $param)
    {
        $builder = $this->db->table('m_standard');
        $builder->where("(code like \"%$isi%\" or name like \"%$isi%\")");
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        $builder->where('param', $param);
        $builder->orderBy('code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }
    // public function distKBLI($pilihan)
    // {
    //     $builder = $this->db->table('m_kbli a');
    //     $builder->select('a.*, b.nilai as nilaipajak');
    //     $builder->where('a.pilihan', $pilihan);
    //     $builder->where(['a.deleted_at' => null]);
    //     $builder->join('def_akun b', 'a.pajak_id = b.id');
    //     $builder->orderBy('a.kode');
    //     return $builder->get()->getResult();
    // }



    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function getBranch($menu, $active = false)
    {
        $builder = $this->db->table('m_branch a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('code');
        return $builder->get()->getResult();
    }
    public function loadBranch($isi, $company = false, $region = false, $division = false)
    {
        $builder = $this->db->table('m_branch a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division');
        $builder->where("(a.code like \"%$isi%\" or a.name like \"%$isi%\")");
        $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $builder->where(['a.deleted_at' => null]);
        if ($company == true) $builder->where('a.company_id', $company);
        if ($region == true) $builder->where('a.region_id', $region);
        if ($division == true) $builder->where('a.division_id', $division);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        $builder->orderBy('a.code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }

    public function getProject($menu, $active = false, $company = false, $year = false)
    {
        $builder = $this->db->table('m_project a');
        $builder->select('a.*, b.code as company, c.name as region, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($company == true) $builder->where('a.company_id', $company);
        if ($year == true) $builder->where('a.period_1', $year);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }
    public function loadProject($isi, $company = false, $region = false, $division = false)
    {
        $builder = $this->db->table('m_project a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division');
        $builder->where("(a.code like \"%$isi%\" or a.package_name like \"%$isi%\")");
        $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $builder->where(['a.deleted_at' => null]);
        if ($company == true) $builder->where('a.company_id', $company);
        if ($region == true) $builder->where('a.region_id', $region);
        if ($division == true) $builder->where('a.division_id', $division);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        $builder->orderBy('a.code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }

    public function getSegment($menu, $param, $active = false, $project = false, $branch = false)
    {
        $builder = $this->db->table('m_segment a');
        $builder->select('a.*, b.code as codeProject, c.code as codeBranch, d.code as company, e.name as region, x.id as xLog');
        $builder->where('a.param', $param)->where(['a.deleted_at' => null]);
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($project == true) $builder->where('a.project_id', $project);
        if ($branch == true) $builder->where('a.branch_id', $branch);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('m_project b', 'a.project_id=b.id', 'left');
        $builder->join('m_branch c', 'a.branch_id=c.id', 'left');
        $builder->join('m_company d', 'b.company_id=d.id', 'left');
        $builder->join('m_file e', 'b.region_id=e.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('b.code, c.code, a.code');
        return $builder->get()->getResult();
    }
    // public function cekRuas($param, $kode, $idunik, $proyek = false, $cabang = false, $ruas = false)
    // {
    //     $builder = $this->db->table('m_ruas');
    //     $builder->where('param', $param);
    //     $builder->where('kode', $kode)->where('idunik !=', $idunik);
    //     if ($proyek == true) $builder->where('proyek_id', $proyek);
    //     if ($cabang == true) $builder->where('cabang_id', $cabang);
    //     if ($ruas == true) $builder->where('ruas_id', $ruas);
    //     return $builder->get()->getResult();
    // }

    public function getTool($menu, $active = false, $param = false, $company = false, $partner = false, $category = false)
    {
        $builder = $this->db->table('m_tool a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division, e.name as partner_name, x.id as xLog');
        if ($param == true) ($param == 'multi') ? $builder->whereIn('a.param', ['equipment', 'tool']) : $builder->where('a.param', $param);
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($company == true) $builder->where('a.company_id', $company);
        if ($category == true) $builder->where('a.category', $category);
        if ($param == 'partner') $builder->where('a.partner_id', $partner);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        $builder->join('m_person e', 'a.person_id=e.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }
    public function loadTool($isi, $param = false, $company = false, $region = false, $division = false)
    {
        $builder = $this->db->table('m_tool a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division');
        $builder->where("(a.code like \"%$isi%\" or a.name like \"%$isi%\" or a.code2 like \"%$isi%\")");
        $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $builder->where(['a.deleted_at' => null]);
        if ($param == true) ($param == 'multi') ? $builder->whereIn('a.param', ['equipment', 'tool']) : $builder->where('a.param', $param);
        if ($company == true) $builder->where('a.company_id', $company);
        if ($region == true) $builder->where('a.region_id', $region);
        if ($division == true) $builder->where('a.division_id', $division);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        // $builder->join('m_kbli b', 'a.kbli_id=b.id', 'left');
        // $builder->join('m_divisi f', 'a.kategori_id=f.id', 'left');
        $builder->orderBy('a.code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }
    // // public function loadAlatincRekanan($isi, $bentuk, $kategori, $pilih = false)
    // // {
    // //     $builder = $this->db->table('m_alat a');
    // //     $builder->select('a.*,b.kode as perusahaan,c.nama as penerima');
    // //     $builder->where("(a.kode like \"%$isi%\" or a.nama like \"%$isi%\" or a.nomor like \"%$isi%\")");
    // //     $builder->where('a.bentuk', $bentuk)->where('a.kategori_id', $kategori);
    // //     $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1')->where(['a.deleted_at' => null]);
    // //     $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    // //     $builder->join('m_penerima c', 'a.penerima_id=c.id', 'left');
    // //     $builder->orderBy('a.kode');
    // //     $builder->limit(quantityLimit);
    // //     return $builder->get()->getResult();
    // // }
    public function getLand($menu, $active = false, $company = false, $category = false)
    {
        $builder = $this->db->table('m_land a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($company == true) $builder->where('a.company_id', $company);
        if ($category == true) $builder->where('a.category', $category);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }
    // public function loadTanah($isi, $perusahaan, $wilayah, $divisi)
    // {
    //     $builder = $this->db->table('m_tanah a');
    //     $builder->select('a.*, b.kode as kodekbli, b.nama as namakbli, c.kode as perusahaan, d.nama as wilayah, e.nama as divisi');
    //     $builder->where("(a.kode like \"%$isi%\" or a.nama like \"%$isi%\")");
    //     $builder->where('a.is_confirm', '1')->where('a.is_aktif', '1')->where(['a.deleted_at' => null]);
    //     $builder->where('b.is_confirm', '1')->where('b.is_aktif', '1')->where('b.deleted_at', null);
    //     $builder->where('c.is_confirm', '1')->where('c.is_aktif', '1')->where('c.deleted_at', null);
    //     $builder->where('d.is_confirm', '1')->where('d.is_aktif', '1')->where('d.deleted_at', null);
    //     if ($perusahaan != '') $builder->where('a.perusahaan_id', $perusahaan);
    //     if ($wilayah != '') $builder->where('a.wilayah_id', $wilayah);
    //     if ($divisi != '') $builder->where('a.divisi_id', $divisi);
    //     $builder->join('m_kbli b', 'a.kbli_id=b.id', 'left');
    //     $builder->join('m_perusahaan c', 'a.perusahaan_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.wilayah_id=d.id', 'left');
    //     $builder->join('m_divisi e', 'a.divisi_id=e.id', 'left');
    //     $builder->orderBy('a.kode');
    //     $builder->limit(quantityLimit);
    //     return $builder->get()->getResult();
    // }
    public function getInventory($menu, $active = false, $company = false, $category = false)
    {
        $builder = $this->db->table('m_inventory a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($company == true) $builder->where('a.company_id', $company);
        if ($category == true) $builder->where('a.category', $category);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.code');
        return $builder->get()->getResult();
    }

    // public function getDocument($menu, $object, $isi)
    // {
    //     $builder = $this->db->table('m_document a');
    //     $builder->select('a.*, b.code as company, c.name as region, d.name as division, x.id as xLog');
    //     $builder->where("(a.title like \"%$isi%\" or a.name like \"%$isi%\" or b.code like \"%$isi%\" or c.name like \"%$isi%\" or d.name like \"%$isi%\")");
    //     $builder->where('a.object', $object);
    //     $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
    //     $builder->join('m_company b', 'b.id = a.company_id', 'left');
    //     $builder->join('m_file c', 'c.id = a.region_id', 'left');
    //     $builder->join('m_file d', 'd.id = a.division_id', 'left');
    //     $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
    //     $builder->groupBy('a.id')->orderBy('a.title');
    //     return $builder->get()->getResult();
    // }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function getItem($menu, $param = false, $category = false, $active = false, $serial = false)
    {
        $builder = $this->db->table('m_item a');
        $builder->select('a.*, x.id as xLog');
        if ($param == true) $builder->where('a.param', $param);
        if ($category == true) $builder->where('a.category', $category);
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.param, a.category, a.code');
        return $builder->get()->getResult();
    }
    public function loadItem($isi, $param, $serial)
    {
        $builder = $this->db->table('m_item');
        $builder->where("(code like \"%$isi%\" or name like \"%$isi%\")");
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        $builder->where(['deleted_at' => null]);
        if ($param != '') $builder->like('param', $param);
        if ($serial == '1') $builder->where('substring(mode, 1, 1)', '1');
        $builder->orderBy('code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }

    public function getSerial($menu)
    {
        $builder = $this->db->table('m_serial a');
        $builder->select('a.*, b.name as itemName, c.code as toolNumber, x.id as xLog');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_item b', 'a.item_id=b.id', 'left');
        $builder->join('m_tool c', 'a.tool_id=c.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('b.code, a.serial');
        return $builder->get()->getResult();
    }
    // public function loadAtk($isi)
    // {
    //     $builder = $this->db->table('m_atk');
    //     $builder->where("(nama like \"%$isi%\")");
    //     $builder->where(['deleted_at' => null]);
    //     $builder->orderBy('nama');
    //     $builder->limit(quantityLimit);
    //     return $builder->get()->getResult();
    // }
    // ____________________________________________________________________________________________________________________________
    public function getPerson($menu, $employee, $active = false, $osm = false, $company = false, $category = false, $position = false)
    {
        $builder = $this->db->table('m_person a');
        $builder->select('a.*, b.code as company, c.name as region, d.name as division, e.name as position, x.id as xLog');
        if ($active == true) $builder->where('substring(a.adaptation, 2, 1)', '1')->where('substring(a.adaptation, 3, 1)', '1');
        if ($company == true) $builder->where('a.company_id', $company);
        if ($category == true) $builder->where('a.category', $category);
        if ($position == true) $builder->where('a.position_id', $position);
        if ($employee == '1') $builder->where('substring(a.is_alias, 4, 1)', '1');
        if ($osm == '1') $builder->where('substring(a.is_alias, 5, 1)', '1');
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_company b', 'a.company_id=b.id', 'left');
        $builder->join('m_file c', 'a.region_id=c.id', 'left');
        $builder->join('m_file d', 'a.division_id=d.id', 'left');
        $builder->join('m_file e', 'a.position_id=e.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('a.category, a.code');
        return $builder->get()->getResult();
    }
    public function loadPerson($isi, $customer, $supplier, $subcontractor, $employee, $osm)
    {
        $builder = $this->db->table('m_person');
        $builder->where("(code like \"%$isi%\" or eid like \"%$isi%\" or name like \"%$isi%\")");
        $builder->where('substring(adaptation, 2, 1)', '1')->where('substring(adaptation, 3, 1)', '1');
        if ($osm == '1') $builder->Where('substring(is_alias, 5, 1)', '1');
        $builder->groupStart();
        if ($customer === '1') $builder->orWhere('substring(is_alias, 1, 1)', '1');
        if ($supplier === '1') $builder->orWhere('substring(is_alias, 2, 1)', '1');
        if ($subcontractor === '1') $builder->orWhere('substring(is_alias, 3, 1)', '1');
        if ($employee === '1') $builder->orWhere('substring(is_alias, 4, 1)', '1');
        $builder->groupEnd();
        $builder->orderBy('code');
        $builder->limit(quantityLimit);
        return $builder->get()->getResult();
    }
    // public function cekPerson($username)
    // {
    //     $builder = $this->db->table('m_penerima');
    //     $builder->where('user_id', $userid);
    //     if ($idunik == true) $builder->where('idunik !=', $idunik);
    //     return $builder->get()->getResult();
    // }
    // public function getBiodata($userid, $atasan = false)
    // {
    //     $builder = $this->db->table('m_penerima a');
    //     $builder->select('a.*, b.kode as perusahaan, c.nama as wilayah, d.nama as divisi, e.nama as cabang, f.nama as atasan, g.nama as jabatan, h.nama as golongan, j.acc_setuju as level');
    //     ($atasan == true) ? $builder->where('a.atasan_id', $userid) : $builder->where('a.user_id', $userid);
    //     $builder->join('m_perusahaan b', 'a.perusahaan_id=b.id', 'left');
    //     $builder->join('m_divisi c', 'a.wilayah_id=c.id', 'left');
    //     $builder->join('m_divisi d', 'a.divisi_id=d.id', 'left');
    //     $builder->join('m_camp e', 'a.cabang_id=e.id', 'left');
    //     $builder->join('m_penerima f', 'a.atasan_id=f.id', 'left');
    //     $builder->join('m_divisi g', 'a.jabatan_id=g.id', 'left');
    //     $builder->join('m_divisi h', 'a.golongan_id=h.id', 'left');
    //     $builder->join('m_user j', 'a.user_id=j.id', 'left');
    //     return $builder->get()->getResult();
    // }
    // public function distPenerima()
    // {
    //     $builder = $this->db->table('m_select');
    //     $builder->select('nama')->distinct();
    //     $builder->where('param', 'kelakun')->where('kelompok', 'penerima');
    //     $builder->orderBy('nomor');
    //     return $builder->get()->getResult();
    // }

    // ___________________________________________________________________________________________________________________________________________________________________________________________
    public function getDate($date)
    {
        $builder = $this->db->table('m_calendar');
        $builder->where('day_date', $date)->where(['deleted_at' => null]);
        return $builder->get()->getResult();
    }
    public function getCalendar($tahun)
    {
        $builder = $this->db->table('m_calendar a');
        $builder->select('a.*, b.code as user');
        $builder->where(['a.deleted_at' => null]);
        $builder->join('m_user b', 'a.save_by = b.id', 'left');
        if ($tahun != '') $builder->where('left(a.day_date, 4)', $tahun);
        $builder->orderBy('a.day_date');
        return $builder->get()->getResult();
    }

    public function getForm($menu, $param, $form, $company = '')
    {
        $builder = $this->db->table('m_file a');
        $builder->select('a.*, b.group as group, c.name as company, x.id as xLog');
        $builder->where('a.param', $param);
        if ($company != '') $builder->where('a.company_id', $company);
        $builder->where(['a.deleted_at' => null]);
        $strX = ($menu != '' ? ' AND x.menu = "' . $menu . '" AND x.username = "' . decrypt(session()->username) . '"' : '');
        $builder->join('m_select b', 'a.sub_param=b.name', 'left');
        $builder->join('m_company c', 'a.company_id=c.id', 'left');
        $builder->join('user_log x', 'x.unique = a.unique' . $strX, 'left');
        $builder->groupBy('a.id')->orderBy('b.number');
        return $builder->get()->getResult();
        // return $builder->getCompiledSelect();
    }
}

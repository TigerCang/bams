<?php

use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Security\Exceptions\SecurityException;
use App\Libraries\Menu;

if (!function_exists('thisMenu')) {
    function thisMenu()
    {
        $thisMenu = Menu::getMenu();
        return $thisMenu;
    }
}

if (!function_exists('thisUser')) {
    function thisUser()
    {
        $thisUser = Menu::getUser();
        return $thisUser;
    }
}

if (!function_exists('getMainModel')) {
    function getMainModel()
    {
        static $mainModel = null;
        if ($mainModel === null) $mainModel = new \App\Models\mix\MainModel();
        return $mainModel;
    }
}

if (!function_exists('getTransModel')) {
    function getTransModel()
    {
        static $transModel = null;
        if ($transModel === null) $transModel = new \App\Models\mix\TransModel();
        return $transModel;
    }
}

// Check open web and ּaccess right
if (!function_exists('checkPage')) {
    function checkPage($number, $db = [], $create = 'n', $detail = 'y', $dbe = [], $uniq = 'y')
    // number = role, db = data or not, create = access create dan read, detail = access company region division 
    {
        $menu = Menu::getMenu();
        $user = Menu::getUser();
        $queryString = $_SERVER['QUERY_STRING']; // get query string from URL
        parse_str($queryString, $queryParams); // split query string be array
        $queryKeys = array_keys($queryParams); // save parameter in array

        if ($number[0] == '1' && !preg_match("/$number/i", $menu['menu_1'])) throw SecurityException::forDisallowedAction();
        if ($queryKeys && $queryKeys[0] != 'search') throw PageNotFoundException::forPageNotFound();
        // if ($uniq == 'n' && empty($queryParams['search'])) throw PageNotFoundException::forPageNotFound();
        if (empty($queryParams['search'])) { // new data
            if ($create == 'y') if ($user['act_button'][0] == '0') throw SecurityException::forDisallowedAction();
        } else {
            if (empty($db)) throw PageNotFoundException::forPageNotFound();
            if ($create == 'y' && $user['act_button'][1] == '0') throw SecurityException::forDisallowedAction();
            if ($detail == 'y') {
                if ($user['act_access'][0] == "0" && !preg_match("/," . $db[0]->company_id . ":/i", $user['company'])) throw SecurityException::forDisallowedAction();
                if ($user['act_access'][1] == "0" && !preg_match("/," . $db[0]->region_id . ":/i", $user['region'])) throw SecurityException::forDisallowedAction();
                if ($user['act_access'][2] == "0" && !preg_match("/," . $db[0]->division_id . ":/i", $user['division'])) throw SecurityException::forDisallowedAction();
            }
        }
    }
}

// Check access company region and division 
if (!function_exists('checkAccess')) {
    function checkAccess($company, $region, $division, $source = 'input')
    {
        $user = Menu::getUser();
        $resultCompany = ($user['act_access'][0] == '0' && preg_match("/(^|,)$company:(\d+)(,|$)/", $user['company'], $result)) ? $result[2] : '1';
        $resultRegion = ($user['act_access'][1] == '0' && preg_match("/(^|,)$region:(\d+)(,|$)/", $user['region'], $result)) ? $result[2] : '1';
        $resultDivision = ($user['act_access'][2] == '0' && preg_match("/(^|,)$division:(\d+)(,|$)/", $user['division'], $result)) ? $result[2] : '1';

        if ($source === 'input') {
            return ($resultCompany === '0' || $resultRegion === '0' || $resultDivision === '0') ? 'hidden disabled' : '';
        } elseif ($source == 'save') {
            return [
                $resultCompany === '0' ? 'valid_email' : 'permit_empty',
                $resultRegion === '0' ? 'valid_email' : 'permit_empty',
                $resultDivision === '0' ? 'valid_email' : 'permit_empty',
            ];
        }
        return null; // Fallback if $source invalid
        // if ($source == 'input') {
        //     $btnAccess = ($resultCompany == '0' || $resultRegion == '0' || $resultDivision == '0') ? 'hidden disabled' : '';
        //     return $btnAccess;
        // } elseif ($source == 'save') {
        //     // $ruleAccess = ($resultCompany == '0' || $resultRegion == '0' || $resultDivision == '0') ? 'required' : 'permit_empty';
        //     // $ruleAccess[0] = $resultCompany == '0' ? 'required' : 'permit_empty';
        //     // $ruleAccess[1] = $resultRegion == '0' ? 'required' : 'permit_empty';
        //     // $ruleAccess[2] = $resultDivision == '0' ? 'required' : 'permit_empty';
        //     // return $ruleAccess;
        // }
    }
}

// Check access object 
if (!function_exists('checkObject')) {
    function checkObject($object, $objectID)
    {
        $user = Menu::getUser();
        $objects = [
            'project' => ['order' => 4, 'model' => 'project'],
            'branch' => ['order' => 5, 'model' => 'branch'],
            'equipment tool' => ['order' => 6, 'model' => 'tool'],
            'land building' => ['order' => 7, 'model' => 'land']
        ];
        $order = $objects[$object]['order'];
        $model = $objects[$object]['model'];
        return ($user['act_access'][$order] == '0' && !preg_match("/(^|,)" . $objectID . "(,|$)/", $user[$model], $result)) ? 'valid_email' : 'permit_empty';
    }
}

// Check Budget 
if (!function_exists('checkBudget')) {
    function checkBudget($source, $object, $objectID, $segment, $revision, $unique)
    {
        $transModel = getTransModel();
        $budget1 = $transModel->cekBudget($source, $object, $objectID, $segment);

        // var_dump($budget1[0]->revision);
        // die;
        // $order = $objects[$object]['order'];
        // $model = $objects[$object]['model'];
        // return ($user['act_access'][$order] == '0' && !preg_match("/(^|,)" . $objectID . "(,|$)/", $user[$model], $result)) ? 'valid_email' : 'permit_empty';
    }
}

// Setting Button for main data
if (!function_exists('setButton')) {
    function setButton($db1, $new = '0')
    {
        $user = Menu::getUser();
        $buttons = [];
        $queryString = $_SERVER['QUERY_STRING']; // get query string from URL
        parse_str($queryString, $queryParams); // split query string be array
        // $queryKeys = array_keys($queryParams); // save parameter in array

        if (empty($queryParams['search']) || $new == '1') {
            $buttons['save'] = '';
            $buttons['confirm'] = $buttons['delete'] = $buttons['active'] = 'disabled';
        } else {
            $buttons['save'] = ($user['act_button'][2] == '0' ? 'disabled' : '');
            $buttons['confirm'] = (($user['act_button'][4] == '0' || $db1[0]->adaptation[1] == '1' || $db1[0]->save_by == $user['id']) ? 'disabled' : '');
            $buttons['delete'] = ($user['act_button'][3] == '0' ? 'disabled' : '');
            $buttons['active'] = ($user['act_button'][5] == '0' ? 'disabled' : '');
        }
        return $buttons;
    }
}

// Setting Button for transaction data
if (!function_exists('transButton')) {
    function transButton($db1, $status)
    {
        $buttons = [];
        $buttons['on'] = ($db1 ? '' : 'disabled');
        $buttons['off'] = ($db1 ? 'disabled' : '');
        return $buttons;
    }
}

// Check document code
if (!function_exists('checkDocumentCode')) {
    function checkDocumentCode($param, $subParam)
    {
        $mainModel = getMainModel();
        $cekDoc = $mainModel->getParam($param, $subParam);
        $ruleDoc = ($cekDoc ? 'permit_empty' : 'required');
        return $ruleDoc;
    }
}

// Check data link to another table before delete
if (!function_exists('cekLink')) {
    function cekLink($table, $field, $id, &$ruleLink, $field2 = false, $id2 = false)
    {
        $mainModel = getMainModel();
        $cekLink = ($field2 == false ? $mainModel->cekLink($table, $field, $id) : $mainModel->cekLink($table, $field, $id, $field2, $id2));
        if ($cekLink) $ruleLink =  'asd';
        return $ruleLink;
    }
}

// Select option company
if (!function_exists('companyOptions')) {
    function companyOptions($company, $db1, $this_user)
    {
        $output = '';
        foreach ($company as $db) {
            $companyId = is_array($db1) ? ($db1[0]->company_id ?? null) : ($db1 ?? null);
            $selected = (!empty($db1) ? ($companyId == $db->id ? 'selected' : '') : (explode(',', $this_user['set_default'])[0] == $db->id ? 'selected' : ''));
            // $selected = (!empty($db1) && isset($db1[0]->company_id)) ? ($db1[0]->company_id == $db->id ? 'selected' : '') : (explode(',', $this_user['set_default'])[0] == $db->id ? 'selected' : '');
            $disabled = ($this_user['act_access'][0] == '1' || preg_match("/(^|,)" . $db->id . "(:|$)/i", $this_user['company']) ? '' : 'disabled');
            $output .= "<option value='{$db->id}' {$selected} {$disabled}>" . $db->code . str_repeat("&ensp;", 3) . $db->name . "</option>";
        }
        return $output;
    }
}

// Select option region
if (!function_exists('regionOptions')) {
    function regionOptions($region, $db1, $this_user)
    {
        $output = '';
        foreach ($region as $db) {
            $regionId = is_array($db1) ? ($db1[0]->region_id ?? null) : ($db1 ?? null);
            $selected = (!empty($db1) ? ($regionId == $db->id ? 'selected' : '') : (explode(',', $this_user['set_default'])[1] == $db->id ? 'selected' : ''));
            $disabled = ($this_user['act_access'][1] == '1' || preg_match("/(^|,)" . $db->id . "(:|$)/i", $this_user['region']) ? '' : 'disabled');
            $output .= "<option value='{$db->id}' {$selected} {$disabled}>" . $db->name . "</option>";
        }
        return $output;
    }
}

// Select option division
if (!function_exists('divisionOptions')) {
    function divisionOptions($division, $db1, $this_user)
    {
        $output = '';
        foreach ($division as $db) {
            $divisionId = is_array($db1) ? ($db1[0]->division_id ?? null) : ($db1 ?? null);
            $selected = (!empty($db1) ? ($divisionId == $db->id ? 'selected' : '') : (explode(',', $this_user['set_default'])[2] == $db->id ? 'selected' : ''));
            $disabled = ($this_user['act_access'][2] == '1' || preg_match("/(^|,)" . $db->id . "(:|$)/i", $this_user['division']) ? '' : 'disabled');
            $output .= "<option value='{$db->id}' {$selected} {$disabled}>" . $db->name . "</option>";
        }
        return $output;
    }
}

// Select option object
if (!function_exists('objectOptions')) {
    function objectOptions($object, $db1, $this_user, $choice)
    {
        $output = '';
        foreach ($object as $db) {
            if (($choice == '') || ($choice == 'project' && $db->name == 'project') || ($choice == 'object' && $db->name != 'project')) :
                if ($db->number <= 10) :
                    $selected = (!empty($db1) && isset($db1[0]->object)) ? ($db1[0]->object == $db->id ? 'selected' : '') : (explode(',', $this_user['set_default'])[3] == $db->name ? 'selected' : '');
                    $output .= "<option value='{$db->name}' {$selected}>" . lang('app.' . $db->name) . "</option>";
                endif;
            endif;
        }
        return $output;
    }
}

// Function initial code combination
if (!function_exists('initialCode')) {
    function initialCode($subParam, $company, $region, $division)
    {
        $mainModel = getMainModel();
        $fileCode = $mainModel->getData('m_file', $subParam, '', 'sub_param', 't');
        $companyCode = $mainModel->getData('m_company', $company, '', 'id', 't');
        $regionCode = $mainModel->getData('m_file', $region, '', 'id', 't');
        $divisionCode = $mainModel->getData('m_file', $division, '', 'id', 't');
        $initial = "{$fileCode[0]->name}/{$companyCode[0]->initial}®/{$divisionCode[0]->name2}·{$regionCode[0]->name2}/"; // © ®
        return $initial;
    }
}

// Select option segment from project
if (!function_exists('segmentOptions')) {
    function segmentOptions($project, $selection)
    {
        $mainModel = getMainModel();
        $segment = $mainModel->getSegment('', 'segment', 't', $project);
        $output = '';
        foreach ($segment as $db) {
            $selected = ($selection == $db->id) ? 'selected' : '';
            $output .= "<option value='{$db->id}' {$selected} data-code='{$db->code}'>" . $db->code . str_repeat("&ensp;", 3) . $db->name . "</option>";
        }
        return $output;
    }
}

// Search and Set Outfocus data from branch
if (!function_exists('callFile')) {
    function callFile($object, $value)
    {
        $mainModel = getMainModel();
        $object1 = $mainModel->getData('m_' . $object, $value, '', 'id');
        $company1 = $mainModel->getData('m_company', $object1[0]->company_id ?? '', '', 'id');
        $region1 = $mainModel->getData('m_file', $object1[0]->region_id ?? '', '', 'id');
        $division1 = $mainModel->getData('m_file', $object1[0]->division_id ?? '', '', 'id');

        if ($object == 'project') $file['categoryProject'] = $object1[0]->category_id ?? '';
        $file['company'] = $company1[0]->code ?? '';
        $file['region'] = $region1[0]->name ?? '';
        $file['division'] = $division1[0]->name ?? '';
        return $file;
    }
}

// Check open web and ּaccess right
if (!function_exists('userLevel')) {
    function userLevel($level = '')
    {
        $user = Menu::getUser();
        $configModel = new \App\Models\admin\ConfigModel();
        $approve = $configModel->getConfig('level approve');
        $lev = explode(',', $level);

        if ($level == '') {
            $l1 = $l2 = $user['act_approve'];
            $l3 = '101';
            $l4 = ($user['act_approve'] == '0' ? $approve[0]['value'] : ($user['act_approve'] == '1' ? '1' : $user['act_approve'] - 1)); // Next
        } else {
            $l1 = $lev[0]; // Start
            $l2 = $user['act_approve']; // Now
            $l3 = $lev[2]; // Finance
            $l4 = $user['act_approve'] - 1; // Next
        }
        $output = implode(',', [$l1, $l2, $l3, $l4]);
        return $output;
    }
}

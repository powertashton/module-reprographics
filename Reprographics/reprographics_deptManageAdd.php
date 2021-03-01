<?php
/*
Gibbon, Flexible & Open School System
Copyright (C) 2010, Ross Parker

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

use Gibbon\Forms\Form;

// Module includes
require_once __DIR__ . '/moduleFunctions.php';

$page->breadcrumbs->add(__('Add Department'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_deptManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    //FORM TO CREATE A CATEGORY
    $moduleName = $gibbon->session->get('module');
    $staff = array();

    try {
        $sql = "SELECT gibbonPersonID, preferredName, surname, title, gibbonRole.category FROM gibbonPerson JOIN gibbonRole ON (gibbonPerson.gibbonRoleIDPrimary = gibbonRole.gibbonRoleID) WHERE gibbonRole.category='Staff' AND gibbonPerson.status='Full' ORDER BY gibbonPerson.surname, gibbonPerson.preferredName ASC";
        $result = $connection2->prepare($sql);
        $result->execute();
    } catch (PDOException $e) {
    }

    while (($row = $result->fetch()) != null) {
        $staff[$row["gibbonPersonID"]] = formatName($row['title'], $row["preferredName"], $row["surname"], $row["category"], true, true);
    }
    
    
    $form = Form::create('addDept', $gibbon->session->get('absoluteURL') . '/modules/' . $moduleName . '/reprographics_deptManageAddProcess.php', 'post');
    $form->addHiddenValue('address', $gibbon->session->get('address'));
    
    $row = $form->addRow();
        $row->addLabel('deptName', __('Department Name'));
        $row->addTextField('deptName')
            ->maxLength(55)
            ->required(); //TODO: UNIQUE FIELD THIS
            
    $row = $form->addRow();
        $column = $row->addColumn();
            $column->addLabel('staff', __('Staff'));
            $column->addMultiSelect('staff')->isRequired()->source()->fromArray($staff);
            
    $row = $form->addRow();
        $row->addFooter();
        $row->addSubmit();

    echo $form->getOutput();
}	

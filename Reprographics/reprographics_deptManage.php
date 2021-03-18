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



use Gibbon\Tables\DataTable;
use Gibbon\Module\Reprographics\Domain\DepartmentGateway;
use Gibbon\Module\Reprographics\Domain\StaffGateway;
$page->breadcrumbs->add(__('Manage Departments'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_deptManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    
    $departmentGateway = $container->get(DepartmentGateway::class);
    $data = $departmentGateway->selectDepts()->toDataSet();
    
    $staffGateway = $container->get(StaffGateway::class);   
    $formatStaffList = function($row) use ($staffGateway) {
            $staff = $staffGateway->selectBy(['deptID' => $row['deptID']])->fetchAll();
            if (count($staff) < 1) {
                return __('This department does not have any staff.');
            }
            return implode(', ', array_column($staff, 'gibbonPersonID'));
        };
    //TODO: use the user gateway to return formatted names
    $table = DataTable::create('depts');
        $table->setTitle('Departments');

        $table->addHeaderAction('add', __('Add'))
                ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_deptManageAdd.php');

        $table->addColumn('deptName', __('Department Name'));
        //$table->addColumn('staff', __('Staff'))->format($formatStaffList);
        $table->addActionColumn()
                ->addParam('deptID')
                ->format(function ($department, $actions) use ($gibbon, $data) {
                    $actions->addAction('edit', __('Edit'))
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_deptManageEdit.php');
                    $actions->addAction('delete', __('Delete'))
                            ->modalWindow()
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_deptManageDelete.php');
                });
        
        echo $table->render($data);
}	

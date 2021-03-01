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
use Gibbon\Module\Reprographics\Domain\ItemGateway;
use Gibbon\Tables\DataTable;
use Gibbon\Module\Reprographics\Domain\OrderGateway;
use Gibbon\Module\Reprographics\Domain\StaffGateway;
use Gibbon\Module\Reprographics\Domain\DepartmentGateway;
// Module includes
require_once __DIR__ . '/moduleFunctions.php';

$page->breadcrumbs->add(__('Order Items'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_order.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    
    $moduleName = $gibbon->session->get('module');
    $gibbonPersonID = $gibbon->session->get('gibbonPersonID');
    
    $staffGateway = $container->get(StaffGateway::class);
    $departments = $staffGateway->selectBy(['gibbonPersonID' => $gibbonPersonID])->fetchAll();
    
    if (empty($departments)) {
        $page->addError(__('You are not in any Reprographic Departments'));
    } else {
        
        $form = Form::create('orderItems', $gibbon->session->get('absoluteURL') . '/modules/' . $moduleName . '/reprographics_orderProcess.php', 'post');
        $form->addHiddenValue('address', $gibbon->session->get('address'));
    
        $form->setClass('noIntBorder overflow-visible fullWidth standardForm');
    
        $itemGateway = $container->get(ItemGateway::class);
        $itemData = $itemGateway->selectItems()->toDataSet()->toArray();

        $options = array_reduce($itemData, function ($group, $item) {
          $group[$item['categoryName']][$item['subCategoryName']][$item['itemID']] = $item['itemName'];
          return $group;
        }, []);
    
        $row = $form->addRow();
            $row->addLabel('itemID', __('Item'));
            $row->addDropdown('itemID')
                ->placeholder('Please Select...')
                ->fromArray($options)
                ->isRequired();
        
        foreach ($departments as $department) {
            $departmentGateway = $container->get(DepartmentGateway::class);
            $departmentOptions[] = $departmentGateway->getByID($department['deptID']);
        }
        $departmentOptions = array_reduce($departmentOptions, function ($group, $item) {
              $group[$item['deptID']] = $item['deptName'];
              return $group;
            }, []);
        
        $row = $form->addRow();
            $row->addLabel('deptID', __('Department'));
            $row->addSelect('deptID')
                ->placeholder('Please Select...')
                ->fromArray($departmentOptions)
                ->isRequired();
        
        $row = $form->addRow();
            $row->addLabel('quantity', __('Quantity'));
            $row->addNumber('quantity')->setValue(1)->spinner(true)->isRequired();
    
    
        $row = $form->addRow();
            $row->addFooter();
            $row->addSubmit();

        echo $form->getOutput();


        $orderGateway = $container->get(OrderGateway::class);
    
        $criteria = $orderGateway->newQueryCriteria(true)
            ->sortBy('orderStatus', 'ASC')
            ->sortBy('orderID', 'DESC')
            ->fromPOST();
        $orders = $orderGateway->queryOrders($criteria, $gibbonPersonID);

        $table = DataTable::create('orders');
            $table->setTitle('Your Orders');

        
            $table->addColumn('orderID', __('orderID'));
            $table->addColumn('gibbonPersonID', __('gibbonPersonID'));
            $table->addColumn('itemID', __('itemID'));
            $table->addColumn('quantity', __('quantity'));
            $table->addColumn('orderStatus', __('orderStatus'));
            $table->addColumn('orderDate', __('orderDate'));
        echo $table->render($orders);
    }
}	

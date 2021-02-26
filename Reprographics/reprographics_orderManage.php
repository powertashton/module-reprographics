	
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
use Gibbon\Module\Reprographics\Domain\OrderGateway;

$page->breadcrumbs->add(__('Manage Stock'));
//TODO: REQUIRE CATEGORIES TO BE SET UP
if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    //todo change this to order stuff lmao
    $orderGateway = $container->get(OrderGateway::class);
    $orderData = $orderGateway->selectOrders()->toDataSet();
    $table = DataTable::create('items');
        $table->setTitle('Items');

        
        $table->addColumn('orderID', __('orderID'));
        $table->addColumn('itemID', __('itemID'));
        $table->addColumn('quantity', __('quantity'));
        $table->addColumn('orderStatus', __('orderStatus'));
        $table->addColumn('orderDate', __('orderDate'));
       //  $table->addActionColumn()
//                 ->addParam('itemID')
//                 ->format(function ($department, $actions) use ($gibbon, $itemData) {
//                     $actions->addAction('add', __('Manage Stock'))
//                             ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_stockManage.php');
//                 });
        
        echo $table->render($orderData);
}	

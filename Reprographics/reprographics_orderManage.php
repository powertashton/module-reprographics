	
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

$page->breadcrumbs->add(__('Manage Orders'));
//TODO: REQUIRE CATEGORIES TO BE SET UP
if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_orderManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    $orderGateway = $container->get(OrderGateway::class);
    
    $criteria = $orderGateway->newQueryCriteria(true)
        ->sortBy('orderStatus', 'ASC')
        ->sortBy('orderID', 'DESC')
        ->fromPOST();
    $orders = $orderGateway->queryOrders($criteria);

    $table = DataTable::create('orders');
        $table->setTitle('Orders');
        
        $table->addColumn('orderID', __('orderID'));
        $table->addColumn('gibbonPersonID', __('gibbonPersonID'));
        $table->addColumn('itemID', __('itemID'));
        $table->addColumn('quantity', __('quantity'));
        $table->addColumn('orderStatus', __('orderStatus'));
        $table->addColumn('orderDate', __('orderDate'));
        
        $table->addActionColumn()
            ->addParam('orderID')
            ->addParam('itemID')
            ->addParam('quantity')
            ->format(function ($row, $actions) use ($gibbon) {
                if ($row['orderStatus'] == 'Pending') {
                $actions->addAction('approve', __('Approve'))
                        ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_orderApproveProcess.php')
                        ->addParam('job', 'Approved')
                        ->setIcon('iconTick');
                 $actions->addAction('reject', __('Reject'))
                        ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_orderApproveProcess.php')
                        ->addParam('job', 'Rejected')
                        ->setIcon('iconCross');
                }
            });
        //TODO: add actions to approve/reject orders
    echo $table->render($orders);
}	

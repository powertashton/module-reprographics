	
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
use Gibbon\Services\Format;
use Gibbon\Forms\Form;
use Gibbon\Tables\DataTable;
use Gibbon\Domain\User\UserGateway;
use Gibbon\Module\Reprographics\Domain\OrderGateway;
use Gibbon\Module\Reprographics\Domain\DepartmentGateway;
use Gibbon\Module\Reprographics\Domain\ItemGateway;
use Gibbon\Module\Reprographics\Domain\SubCategoryGateway;
use Gibbon\Module\Reprographics\Domain\CategoryGateway;


if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_reports.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    //Proceed!
    
    //Default Data
    $d = new DateTime('first day of this month');
    $startDate = isset($_GET['startDate']) ? Format::dateConvert($_GET['startDate']) : $d->format('Y-m-d');
    $endDate = isset($_GET['endDate']) ? Format::dateConvert($_GET['endDate']) : date('Y-m-d');
    $viewMode = isset($_REQUEST['format']) ? $_REQUEST['format'] : '';
   
        $page->breadcrumbs->add(__('Records'));
        //Filter
        $form = Form::create('reports', $gibbon->session->get('absoluteURL') . '/index.php', 'get');
        $form->addHiddenValue('q', '/modules/' . $gibbon->session->get('module') . '/reprographics_reports.php');
        $form->setTitle('Filter');

        $row = $form->addRow();
            $row->addLabel('startDate', __('Start Date Filter'));
            $row->addDate('startDate')
                ->setDateFromValue($startDate)
                ->chainedTo('endDate')
                ->required();

        $row = $form->addRow();
            $row->addLabel('endDate', __('End Date Filter'));
            $row->addDate('endDate')
                ->setDateFromValue($endDate)
                ->chainedFrom('startDate')
                ->required();

        $row = $form->addRow();
            $row->addFooter();
            $row->addSubmit();

        echo $form->getOutput();
    

    $orderGateway = $container->get(OrderGateway::class);
    $deptGateway = $container->get(DepartmentGateway::class);
    $userGateway = $container->get(UserGateway::class);
    $itemGateway = $container->get(ItemGateway::class);
    $userGateway = $container->get(UserGateway::class);
    $subCategoryGateway = $container->get(SubCategoryGateway::class);
    $categoryGateway = $container->get(CategoryGateway::class);
    
    $criteria = $orderGateway->newQueryCriteria(true)
        ->sortBy('orderStatus', 'ASC')
        ->sortBy('orderID', 'DESC')
        ->filterBy('startDate', $startDate)
        ->filterBy('endDate', date('Y-m-d 23:59:59', strtotime($endDate)))
        ->fromPost();

    
   
    $orders = $orderGateway->queryOrders($criteria);
    $table = DataTable::createPaginated('orders', $criteria);
        $departments = $deptGateway->selectDepts()->fetchAll();    
        foreach ($departments as $department) {
            $table->addMetaData('filterOptions', [
                'deptID:' . $department['deptID'] => __('Department') . ': ' . $department['deptName'],
            ]);
        }    

        $table->setTitle('Orders');
        
        $table->addColumn('deptID', __('Department'))
            ->format(function ($row) use ($deptGateway) {
                $dept = $deptGateway->getByID($row['deptID']);
                $output = $dept['deptName'];

                return $output;
            });
        
        $table->addColumn('gibbonPersonID', __('Owner'))
            ->format(function ($row) use ($userGateway) {
                $owner = $userGateway->getByID($row['gibbonPersonID']);
                $output = Format::name($owner['title'], $owner['preferredName'], $owner['surname'], 'Staff');
                return $output;
            });
            
        $table->addColumn('itemID', __('Item'))
        ->format(function ($row) use ($itemGateway, $subCategoryGateway, $categoryGateway) {
            $item = $itemGateway->getByID($row['itemID']);
            $category = $categoryGateway->getByID($item['categoryID']);
            $subCategory = $subCategoryGateway->getByID($item['subCategoryID']);
            $output = $category['categoryName'] . ' - ' . $subCategory['subCategoryName'] . ' - ' . $item['itemName'];

            return $output;
        });
        $table->addColumn('quantity', __('Quantity'));
        $table->addColumn('cost', __('Cost'))->format(function ($row) use ($itemGateway) {
                $item = $itemGateway->getByID($row['itemID']);
                $output = $item['salePrice'] * $row['quantity'];

                return $output;
            });
        $table->addColumn('orderStatus', __('Status'));
        $table->addColumn('orderDate', __('Date'));
        
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
    echo $table->render($orders);
}	

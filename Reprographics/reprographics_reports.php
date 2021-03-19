	
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
    $page->breadcrumbs->add(__('Records'));
    
        //Default Data
        $d = new DateTime('first day of this month');
        $startDate = isset($_GET['startDate']) ? Format::dateConvert($_GET['startDate']) : $d->format('Y-m-d');
        $endDate = isset($_GET['endDate']) ? Format::dateConvert($_GET['endDate']) : date('Y-m-d');
        $deptID = isset($_GET['deptID']) ? $_GET['deptID'] : '';

        $deptGateway = $container->get(DepartmentGateway::class);
        $departments = $deptGateway->selectDepts()->fetchAll(); 
        $orderGateway = $container->get(OrderGateway::class);
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
            ->filterBy('deptID', $deptID)
            ->fromPost();

        
        //Filter
        $form = Form::create('reports', $gibbon->session->get('absoluteURL') . '/index.php', 'get');
        $form->addHiddenValue('q', '/modules/' . $gibbon->session->get('module') . '/reprographics_reports.php');
        $form->setTitle('Report');
        $form->addHeaderAction('print', __('Print'))
            ->setURL('/report.php')
            ->addParams($_GET)
            ->addParam('format', 'print')
            ->addParam('search', $criteria->getSearchText(true))
            ->setTarget('_blank')
            ->displayLabel()
            ->directLink()
            ->addClass('mr-2 underline');
            
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
            
   
    
        $departmentOptions = array_reduce($departments, function ($group, $item) {
              $group[$item['deptID']] = $item['deptName'];
              return $group;
            }, []);
        
        $row = $form->addRow();
            $row->addLabel('deptID', __('Department'));
            $row->addSelect('deptID')
                ->placeholder('All Departments')
                ->fromArray($departmentOptions)->selected($deptID);      
                
        $row = $form->addRow();
            $row->addFooter();
            $row->addSubmit();

        echo $form->getOutput();
        
        if (isset($_GET['deptID'])) { //TODO: make this page work when no dept is selected to show all records
            $orders = $orderGateway->selectBy(['deptID' => $deptID, 'orderStatus' => 'Approved'])->fetchAll();
            $items =  array_unique(array_column($orders, 'itemID'));
            foreach ($items as $item){
                $itemData = $itemGateway->selectBy(['itemID' => $item])->fetchAll();
                $categories[] = $itemData[0]['categoryID'];
                $subCategories[] = $itemData[0]['subCategoryID']; 
            }
            $totalTotalPrice = 0;
            $categories = array_unique($categories);
            $subcategories = array_unique($subCategories);
            foreach ($categories as $category) {
                $categoryData = $categoryGateway->selectBy(['categoryID' => $category])->fetchAll();
                $table = DataTable::createDetails($category);
                $table->addMetaData('gridClass', 'grid-cols-10');
                $table->setTitle($categoryData[0]['categoryName']);
                foreach ($subCategories as $subCategory){
                    $subCategoryData = $subCategoryGateway->selectBy(['subCategoryID' => $subCategory, 'categoryID' => $category])->fetch();
                    if($subCategoryData){
                        $table->addColumn('subcat'.$subCategoryData['subCategoryID'], __($subCategoryData['subCategoryName']))->addClass('col-span-7')->addClass('current');
                        $table->addColumn($subCategoryData['subCategoryID'].'quantity', __('Quantity'))->addClass('col-span-1')->addClass('current');
                        $table->addColumn($subCategoryData['subCategoryID'].'price', __('Price'))->addClass('col-span-1')->addClass('current');
                        $table->addColumn($subCategoryData['subCategoryID'].'tprice', __('Total Price'))->addClass('col-span-1')->addClass('current');
                        $itemData = $itemGateway->selectBy(['subCategoryID' => $subCategory])->fetchAll();
                        $totalPrice = 0;
                        foreach ($itemData as $item){
                            $orderData = $orderGateway->selectBy(['itemID' => $item['itemID'], 'deptID' => $deptID, 'orderStatus' => 'Approved'])->fetchAll();
                            foreach ($orderData as $order){
                                $table->addColumn('order'.$order['orderID'], __($item['itemName']))->addClass('col-span-7');
                                $table->addColumn('order'.$order['orderID'].'quantity', __($order['quantity']))->addClass('col-span-1');
                                $table->addColumn('order'.$order['orderID'].'price', __($item['salePrice']))->addClass('col-span-1');
                                $itemTotalPrice = $item['salePrice'] * $order['quantity'];
                                $table->addColumn('order'.$order['orderID'].'tprice', __($itemTotalPrice))->addClass('col-span-1');
                                $totalPrice += $itemTotalPrice;
                            }
                        }
                        $table->addColumn('subCategory'.$subCategoryData['subCategoryID'].'title', __('Total'))->addClass('col-span-9');
                        $table->addColumn('subCategory'.$subCategoryData['subCategoryID'].'totalPrice', __($totalPrice))->addClass('col-span-1');
                        $totalTotalPrice += $totalPrice;
                    }
                }
                
                echo $table->render([$orders]);
                
            }
            echo '<h3> Sub Total: ' . $totalTotalPrice . '</h3>';    
        }
}

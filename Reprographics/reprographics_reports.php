	
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
        $deptID = isset($_GET['deptID']) ?? '';
        
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
        $form->setTitle('Generate Report');

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
            $row->addLabel('deptID', __('Department'))->description(__('Leave blank for all'));
            $row->addSelect('deptID')
                ->placeholder('Please Select...')
                ->fromArray($departmentOptions);      
                
        $row = $form->addRow();
            $row->addFooter();
            $row->addSubmit();

        echo $form->getOutput();
        
        
        $categories = $categoryGateway->selectCategories()->toDataSet();
        foreach ($categories as $category) {
            
            $table = DataTable::createDetails($category['categoryID']);
            

            $table->setTitle($category['categoryName']);
            $table->addMetaData('gridClass', 'grid-cols-10');
            
            $subCategories = $subCategoryGateway->selectSubCategories($category['categoryID'])->toDataSet();
            foreach ($subCategories as $subCategory){
            
                $table->addColumn('subcat'.$subCategory['subCategoryID'], __($subCategory['subCategoryName']))->addClass('col-span-10');
                
                $items = $itemGateway->selectBy(['subCategoryID' => $subCategory['subCategoryID']])->fetchAll();
                
                foreach ($items as $item){
                    $table->addColumn('item'.$item['itemID'], __($item['itemName']));
                    
                    
                }
            }
            
            echo $table->render([$category]);
        }
        
        
        $orders = $orderGateway->queryOrders($criteria)->toArray();
        
        
}

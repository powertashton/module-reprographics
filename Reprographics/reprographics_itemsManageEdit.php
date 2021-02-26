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
use Gibbon\Forms\DatabaseFormFactory;
use Gibbon\Module\Reprographics\Domain\ItemGateway;
// Module includes
require_once __DIR__ . '/moduleFunctions.php';

$page->breadcrumbs->add(__('Add Item'));
//TODO: REQUIRE CATEGORIES TO BE SET UP
if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_itemsManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    //FORM TO CREATE A CATEGORY
    $moduleName = $gibbon->session->get('module');
    
    $itemID = $_GET['itemID'] ?? '';
    
    $form = Form::create('addCategory', $gibbon->session->get('absoluteURL') . '/modules/' . $moduleName . '/reprographics_itemManageEditProcess.php', 'post');
    $form->setFactory(DatabaseFormFactory::create($pdo));
    $form->addHiddenValue('address', $gibbon->session->get('address'));
    $form->addHiddenValue('itemID', $itemID);
    $data = array();
    $sql = "SELECT categoryID as value, categoryName as name FROM ItemCategory";
           
    $itemGateway = $container->get(ItemGateway::class);
    $values = $itemGateway->getByID($itemID);
             
    $row = $form->addRow();
        $row->addLabel('categoryID', __('Category'));
        $row->addSelect('categoryID')->fromQuery($pdo, $sql, $data)->placeholder()->isRequired();                
    
    $data1 = array();
    $sql1 = "SELECT categoryID as chainedTo, subCategoryID as value, subCategoryName as name FROM ItemSubCategory";
    $row = $form->addRow();
        $row->addLabel('subCategoryID', __('SubCategory'));
        $row->addSelect('subCategoryID')->fromQueryChained($pdo, $sql1, $data1, 'categoryID')->placeholder()->isRequired();
        
    
    $row = $form->addRow();
        $row->addLabel('itemName', __('Item Name'));
        $row->addTextField('itemName')
            ->maxLength(55)
            ->required(); 

    $row = $form->addRow();
        $row->addLabel('realPrice', __('Real Price'));
        $row->addNumber('realPrice')->decimalPlaces(0)->maximum(9999)->setValue('0');
        
    $row = $form->addRow();
        $row->addLabel('salePrice', __('Sale Price'));
        $row->addNumber('salePrice')->decimalPlaces(0)->maximum(9999)->setValue('0');
    
    $form->loadAllValuesFrom($values);
    
    $row = $form->addRow();
        $row->addFooter();
        $row->addSubmit();

    echo $form->getOutput();
}	

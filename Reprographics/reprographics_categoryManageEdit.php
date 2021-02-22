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
use Gibbon\Module\Reprographics\Domain\SubCategoryGateway;

$page->breadcrumbs->add(__('Order Items'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    //TODO: Specific category's subcategories rather than all categories lmao
    $categoryID = $_GET['categoryID'] ?? '';
    
    if (empty($categoryID)) {
        $page->addError(__('No category Selected.'));
    }
    //TODO: TITLE OF THE CATEGORY 
    $subCategoryGateway = $container->get(SubCategoryGateway::class);
    $subCategoryData = $subCategoryGateway->selectSubCategories($categoryID)->toDataSet(); //TODO: MAKE THE GATEWAY A WHERE PLS
    $table = DataTable::create('subcategories');
        $table->setTitle('SubCategories');

        $table->addHeaderAction('add', __('Add'))
                ->addParam('categoryID', $_GET['categoryID'])
                ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_subCategoryManageAdd.php');

        $table->addColumn('subCategoryName', __('Subategory Name'));
        $table->addActionColumn()
                ->addParam('subCategoryID')
                ->format(function ($department, $actions) use ($gibbon, $subCategoryData) {
                    $actions->addAction('edit', __('Edit'))
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_subCategoryManageEdit.php');
                    $actions->addAction('delete', __('Delete'))
                            ->modalWindow()
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_subCategoryManageDelete.php');
                });
        
        echo $table->render($subCategoryData);
}	

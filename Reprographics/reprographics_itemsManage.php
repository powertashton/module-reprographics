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
use Gibbon\Module\Reprographics\Domain\ItemGateway;

$page->breadcrumbs->add(__('View Items'));
//TODO: REQUIRE CATEGORIES TO BE SET UP
if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {

    $itemGateway = $container->get(ItemGateway::class);
    $itemData = $itemGateway->selectItems()->toDataSet();
    $table = DataTable::create('items');
        $table->setTitle('Items');

        $table->addHeaderAction('add', __('Add')) 
                ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_itemsManageAdd.php');
        
        $table->addColumn('categoryName', __('Category'));
        $table->addColumn('subCategoryName', __('SubCategory'));
        $table->addColumn('itemName', __('Item Name'));
        $table->addColumn('realPrice', __('Real Price'));
        $table->addColumn('salePrice', __('Sale Price'));
        $table->addActionColumn()
                ->addParam('itemID')
                ->format(function ($department, $actions) use ($gibbon, $itemData) {
                    $actions->addAction('edit', __('Edit'))
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_itemsManageEdit.php');
                    $actions->addAction('delete', __('Delete'))
                            ->modalWindow()
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_itemsManageDelete.php');
                });
        
        echo $table->render($itemData);
}	

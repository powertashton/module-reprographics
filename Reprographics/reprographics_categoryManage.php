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
use Gibbon\Module\Reprographics\Domain\CategoryGateway;

$page->breadcrumbs->add(__('Order Items'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    //TODO: TABLE WITH ALL THE MAIN CATEGORIES 
    $categoryGateway = $container->get(CategoryGateway::class);
    $categoryData = $categoryGateway->selectCategories()->toDataSet();
    $table = DataTable::create('categories');
        $table->setTitle('Categories');

        $table->addHeaderAction('add', __('Add'))
                ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_categoryManageAdd.php');

        $table->addColumn('categoryName', __('Category Name'));
        //TODO: SHOW THE SUBCATS 
        $table->addActionColumn()
                ->addParam('categoryID')
                ->format(function ($department, $actions) use ($gibbon, $categoryData) {
                    $actions->addAction('edit', __('Edit'))
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_categoryManageEdit.php');
                    $actions->addAction('delete', __('Delete'))
                            ->modalWindow()
                            ->setURL('/modules/' . $gibbon->session->get('module') . '/reprographics_categoryManageDelete.php');
                });
        
        echo $table->render($categoryData);
}	

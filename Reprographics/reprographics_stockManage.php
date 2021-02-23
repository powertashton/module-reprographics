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
$page->breadcrumbs->add(__('Manage Stock'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_stockManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    $moduleName = $gibbon->session->get('module');
    $form = Form::create('manageStock', $gibbon->session->get('absoluteURL') . '/modules/' . $moduleName . '/reprographics_orderProcess.php', 'post');
    $form->addHiddenValue('address', $gibbon->session->get('address'));
    
    $form->setClass('noIntBorder overflow-visible fullWidth standardForm');
    
    $itemGateway = $container->get(ItemGateway::class);
    $itemData = $itemGateway->selectItems()->toDataSet()->toArray();

    $options = array_reduce($itemData, function ($group, $item) {
      $group[$item['categoryName']][$item['subCategoryName']][$item['itemID']] = $item['itemName'];
      return $group;
    }, []);
    
    $row = $form->addRow();
        $row->addLabel('test', __('Test'));
        $row->addDropdown('test')
            ->placeholder('Please Select...')
            ->fromArray($options);
            
    $row = $form->addRow();
        $row->addLabel('currentStock', __('Current Stock'));
        $row->addTextField('Stock')->readOnly();
        
    $row = $form->addRow();
        $row->addFooter();
        $row->addSubmit();

    echo $form->getOutput();

}	

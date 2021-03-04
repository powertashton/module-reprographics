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

use Gibbon\Module\Reprographics\Domain\ItemGateway;
use Gibbon\Tables\DataTable;

$page->breadcrumbs->add(__('Reports'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_order.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    $itemGateway = $container->get(ItemGateway::class);
    $itemData = $itemGateway->selectItems()->toDataSet()->toArray();
    foreach ($itemData as $item) {
        $table = DataTable::create($item['itemID']);
            $table->setTitle($item['itemName']);
             
    }
    echo $table->render($itemData);
}	

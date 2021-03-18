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

use Gibbon\Forms\Prefab\DeleteForm;
use Gibbon\Module\Reprographics\Domain\CategoryGateway;

//Note: This is a modal page
if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    $categoryID = $_GET['categoryID'] ?? '';

    $categoryGateway = $container->get(CategoryGateway::class);
    
    if (empty($categoryID) || !$categoryGateway->exists($categoryID)) {
        $page->addError(__('No Category Selected.'));
    } else {
        $form = DeleteForm::createForm($gibbon->session->get('absoluteURL') . '/modules/' . $gibbon->session->get('module') . "/reprographics_categoryManageDeleteProcess.php");
        $form->addHiddenValue('address', $gibbon->session->get('address'));
        $form->addHiddenValue('categoryID', $categoryID);

        echo $form->getOutput();
    }
}
?>

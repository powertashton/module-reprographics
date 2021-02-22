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

// Module includes
require_once __DIR__ . '/moduleFunctions.php';

$page->breadcrumbs->add(__('Order Items'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    $moduleName = $gibbon->session->get('module');
    $form = Form::create('orderItems', $gibbon->session->get('absoluteURL') . '/modules/' . $moduleName . '/reprographics_categoryManageProcess.php', 'post');
    $form->addHiddenValue('address', $gibbon->session->get('address'));
    $row = $form->addRow();
        $row->addFooter();
        $row->addSubmit();

    echo $form->getOutput();
}	
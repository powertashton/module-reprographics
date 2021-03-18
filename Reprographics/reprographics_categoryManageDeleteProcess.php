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

use Gibbon\Module\Reprographics\Domain\CategoryGateway;
use Gibbon\Module\Reprographics\Domain\ItemGateway;
use Gibbon\Module\Reprographics\Domain\SubCategoryGateway;
// Module includes
include '../../gibbon.php';


$URL = $gibbon->session->get('absoluteURL') . '/index.php?q=/modules/' . $gibbon->session->get('module') . '/reprographics_categoryManage.php';

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
    // Access denied
    $URL = $URL.'&return=error0';
    header("Location: {$URL}");
} else {
    // Proceed!
    $categoryID = $_POST['categoryID']; // The variables you will be processing
   
    // Check that your required variables are present
    if (empty($categoryID)) { 
        $URL = $URL.'&return=error3';
        header("Location: {$URL}");
        exit;
    } 
    $itemGateway = $container->get(ItemGateway::class);
    $itemGateway->deleteWhere(['categoryID' => $categoryID]);
    
    $subCategoryGateway = $container->get(SubCategoryGateway::class);
    $subCategoryGateway->deleteWhere(['categoryID' => $categoryID]);
    
    $categoryGateway = $container->get(CategoryGateway::class);
    if (!$categoryGateway->deleteWhere(['categoryID' => $categoryID])) {
        $URL .= '&return=error2';
        header("Location: {$URL}");
        exit();
    }


    $URL .= "&return=success0";
    header("Location: {$URL}");
    exit();
}

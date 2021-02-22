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
// Module includes
include '../../gibbon.php';


$URL = $gibbon->session->get('absoluteURL') . '/index.php?q=/modules/' . $gibbon->session->get('module') . '/reprographics_categoryManage.php';

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_categoryManage.php')) {
    // Access denied
    $URL = $URL.'&return=error0';
    header("Location: {$URL}");
} else {
    // Proceed!
    $categoryName = $_POST['categoryName']; // The variables you will be processing
    //TODO: THIS
    // Check that your required variables are present
    if (empty($categoryName)) { 
        $URL = $URL.'&return=error3';
        header("Location: {$URL}");
        exit;
    } 
    try {
        $data = ['subCategoryName' => $subCategoryName, 'categoryID' => $categoryID];
        $subCategoryGateway = $container->get(SubCategoryGateway::class);
        $subCategoryID = $subCategoryGateway->insert($data);
            if ($categoryID === false) {
                throw new PDOException('Could not insert subcategory.');
            }
     } catch (PDOException $e) {
            $URL .= '&return=error2';
            header("Location: {$URL}");
            exit();
    }
        
    // Your SQL or Gateway insert query
    $URL .= "&return=success0&categoryID=$categoryID&subCategoryID=$subCategoryID";
    header("Location: {$URL}");
}

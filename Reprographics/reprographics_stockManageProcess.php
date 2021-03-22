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
// Module includes
include '../../gibbon.php';


$URL = $gibbon->session->get('absoluteURL') . '/index.php?q=/modules/' . $gibbon->session->get('module') . '/reprographics_stock.php';

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_stock.php')) {
    // Access denied
    $URL = $URL.'&return=error0';
    header("Location: {$URL}");
} else {
    // Proceed!
    $itemID = $_POST['itemID']; 
    $stock = $_POST['stock']; 
  
    //TODO: THIS
    // Check that your required variables are present
    if (empty($itemID)) { 
        $URL = $URL.'&return=error3';
        header("Location: {$URL}");
        exit;
    } 
    try {
        $data = ['stock'=> $stock];
        $itemGateway = $container->get(ItemGateway::class);
        $itemID = $itemGateway->update($itemID, $data); 
            if ($itemID === false) {
                throw new PDOException('Could not update item.');
            }
     } catch (PDOException $e) {
            $URL .= '&return=error2';
            header("Location: {$URL}");
            exit();
    }
        
    // Your SQL or Gateway insert query
    $URL .= "&return=success0&itemID=$itemID";
    header("Location: {$URL}");
}

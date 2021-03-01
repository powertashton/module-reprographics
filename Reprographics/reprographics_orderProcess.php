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

// Module includes
include '../../gibbon.php';
include './moduleFunctions.php';
use Gibbon\Module\Reprographics\Domain\OrderGateway;

$URL = $gibbon->session->get('absoluteURL') . '/index.php?q=/modules/' . $gibbon->session->get('module') . '/reprographics_order.php';

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_order.php')) {
    // Access denied
    $URL = $URL.'&return=error0';
    header("Location: {$URL}");
} else {
    // Proceed!
    $itemID = $_POST['itemID'];
    $quantity = $_POST['quantity'];
    $deptID = $_POST['deptID'];
    $gibbonPersonID = $gibbon->session->get('gibbonPersonID');
     // The variables you will be processing
    //TODO: THIS
    // Check that your required variables are present
    if (empty($itemID)) { 
        $URL = $URL.'&return=error3';
        header("Location: {$URL}");
        exit;
    } 
    try {
        $data = ['itemID' => $itemID,'deptID' => $deptID, 'gibbonPersonID' => $gibbonPersonID, 'quantity' => $quantity, 'orderStatus' => 'Pending', 'orderDate' => date('Y-m-d')];
        $orderGateway = $container->get(OrderGateway::class);
        $orderID = $orderGateway->insert($data);
            if ($orderID === false) {
                throw new PDOException('Could not insert order.');
            }
     } catch (PDOException $e) {
            $URL .= '&return=error2';
            header("Location: {$URL}");
            exit();
    }
    // Your SQL or Gateway insert query
    $URL .= "&return=success0&orderID=$orderID";
    header("Location: {$URL}");
}

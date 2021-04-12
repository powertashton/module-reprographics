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

$URL = $gibbon->session->get('absoluteURL') . '/index.php?q=/modules/' . $gibbon->session->get('module') . '/reprographics_printers.php';

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_printers.php')) {
    // Access denied
    $URL = $URL.'&return=error0';
    header("Location: {$URL}");
} else {
    $file = $_FILES['file'];
     // The variables you will be processing
    //TODO: THIS
    // Check that your required variables are present
    if (empty($file)) { 
        $URL = $URL.'&return=error3';
        header("Location: {$URL}");
        exit;
    } 
    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
    fgetcsv($csvFile);
     while(($line = fgetcsv($csvFile)) !== FALSE){
        // Get row data
        try {
            $data = array();
            $sql="INSERT INTO Printing(date,department,BWA3Duplex,BWA3DuplexPrice,BWA3Simplex,BWA3SimplexPrice,BWA4Duplex,BWA4DuplexPrice,BWA4Simplex,BWA4SimplexPrice,FCA3Duplex,FCA3DuplexPrice,FCA3Simplex,FCA3SimplexPrice,FCA4Duplex,FCA4DuplexPrice,FCA4Simplex,FCA4SimplexPrice)
                VALUES ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."','".$line[4]."','".$line[5]."','".$line[6]."','".$line[7]."','".$line[8]."','".$line[9]."','".$line[10]."','".$line[11]."','".$line[12]."','".$line[13]."','".$line[14]."','".$line[15]."','".$line[16]."','".$line[17]."')";
            $result = $connection2->prepare($sql);
            $result->execute($data);
        } catch (PDOException $e) {
            $URL .= '&return=error2';
            header("Location: {$URL}");
            exit();
        }
    }
    fclose($csvFile);

    // Your SQL or Gateway insert query
    $URL .= "&return=success0";
    header("Location: {$URL}");
}

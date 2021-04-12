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
use Gibbon\Tables\DataTable;
use Gibbon\Module\Reprographics\Domain\PrinterGateway;
// Module includes
require_once __DIR__ . '/moduleFunctions.php';

$page->breadcrumbs->add(__('Printer'));

if (!isActionAccessible($guid, $connection2, '/modules/Reprographics/reprographics_printers.php')) {
	// Access denied
	$page->addError(__('You do not have access to this action.'));
} else {
    
    $moduleName = $gibbon->session->get('module');
    
    $form = Form::create('importPrint', $gibbon->session->get('absoluteURL') . '/modules/' . $moduleName . '/reprographics_printersProcess.php', 'post');
    $form->addHiddenValue('address', $gibbon->session->get('address'));
    $row = $form->addRow();
        $row->addLabel('file', __('File'));
        $row->addFileUpload('file')->required()->accepts('.csv,.xls,.xlsx');

        $row = $form->addRow();
            $row->addFooter();
            $row->addSubmit();

        echo $form->getOutput();
        
        $printerGateway = $container->get(PrinterGateway::class);
        
        $criteria = $printerGateway->newQueryCriteria(true)
            ->sortBy('date', 'DESC')
            ->fromPOST();
        $records = $printerGateway->queryRecords($criteria);
       
        $table = DataTable::createPaginated('records', $criteria);
        $table->setTitle('Printing Records');
        $table->addColumn('date', __('Date'));
        $table->addColumn('department', __('Department'));
        
        $table->addColumn('BWA3Duplex', __('BWA3 Duplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['BWA3Duplex'];
            $output .= '<br/><span class="small emphasis">'.$record['BWA3DuplexPrice'].'</span>';
            return $output;
        });
        $table->addColumn('BWA3Duplex', __('BWA3 Duplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['BWA3Duplex'];
            $output .= '<br/><span class="small emphasis">'.$record['BWA3DuplexPrice'].'</span>';
            return $output;
        });
        $table->addColumn('BWA3Simplex', __('BWA3 Simplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['BWA3Simplex'];
            $output .= '<br/><span class="small emphasis">'.$record['BWA3SimplexPrice'].'</span>';
            return $output;
        });
        $table->addColumn('BWA4Duplex', __('BWA4 Duplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['BWA4Duplex'];
            $output .= '<br/><span class="small emphasis">'.$record['BWA4DuplexPrice'].'</span>';
            return $output;
        });
        $table->addColumn('BWA4Simplex', __('BWA4 Simplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['BWA4Simplex'];
            $output .= '<br/><span class="small emphasis">'.$record['BWA4SimplexPrice'].'</span>';
            return $output;
        });
        
         
        $table->addColumn('FCA3Duplex', __('FCA3 Duplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['FCA3Duplex'];
            $output .= '<br/><span class="small emphasis">'.$record['FCA3DuplexPrice'].'</span>';
            return $output;
        });
        $table->addColumn('FCA3Simplex', __('FCA3 Simplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['FCA3Simplex'];
            $output .= '<br/><span class="small emphasis">'.$record['FCA3SimplexPrice'].'</span>';
            return $output;
        });
        $table->addColumn('FCA4Duplex', __('FCA4 Duplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['FCA4Duplex'];
            $output .= '<br/><span class="small emphasis">'.$record['FCA4DuplexPrice'].'</span>';
            return $output;
        });
        $table->addColumn('FCA4Simplex', __('FCA4 Simplex'))
        ->description(__('Price'))->format(function ($record) use ($guid) {
            $output = $record['FCA4Simplex'];
            $output .= '<br/><span class="small emphasis">'.$record['FCA4SimplexPrice'].'</span>';
            return $output;
        });
        
        echo $table->render($records);
}	

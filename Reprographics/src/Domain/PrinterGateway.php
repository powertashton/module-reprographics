<?php
namespace Gibbon\Module\Reprographics\Domain; //Replace ModuleName with your module's name, ommiting spaces

use Gibbon\Domain\Traits\TableAware;
use Gibbon\Domain\QueryCriteria;
use Gibbon\Domain\QueryableGateway;

/**
 * Name Gateway
 *
 * @version v21
 * @since   v21
 */
class PrinterGateway extends QueryableGateway //Replace NameGateway with the name of the gateway, 
{
    use TableAware;

    private static $tableName = 'Printing'; //The name of the table you will primarily be querying
    private static $primaryKey = 'id'; //The primaryKey of said table
    private static $searchableColumns = []; // Optional: Array of Columns to be searched when using the search filter
    
    public function selectRecords() { 
        $select = $this
            ->newSelect()
            ->from('Printing')
            ->cols(['id','date', 'department', 'BWA3Duplex', 'BWA3DuplexPrice', 'BWA3Simplex', 'BWA3SimplexPrice', 'BWA4Duplex', 'BWA4DuplexPrice', 'BWA4Simplex', 'BWA4SimplexPrice', 'FCA3Duplex', 'FCA3DuplexPrice', 'FCA3Simplex', 'FCA3SimplexPrice', 'FCA4Duplex', 'FCA4DuplexPrice', 'FCA4Simplex', 'FCA4SimplexPrice']);
        return $this->runSelect($select);
    }
    
    public function queryRecords($criteria) { 
        $query = $this
            ->newQuery()
            ->from('Printing')
            ->cols(['id', 'date', 'department', 'BWA3Duplex', 'BWA3DuplexPrice', 'BWA3Simplex', 'BWA3SimplexPrice', 'BWA4Duplex', 'BWA4DuplexPrice', 'BWA4Simplex', 'BWA4SimplexPrice', 'FCA3Duplex', 'FCA3DuplexPrice', 'FCA3Simplex', 'FCA3SimplexPrice', 'FCA4Duplex', 'FCA4DuplexPrice', 'FCA4Simplex', 'FCA4SimplexPrice']);
        return $this->runQuery($query, $criteria);
    }
    
}


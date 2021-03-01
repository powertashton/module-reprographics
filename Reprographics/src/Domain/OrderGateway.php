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
class OrderGateway extends QueryableGateway //Replace NameGateway with the name of the gateway, 
{
    use TableAware;

    private static $tableName = 'Order'; //The name of the table you will primarily be querying
    private static $primaryKey = 'orderID'; //The primaryKey of said table
    private static $searchableColumns = []; // Optional: Array of Columns to be searched when using the search filter
    
    public function selectOrders() { 
        $select = $this
            ->newSelect()
            ->from('Order')
            ->cols(['orderID', 'itemID', 'gibbonPersonID','quantity', 'orderStatus', 'orderDate']);

        return $this->runSelect($select);
    }
    
    public function queryOrders($criteria, $gibbonPersonID = null) { 
        $query = $this
            ->newQuery()
            ->from('Order')
            ->cols(['orderID', 'itemID', 'gibbonPersonID','quantity', 'orderStatus', 'orderDate']);
        
        if (!empty($gibbonPersonID)) {
            $query->where('Order.gibbonPersonID = :gibbonPersonID')
                ->bindValue('gibbonPersonID', $gibbonPersonID);
        }
        
        return $this->runQuery($query, $criteria);
    }
    
}

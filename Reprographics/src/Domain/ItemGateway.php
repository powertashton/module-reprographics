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
class ItemGateway extends QueryableGateway //Replace NameGateway with the name of the gateway, 
{
    use TableAware;

    private static $tableName = 'Item'; //The name of the table you will primarily be querying
    private static $primaryKey = 'itemID'; //The primaryKey of said table
    private static $searchableColumns = []; // Optional: Array of Columns to be searched when using the search filter
    
    public function selectItems() { //TODO: WHERE SUBCATEGORY ID IS
        $select = $this
            ->newSelect()
            ->from('Item')
            ->cols(['itemID','subCategoryID', 'categoryID', 'itemName'])
            ->orderBy(['itemID']);

        return $this->runSelect($select);
    }
}

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
    
    public function selectItems() { 
        $select = $this
            ->newSelect()
            ->from('Item')
            ->cols(['itemID', 'stock', 'realPrice', 'salePrice', 'Item.subCategoryID', 'Item.categoryID', 'itemName', 'ItemCategory.categoryName AS categoryName', 'ItemSubCategory.subCategoryName AS subCategoryName'])
            ->leftJoin('ItemCategory', 'Item.categoryID=ItemCategory.categoryID')
            ->leftJoin('ItemSubCategory', 'Item.subCategoryID=ItemSubCategory.subCategoryID')
            ->orderBy(['categoryName', 'subCategoryName']);

        return $this->runSelect($select);
    }
}

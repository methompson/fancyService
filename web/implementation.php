<?php

/**
 * Example usage of the UPCSearch Class
 * 
 * First we require the file containing then class
 * 
 * Then, we will define an array of UPC codes that we can run through the program.
 */
require_once('./classes/UPCSearch.php');

$upcs = array(
    '8901',
    '9012',
    '0123',
    '1234',
    '2345',
    '3456',
    '4567',
    '5678',
    '6789',
    '7890',
);

// Instantiate the UPCSearch object, which instantiates the fancyClient and
// the PDO database object in the constructor.
$upcSearch = new UPCSearch();

echo "<h1>Getting UPC Data</h1>";
// We can iterate through the UPC codes and get data from each individual product
foreach($upcs as $upc){
    echo "UPC Code: ".$upc."<br>";
    echo "<pre>".print_r($upcSearch->getProductByUPC($upc), true)."</pre>";
}

echo "<h1>Inserting Data Into Database</h1>";
// We can run a method that takes a UPC code and inserts the data as received
// from FancyClient directly into the database.
foreach($upcs as $upc){
    echo "Inserting ".$upc." into the database<br>";
    $result = $upcSearch->storeUPCByCode($upc);
    if ($result){
        echo "Inserting into database successful<br>";
    } else {
        echo "Inserting into database NOT successful<br>";
    }
}

// However, this may not be the most safe method, should the data include bad
// characters or possibly malicious data. In spite of taking a prepared statement
// approach, we may want to run the data through our own santization filters.
//
// In which case, we can get the data from the getProductByUPC method, process
// the data and then insert it into the database.

// This function takes a string and converts to upper case, obviously in a production
// implementation, we would do something different, but this is just for
// demonstration purposes.

function processData($text)
{
    return strtoupper($text);
}

echo "<h1>Inserting Processed Data Into Database</h1>";
foreach($upcs as $upc){
    $productData = $upcSearch->getProductByUPC($upc);

    // Process the data. Now all data inserted into the database will be uppercase versions
    $productName = processData( $productData['prod_name'] );
    $productDesc = processData( $productData['prod_desc'] );

    $result = $upcSearch->storeProductData($upc, $productName, $productDesc);
    if ($result){
        echo "Inserting into database successful<br>";
    } else {
        echo "Inserting into database NOT successful<br>";
    }
}

// The End Result will be two sets of all the above data in the database,
// The first set will be how it was sent from FancyService.
// The second set will be exactly the same, but uppercase

$db = Mbira\DbConnection::getInstance();
$dbHandle = $db->prepare("SELECT * FROM fancyservice_product_info");
$dbHandle->execute();

echo "<h1>Database Results</h1>";
echo "<pre>".print_r($dbHandle->fetchAll(PDO::FETCH_ASSOC), true)."</pre>";
# UPCSearch

## A PHP Class that interfaces with FancyService.

This class performs 2 very specific tasks:
- Retreieves product data from the FancyService using a UPC Code
- Inserts product data and a UPC Code into the Mbira database

## Methods:

### getProductByUPC($upcCode)
This method retrieves products from the FancyService

string $upcCode - a UPC code to send to FancyService for the purpose of retrieving data

returns an associative array of product data or null if the UPC isn't connected to any product data. The structure of the array:
[ 
    'prod_name' => Name of the product
    'prod_desc' => Description of the product
]

### storeProductData($upcCode, $productName, $productDesc)
This method stores product data in the Mbira database

string $upcCode - a UPC code to send to FancyService for the purpose of retrieving data
string $productName - Name of the product
string $productDesc - Description of the product

returns boolean|null. Returns True if the database insertion was successful, false if the database insertion was unsuccessful (e.g. a value that exceeds the varchar allowance) and null if no product data was sent.

### storeUPCByCode($upcCode)
This method retrieves data from the Fancy Service and stores it into the Mbira Database without any other intervention by the user. Use with caution, in case data needs to be sanitized

string $upcCode - a UPC code to send to FancyService for the purpose of retrieving data

returns boolean|null. Returns True if the database insertion was successful, false if the database insertion was unsuccessful (e.g. a value that exceeds the varchar allowance) and null if no product data was sent.

## Example Usage:

Instantiate a new UPCSearch object:

$upc = new UPCSearch();

Retrieve product data with a UPC Code:

$productData = $upc->getProductByUPC($upcCode);

Save product data to the Database and check the results:

$results = $upc->storeProductData($upcCode, $productData);
if ($results === true){
    // Do something if everyhing is fine.
} else if ($results === false){
    // Do something if saving failed
} else {
    // Do something if no product data was sent to method
}

Retrieve data and immediately place it into the database:

$results = $upc->storeUPCByCode($upcCode);
//Check results for true/false/null
<?php

require_once('client.php');
require_once('mbira.php');

class UPCSearch
{

    protected $db;
    protected $fancyClient;

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Instantiate the fancyClient
        $this->fancyClient = new FancyService\Client( Mbira\Config::get('FancyService') );

        // Instantiate the database
        $this->db = Mbira\DbConnection::getInstance();
    }

    /**
     * Retrieves a Product based on the UPC.
     * 
     * This method takes a UPC Code, uses the FancyService client and
     * returns data about the product associated with the UPC code.
     * 
     * @param string $upcCode A UPC Code to search the FancyService for product information
     * @return array|null An associative array with two keys or null for nothing found.
     *                    [
     *                        'prod_name' => Name of the product.
     *                        'prod_desc' => Description of the product.
     *                    ]
     */
    public function getProductByUPC($upcCode)
    {
        // If a null value is passed, return null
        if (!$upcCode){
            return null;
        }

        try {
            $results = $this->fancyClient->submit($upcCode);
        } catch (Exception $e){
            // FancyService threw an error, maybe echo a statement
            // echo "Runtime Exception: ".$e->getMessage();
            return null;
        }

        return $results;
    }

    /**
     * Stores product data into a database
     * 
     * This method takes a UPC code and product data as returned by getProductByUPC,
     * and stores them into a database. The db PDO instance is retrieved from Mbira
     * and an INSERT is executed.
     * 
     * @param string $upcCode A UPC Code associated with product data
     * @param string $productName The name of the product
     * @param string $productDesc The description of the product
     * 
     * @return boolean|null Whether the data was successfully inserted into the database or null if no product data was sent
     */
    public function storeProductData($upcCode, $productName, $productDesc)
    {
        // Checks if the UPC Code is null, which is the only "NOT NULL" database column
        // Returns null to communicate that the data sent was invalid
        if (is_null($upcCode)){
            return null;
        }

        // TODO Determine if we need to check other data before submitting it to the
        // database, including product title and product description
        
        // Get a database handle with a prepared statement. Insert the UPC code and product data.
        $dbHandle = $this->db->prepare("INSERT INTO fancyservice_product_info VALUES ( null, ?, ?, ?, now() )" );
        $dbHandle->execute( array( $upcCode, $productName, $productDesc ) );

        // Returns True if more than 0 rows were affected and false otherwise (no rows inserted)
        if ($dbHandle->rowCount() > 0){
            return true;
        } else {
            echo "<pre>".print_r( $dbHandle->errorInfo(), true )."</pre>";
            return false;
        }
    }

    /**
     * Gets data from the FancyService AND stores the data in a database
     * 
     * This method takes a UPC Code, runs the getProductByUPC method to retrieve
     * Data about the product, then passes the UPC Code and product data directly
     * To the storeProductData method to store it in the database. The method
     * returns the results from storeProductData
     * 
     * @param string $upcCode A UPC Code associated with product data
     * @return boolean|null Whether the data was successfully inserted into the database or null if no product data was sent
     * 
     */
    public function storeUPCByCode($upcCode)
    {
        // Retrieve the product data
        $productData = $this->getProductByUPC($upcCode);

        echo "<pre>".print_r($productData, true)."</pre>";

        if ( is_null($upcCode) ){
            return null;
        }
        // Stores the product in the database, returns the end result
        return $this->storeProductData( $upcCode, $productData['prod_name'], $productData['prod_desc'] );
    }

}
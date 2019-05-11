<?php
declare(strict_types=1);

require_once('./vendor/autoload.php');
require_once('./classes/UPCSearch.php');

use PHPUnit\Framework\TestCase;

final class UPCSearchTest extends TestCase
{
   
    protected function setUp(): void
    {
        // Create a UPCSearch Object for later use.
        $this->upc = new UPCSearch();

        // Create a database object
        $this->db = Mbira\DBConnection::getInstance();

        // Clear the database. 
        // Obviously we would use a test database in a production environment
        $dbHandle = $this->db->prepare("DELETE FROM fancyservice_product_info");
        $dbHandle->execute();

    }

    protected function tearDown(): void
    {
        // Clear the database. 
        // Obviously we would use a test database in a production environment
        $dbHandle = $this->db->prepare("DELETE FROM fancyservice_product_info");
        $dbHandle->execute();
    }

    // Tests that the $upc object defined is in fact a UPCSearch object
    public function testUPCSearchClass()
    {
        $this->assertInstanceOf(
            UPCSearch::class,
            $this->upc
        );
    }

    // Tests that passing a null value into the UPC Search returns null
    public function testGetProductByUPCIsNullIfPassedNull()
    {
        $this->assertEquals(
            $this->upc->getProductByUPC(null),
            null
        );
    }

    // Tests that getProductByUPC returns an array of values
    public function testGetProductByUPCIsArray()
    {    
        $this->assertIsArray(
            $this->upc->getProductByUPC("1234")
        );
    }

    // Tests that getProductByUPC returns an array with prod_name
    public function testGetProductByUPCHasProductName(){
        $this->assertArrayHasKey(
            'prod_name',
            $this->upc->getProductByUPC("1234")
        );
    }

    // Tests that getProductByUPC returns an array with prod_desc
    public function testGetProductByUPCHasProductDescription(){
        $this->assertArrayHasKey(
            'prod_desc',
            $this->upc->getProductByUPC("1234")
        );
    }

    // Tests that passing a null value to storeProductData will return a null
    public function testStoreProductDataIsNullIfPassedNull()
    {
        $result = $this->upc->storeProductData(null, null, null);

        $this->assertEquals(
            $result,
            null
        );
    }

    // Tests that passing good data to storeProductData will return a true value
    public function testStoreProductDataIsTrueWithGoodData()
    {
        $result = $this->upc->storeProductData("123", "test", "test");

        $this->assertEquals(
            $result,
            true
        );
    }

    // Tests that passing bad data to storeProductData will return a false value
    public function testStoreProductDataIsFallseWithBadData(){
        $result = $this->upc->storeProductData(
            "a very long string that should exceed twenty eight characters",
            "test", "test");

        $this->assertEquals(
            $result,
            false
        );
    }

    // Tests that passing null to storeUPCByCode will return a null value
    public function testStoreUPCByCodeIsNullWithNullUPC()
    {
        $result = $this->upc->storeUPCByCode(null);

        $this->assertEquals(
            $result, 
            null
        );
    }

    // Tests that passing good data to storeUPCByCode will return true
    public function testStoreUPCByCodeIsTrueWithGoodData()
    {
        $result = $this->upc->storeUPCByCode("1234");

        $this->assertEquals(
            $result, 
            true
        );
    }

    // Tests that passing bad data to storeUPCByCode will return false
    public function testStoreUPCByCodeIsFalseWithBadData()
    {
        $result = $this->upc->storeUPCByCode("a very long string that should exceed twenty eight characters");

        $this->assertEquals(
            $result, 
            false
        );
    }

    // Tests that using storeUPCByCode with good data will result in a new
    // row inserted into the database.
    public function testEntryInsertedIntoDatabaseWithGoodData()
    {
        $dbHandle = $this->db->prepare("SELECT COUNT(id) FROM fancyservice_product_info");
        $dbHandle->execute();
        $result = $dbHandle->fetch(PDO::FETCH_ASSOC);

        $priorRows = $result['COUNT(id)'];

        $this->upc->storeUPCByCode("1234");

        $dbHandle->execute();
        $result = $dbHandle->fetch(PDO::FETCH_ASSOC);

        $currentRows = $result['COUNT(id)'];

        $this->assertGreaterThan(
            $priorRows,
            $currentRows
        );
    }

    // Tests that using storeUPCByCode with bad data will result in no
    // new rows inserted into the database
    public function testNoEntryInsertedIntoDatabaseWithBadData()
    {
        $dbHandle = $this->db->prepare("SELECT COUNT(id) FROM fancyservice_product_info");
        $dbHandle->execute();
        $result = $dbHandle->fetch(PDO::FETCH_ASSOC);

        $priorRows = $result['COUNT(id)'];

        $this->upc->storeUPCByCode("a very long string that should exceed twenty eight characters");

        $dbHandle->execute();
        $result = $dbHandle->fetch(PDO::FETCH_ASSOC);

        $currentRows = $result['COUNT(id)'];

        $this->assertEquals(
            $priorRows,
            $currentRows
        );
    }

}
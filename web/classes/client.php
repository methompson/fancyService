<?php
/**
 * This class implementation is provided by FancyService.
 */

namespace FancyService;

/**
 * A client to communicate with FancyService server.
 */
class Client
{
    /**
     * Constructor.
     *
     * @param array $config Contains credentials and service URI.
     */
    public function __construct(array $config)
    {
        // Already implemented.
    }

    /**
     * Send a product UPC and receive product information.
     *
     * @param  string $upc
     * @return array|null  An associative array with two keys or null for nothing found.
     *                     [
     *                         'prod_name' => Name of the product.
     *                         'prod_desc' => Description of the product.
     *                     ]
     * @throws \RuntimeException For unexpected events.
     */
    public function submit($upc)
    {
        $vals = array(
            '8901' => array(
                'prod_name' => 'Product 8901',
                'prod_desc' => 'Product Description 8901'
            ),
            '9012' => array(
                'prod_name' => 'Product 9012',
                'prod_desc' => 'Product Description 9012'
            ),
            '0123' => array(
                'prod_name' => 'Product 0123',
                'prod_desc' => 'Product Description 0123'
            ),
            '1234' => array(
                'prod_name' => 'Product 1234',
                'prod_desc' => 'Product Description 1234'
            ),
            '2345' => array(
                'prod_name' => 'Product 2345',
                'prod_desc' => 'Product Description 2345'
            ),
            '3456' => array(
                'prod_name' => 'Product 3456',
                'prod_desc' => 'Product Description 3456'
            ),
            '4567' => array(
                'prod_name' => 'Product 4567',
                'prod_desc' => 'Product Description 4567'
            ),
            '5678' => array(
                'prod_name' => 'Product 5678',
                'prod_desc' => 'Product Description 5678'
            ),
            '6789' => array(
                'prod_name' => 'Product 6789',
                'prod_desc' => 'Product Description 6789'
            ),
            '7890' => array(
                'prod_name' => 'Product 7890',
                'prod_desc' => 'Product Description 7890'
            ),
        );

        if ( array_key_exists($upc, $vals) ){
            return $vals[$upc];
        } else {
            return null;
        }

    }
}
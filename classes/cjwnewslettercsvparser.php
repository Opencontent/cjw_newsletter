<?php
/**
 * File containing the CjwNewsletterCsvParser class
 *
 * @copyright Copyright (C) 2007-2012 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version //autogentag//
 * @package cjw_newsletter
 * @filesource
 */
/**
 * Class description here
 *
 * @version //autogentag//
 * @package cjw_newsletter
 */

ini_set( 'auto_detect_line_endings', true );

class CjwNewsletterCsvParser
{
    /**
     * Constructor
     *
     * @example classes/CjwNewsletterLog.php
     * @param string $csvFileName
     * @param string $delimiter
     * @param boolean $firstRowIsLabel
     * @param array $csvFieldMappingArray
     * @param boolean $utf8Encode
     * @return void
     */
    function __construct( $csvFileName, $delimiter = ';' , $firstRowIsLabel = true, $csvFieldMappingArray, $utf8Encode = false )
    {
        if ( $delimiter == '\t' )
        {
            $delimiter = '\t';
        }

        $fp = fopen( $csvFileName, 'r' );
        $rowArray = array();
        $c = 0;
        $row = array();
        // $firstRow = array( 'email', 'first_name', 'last_name', 'salutation' );
        $firstRow = array();

        foreach ( $csvFieldMappingArray as $key => $item )
        {
            $firstRow[] = $key;
        }

        if ( $firstRowIsLabel == true )
        {
            $firstRowTmp = fgetcsv( $fp, 1000, $delimiter );
            $c++;
            $firstRow = array();
            foreach ( $csvFieldMappingArray as $key => $item )
            {
                $firstRow[array_search($item, $firstRowTmp)] = $item;  
            }
        }

        // Loop file
        while ( ( $row = fgetcsv( $fp, 1000, $delimiter )) !== FALSE )
        {
            foreach ( $firstRow as $key => $item )
            {
                if ( array_key_exists( $key, $row ) )
                {
                    if ( $utf8Encode !== FALSE )
                    {
                        $rowArray[ $c ] [ $item ] = utf8_encode( $row[ $key ] );
                    }
                    else
                    {
                        $rowArray[ $c ] [ $item ] = $row[ $key ];
                    }
                }
            }

            $c++;
        }

        fclose ( $fp );

        $this->CsvDataArray = $rowArray;
    }

    /**
     * Returns data array
     *
     * @return array
     */
    function getCsvDataArray()
    {
        return $this->CsvDataArray;
    }


    /**
     *
     * @var array
     */

    var $CsvDataArray;
}

?>

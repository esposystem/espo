<?php

/**
 * Tools for generating database agnostic SQL strings.
 */
abstract class SQL
{
    /**
     * Convert an array of column names to a SQL string.
     *
     *  () forms the list of returned columns in a SELECT.
     *
     * The value of a numerically indexed element is taken as a column name.
     *
     * An associative element is taken as a column name/column alias pair.
     *
     * Neither column names nor aliases are escaped or quoted in any way.
     *
     * @param array $Src The array to convert.
     * @retval string SQL string of column names/aliases.
     */
    public static function ToColumnList( $Src )
    {
        $SQL = '';
        $i = 0;
        foreach( $Src as $K => $V )
            $SQL .= ($i++>0?',':'').(is_string($K)?"$K AS $V":$V);

        return $SQL;
    }

    /**
     * Convert an array of column names and booleans to a SQL string.
     *
     * ToOrderBy() forms an ORDER BY clause.
     *
     * The value of each element is the direction of ordering and
     * expected to be boolean.  Boolean TRUE is taken as ascending (ASC)
     * and boolean FALSE is taken as descending (DESC).
     *
     * Column names are not escaped or quoted in any way.
     *
     * @param array $OrderBy An associative array of column names/booleans.
     * @retval string SQL string of column names/directions.
     *
     * @note Any non-string column name or non-boolean value is silently skipped.
     */
    public static function ToOrderBy( $OrderBy )
    {
        $SQL = '';
        $i = 0;
        foreach( $OrderBy as $K => $V )
        {
            if( is_string($K) && is_bool($V) )
            {
                $SQL .= ($i++>0?',':'')."$K ".($V?'ASC':'DESC');
            }
        }

        return $SQL;
    }
}


<?php

/*
 * Database driver that works on a MySQL Database
 * @author David Brown - david@davidbrownucf.com
 * @version 2012.5.25
 * @notes Database driver similar to CodeIgniters
 * @todo Insure SQL injection is the best it can be
 * 
 */
class Database {

    private $_query;

    /**
     * Opens the database
     */
    function __construct() {
        
        require 'app/config/database.php';
        
        $this->connection = mysql_connect(
                $database['host'], $database['user'], $database['pass']
        );

        $this->databaseHandler = mysql_select_db($database['name']);

        if (!$this->connection)
            echo "Database connection failed</br>";

        if (!$this->databaseHandler)
            echo "Unable to select database</br>";

        $this->_query = "";
    }

    function printQuery() {
        echo $this->_query;
    }

    /**
     * Executes query without chaining
     * NO SQL INJECTION PREVENTION
     * @param string $query
     * @return boolean Query execute boolean
     * @todo add SQL injection prevention
     */
    function query($query) {
        return mysql_query($query);
    }

    /**
     * Inserts data into a table
     * @param string $table Table to insert into
     * @param string/array $data Data to input
     * @return boolean Query execute boolean
     */
    function insert($table, $data) {
        $d = $data;
        $this->_query .= 'INSERT INTO ' . $table . ' (';
        foreach ($data as $key => $value) {
            $this->_query .= " `" . $key . "` ";
            if (next($data) == true) {
                $this->_query .= ', ';
            }
        }

        reset($data);
        $this->_query .= ') VALUES (';
        foreach ($data as $key => $value) {
            $this->_query .= $this->preventInjection($value);
            if (next($d) == true) {
                $this->_query .= ', ';
            }
        }

        $this->_query .= ')';
        $query = $this->_query;
        $this->_query = "";
        return mysql_query($query);
    }

    /**
     * Returns the ID of the last row inserted.
     * @return int Returns the id of the last Record inserted
     */
    function lastInsertID() {
        return mysql_insert_id();
    }

    /**
     * Selects tables. If $fields is an array, it outputs each one with a comma. If it is a string, it just outputs that as the column to select
     * @param string/array $fields field(s) to select from.
     * @return object $this Chainable object
     */
    function select($fields) {
        $this->_query .= 'SELECT ';

        if (is_array($fields)) {
            foreach ($fields as $field) {
                //$field = $this->preventInjection($field);
                $this->_query .= "`" . $field . "` ";
                if (next($fields) == true) {
                    $this->_query .= ', ';
                }
            }
        }
        else {
            $this->_query .= "" . $fields . " ";
        }
        return $this;
    }

    /**
     * Selects all from a table
     * @param string $table table to select all from
     * @return object $this Chainable object
     */
    function selectAllFrom($table) {
        $this->_query = 'SELECT * FROM ' . $table . ' ';
        return $this;
    }

    /**
     * Appends the table to the query
     * @param string $table table to pull from
     * @return object $this Chainable object
     */
    function from($table) {
        $this->_query .= 'FROM ' . $table . ' ';
        return $this;
    }

    /**
     * Joins tables (not fully tested. $joinTypes not tested but shouldn't be an issue)
     * @param string $table Name of table to join
     * @param string $where Clause to join table
     * @param string $joinType Type of join. ie left, inner, etc
     * @return object $this Chainable object
     */
    function join($table, $where, $joinType = null) {
        $this->_query .= $joinType . ' JOIN ' . $table . ' ON ' . $where . ' ';
        return $this;
    }

    /**
     * Appends the where operation to the query
     * @param string $field Column operand
     * @param string $value Value the column must equal
     * @return object $this Chainable object
     */
    function where($field, $value) {
        $this->ifWhereInQuery($this->_query);
        $this->whereLogic($field, $value);
        return $this;
    }

    /**
     * Appends the where $field != $value operation to the query
     * @param string $field Column operand
     * @param string $value Value the column must equal
     * @return object $this Chainable object
     */
    function where_not($field, $value) {
        $this->ifWhereInQuery($this->_query);
        $value = $this->preventInjection($value);
        $this->_query .= $field . ' != ' . $value . ' ';
        return $this;
    }

    /**
     * Appends the WHERE $field LIKE $value operation to the query
     * @param string $field Column operand
     * @param string $value Value the column must be like
     * @return object $this Chainable object
     * @todo add clause for a possible AND WHERE/AND LIKE
     */
    function where_like($field, $value) {
        $this->_query .= "WHERE " . $field . " LIKE " . $value . " ";
        return $this;
    }

    /**
     * Appends the WHERE NOT LIKE operation to the query
     * @param string $field Column operand
     * @param string $value Value the column must be like
     * @return object $this Chainable object
     * @todo add clause for a possible AND WHERE/AND LIKE
     */
    function where_not_like($field, $value) {
        $this->_query .= "WHERE NOT " . $field . " LIKE " . $value . " ";
        return $this;
    }

    /**
     * Checks if 'WHERE' exists in the query. If it does it appends 'AND' instead of 'WHERE'
     * @param string $str Current query 
     */
    function ifWhereInQuery($str) {
        if (strpos($str, 'WHERE') == NULL) {
            $this->_query .= 'WHERE ';
        }
        else {
            $this->_query .= 'AND ';
        }
    }

    /**
     * Appends 'OR' then appends the operand/equality
     * @param string $field Column operand
     * @param string $value Value the column must equal
     * @return object $this Chainable object
     */
    function or_where($field, $value) {
        $this->_query .= 'OR ';
        $this->whereLogic($field, $value);
        return $this;
    }

    /**
     * Determines if there is an operator in the where column. If there is it uses that operator. If there isn't, it uses '='
     * @param string $field Column operand
     * @param string $value Value the column must equal
     */
    private function whereLogic($field, $value) {
        $value = $this->preventInjection($value);
        $field = explode(' ', $field);

        if (!isset($field[1]) || empty($field[1])) {
            $field[1] = '=';
        }
        $this->_query .= $field[0] . ' ' . $field[1] . ' ' . $value . ' ';
    }

    /**
     * Appends the order to the query
     * @param string $str Field to order by
     * @return object $this Chainable object
     */
    function order_by($str) {
        if (!empty($str)) {
            $this->_query .= 'ORDER BY ' . $str . ' ';
        }
        return $this;
    }

    /**
     * Appends the limit to the query
     * @param int $limit
     * @param int $offset
     * @return object $this Chainable object
     */
    function limit($limit, $offset = null) {
        if (isset($offset))
            $this->_query .= 'LIMIT ' . $offset . ', ' . $limit;
        else
            $this->_query .= 'LIMIT ' . $limit;
        return $this;
    }

    /**
     * Updates a table based with the information in $update
     * @param int $table Table to update
     * @param string/array $update Associative array of data to update
     * @return boolean Query execute boolean
     */
    function update($table, $update) {
        $current = $this->_query;
        $this->_query = '';
        $this->_query .= 'UPDATE ' . $table . ' ';
        $this->_query .= 'SET ';

        foreach ($update as $key => $value) {
            $this->_query .= $key . "= ".$this->preventInjection($value);
            if (next($update) == true) {
                $this->_query .= ', ';
            }
        }
        $this->_query = $this->_query . '' . $current;
        echo $this->_query . '<br />';
        $query = $this->_query;
        $this->_query = '';
        return mysql_query($query);
    }

    /**
     * Prepends the DELETE clause from a chainable method
     * @return boolean Query execute boolean
     */
    function delete() {
        $query = 'DELETE ';
        $query = $query . '' . $this->_query;
        $this->_query = '';
        return mysql_query($query);
    }

    /**
     * Deletes a row based on the $where clause If $where is not present it deletes all rows in the table 
     * @param string $table Table to delete from
     * @param string/array $where Criteria for deleting. If empty, all rows are deleted
     * @return boolean Query execute boolean
     */
    function delete_row($table, $where = null) {
        $this->_query = 'DELETE FROM ' . $table . ' ';
        if (!empty($where)) {

            if (is_array($where)) {
                foreach ($where as $key => $value) {
                    $this->ifWhereInQuery($this->_query);
                    $this->whereLogic($key, $value);
                }
            }
            else {
                $this->_query .= 'WHERE ' . $where;
            }
        }

        $query = $this->_query;
        $this->_query = '';
        return mysql_query($query);
    }

    /**
     * Drops(deletes) a table
     * @param string $table Table drop/delete
     * @return boolean Query execute boolean
     */
    function drop($table) {
        return mysql_query("DROP TABLE " . $table);
    }

    /**
     * Deletes content of a table
     * @param string $table Table to delete the content of
     * @return boolean Query execute boolean
     */
    function delete_table($table) {
        return mysql_query("DELETE FROM " . $table);
    }

    /**
     * Truncates a table
     * @param string $table Table to truncate
     * @return boolean Query execute boolean
     */
    function truncate($table) {
        return mysql_query("TRUNCATE TABLE " . $table);
    }

    /**
     * Returns the query. Should be used at the end of a chain of methods
     * @return boolean Query execute boolean
     */
    function get() {
        $query = $this->_query;
        $this->num_rows = $query;
        $this->_query = "";
        return mysql_query($query);
    }

    /**
     * Returns result set of a query so that it can be looped through
     * @return ResultSet Result set of the query
     */
    function result($query) {
        return mysql_fetch_assoc($query);
    }

    /**
     * Returns the number of rows from the result of a query
     * @param resultset $result The result from a query
     * @return int Number of rows in the result
     */
    function num_rows($result) {
        return mysql_num_rows($result);
    }

    /**
     * Closes the database connection
     * @return boolean Close status
     */
    function terminate() {
        return mysql_close($this->connection);
    }

    /**
     * Cleans the query to prevent SQL injectins
     * This is not fully tested so feel free to improve upon it
     * @param string $str String to be cleaned
     * @return string Cleaned string
     */
    private function preventInjection($str) {
        $str = stripslashes($str);
        $str = mysql_real_escape_string($str);
        $str = "'" . $str . "'";
        return $str;
    }

}
<?php
/*
 * @ Author Rukhsar Manzoor <rukhsar.man@gmail.com>
 * @ Version 1.0
 * @ Package CrudEngine
 */

class CrudEngine
{

    /*
     * Create variables for credentials to MySQL database
     * The variables have been declared as private. This
     * means that they will only be available with the
     * CrudEngine class
     */

    private $DBHost = "localhost";      // Database Server Change as required
    private $DBUsername = "user";       // Database Username Change as required
    private $DBPassword = "password";   // Database Password Change as required
    private $DBName = "database";       // Database Name Change as required

    /*
    *   Extra variables which will be used by other functions
    */

    private $con = false;           //  To check if the connection is open
    private $result = array();      //  This variable will hold the query result
    private $myQuery = "";          //  Used for debugging process
    private $numResult = "";        //  Used for returing the number of rows


    //  Function to make connection to database

    public function connect() {

        if(!$this->con){

            // mysql_connect() with variables defined at the start of Database class
            $myconn = @mysql_connect($this->DBHost,$this->DBUsername,$this->DBPassword);

            if($myconn){

                // Credentials have been pass through mysql_connect() now select the database
                $selectdb = @mysql_select_db($this->DBName, $myconn);

                if($selectdb){

                    $this->con = true;

                    // Connection has been made return true
                    return true;

                } else {

                    array_push($this->result,mysql_error());

                    // Problem selecting database return false
                    return false;
                }
            } else {

                    array_push($this->result,mysql_error());

                    // Problem connecting return false
                    return false;
            }
        } else {

                    // Connection has already been made return true
                    return true;
        }

    }

    // Function to diconnect from the database

    public function disconnect() {

            if ($this->con) {

            // We have found a connection, try to close it
                if (@mysql_close()) {

                    // We have successfully closed the connection, set the connection variable to false
                    $this->con = false;

                    // Return true tjat we have closed the connection
                    return true;
            }else{

                // We could not close the connection, return false
                return false;
            }
        }
    }

    public function sql($sql) {

        $query = @mysql_query($sql);

                //  Pass back theSQL

        $this->myQuery = $sql;

        if($query) {

                //  If the query return >=1 assign the number of rows to numResults

            $this->numResults = mysql_num_rows($query);

                //  Loop through the query results by the number of rows returned

            for ($i=0; $i < $this->numResults; $i++) {

                $r =    mysql_fetch_array($query);
                $key =  array_keys($r);

                for ($x=0; $x < count($key); $x++;) {

                //  Sanitize keys so only Aplpha Values are allowed

                    if (!is_int($key[$x])) {

                        if (mysql_num_rows($query) >= 1) {

                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        } else {

                            $this->result = null;
                        }
                    }
                }
            }
                //  Query was successful
            return true;

        } else {

            array_push($this->result, mysql_errno());
                //  No rows were returned
            retrun false;
        }

    }

                //  Function to select records from Database

    public function select($table, $rows = '*', $join = null, $where = null, $order = null, $limit = null) {

                // Create query from the variables passed to the function

            $q = 'SELECT '.$rows.' FROM '.$table;

            if($join != null) {

                    $q .= ' JOIN '.$join;
                }
            if($where != null) {

                    $q .= ' WHERE '.$where;
                }
            if($order != null) {

                    $q .= ' ORDER BY '.$order;
                }
            if($limit != null) {

                    $q .= ' LIMIT '.$limit;

                }

                // Pass back the SQL

            $this->myQuery = $q;

                // Check to see if the table exists
            if($this->tableExists($table)) {

                // The table exists, run the query

                $query = @mysql_query($q);

            if($query) {

                // If the query returns >= 1 assign the number of rows to numResults

                $this->numResults = mysql_num_rows($query);

                // Loop through the query results by the number of rows returned

                for($i = 0; $i < $this->numResults; $i++) {

                    $r = mysql_fetch_array($query);

                    $key = array_keys($r);

                    for($x = 0; $x < count($key); $x++) {

                // Sanitizes keys so only alphavalues are allowed

                        if(!is_int($key[$x])) {

                            if(mysql_num_rows($query) >= 1) {

                                $this->result[$i][$key[$x]] = $r[$key[$x]];

                            } else {

                                $this->result = null;
                            }
                        }
                    }
                }

                // Query was successful

                return true;

            } else {

                array_push($this->result,mysql_error());

                // No rows where returned

                return false;
            }
        }   else {

                // Table does not exist
            return false;
        }

    }


                // Function to insert records in Database

    public function insert($table,$params=array()) {

                //  Check to see if the table exists in Database

        if($this->tableExists($table)) {

            $sql = 'INSERT INTO `'.$table.'` (`'.implode('`, `',array_keys($params)).'`) VALUES ("' . implode('", "', $params) . '")';

                //  Pass back the SQL

            $this-myQuery =$sql;

                //  Make the query to insert to the Database

            if($ins=@mysql_query($sql)) {

                array_push($this->result, mysql_insert_id());

                //  The data has been inserted

                return true;

            } else {

                array_push($this->result, mysql_error());

                //  The data has not been inserted

                return false;

            }

        } else {

            //  Table does not exist

            return false;

        }
    }


            //Function to delete table or row(s) from database

    public function delete ($table,$where = null) {

            // Check to see if table exists

        if ($this->tableExists($table)) {

            // The table exists check to see if we are deleting rows or table

            if ($where == null) {

            // Create query to delete table

                $delete = 'DROP TABLE '.$table;

            } else {

            // Create query to delete rows

                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
            }

            // Submit query to database

            if ($del = @mysql_query($delete)) {

                array_push($this->result,mysql_affected_rows());

            // Pass back the SQL

                $this->myQuery = $delete;

            // The query exectued correctly

                return true;

            } else {

                array_push($this->result,mysql_error());

            // The query did not execute correctly

                return false;
            }

        } else {

            // The table does not exist

            return false;
        }
    }

/*
*------------------------------------------------------------------------------------------------------------------
*                               Utility Function for Helping Crud Engine
*------------------------------------------------------------------------------------------------------------------
*/

        //  Private function to check if table exists or not

    private function tableExists($table) {

        $tablesInDb = @mysql_query('SHOW TABLES FROM'.$this->DBName.'LIKE "'.$table.'"');

         if($tablesInDb) {

                    if(mysql_num_rows($tablesInDb)==1) {

                    // The table exists

                        return true;

                    } else {

                        array_push($this->result,$table." does not exist in this database");

                        // The table does not exist

                        return false;
                    }
                }
    }

    /*
    *       To Do
    *           Delete Function
    *           Update Function
    */

}


?>
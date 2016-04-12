<?php
/*
 * @Author Rukhsar Manzoor <rukhsar.man@gmail.com>
 * @Version 1.0
 * @Package CrudEngine
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


}


?>
<?php

function select($table, $columns = "*", $where = "", $path = "")
{
    include($path . 'connect.php');

    $sql = "SELECT $columns FROM $table";

    if (!empty($where)) {
        $sql .= " WHERE " . $where;
    }

    try {
        $result = $db->prepare($sql);
        $result->execute();
        return $result;
    } catch (PDOException $e) {
        echo "Selection failed: " . $e->getMessage();

                // Get the database name
                $stmt = $db->query("SELECT DATABASE()");
                $dbName = $stmt->fetchColumn();
        
                // create message
                $message = "Please check error log..!  select()  ( File: " . $e->getFile() . " On line: " . $e->getLine() . " )  ( Message: " . $e->getMessage() . " )  ( Table Name: "  . $table . " )  ( Database Name: "  . $dbName . " )";
        
                // create discord alert
                discord($message);
        return false;
    }
}


function select_item($table, $columns, $where = "", $path = "")
{
    include($path . 'connect.php');

    $sql = "SELECT $columns FROM $table";

    if (!empty($where)) {
        $sql .= " WHERE " . $where;
    }

    try {
        $result = $db->prepare($sql);
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) { $retun=$row[$columns]; }
        return $retun;
    } catch (PDOException $e) {
        echo "Selection failed: " . $e->getMessage();

                        // Get the database name
                        $stmt = $db->query("SELECT DATABASE()");
                        $dbName = $stmt->fetchColumn();
                
                        // create message
                        $message = "Please check error log..!  select_item()  ( File: " . $e->getFile() . " On line: " . $e->getLine() . " )  ( Message: " . $e->getMessage() . " )  ( Table Name: "  . $table . " )  ( Database Name: "  . $dbName . " )";
                
                        // create discord alert
                        discord($message);
        return false;
    }
}

function select_query($sql, $path = "")
{
    include($path . 'connect.php');

    try {
        $result = $db->prepare($sql);
        $result->execute();
        return $result;
    } catch (PDOException $e) {
        echo "Selection failed: " . $e->getMessage();

                        // Get the database name
                        $stmt = $db->query("SELECT DATABASE()");
                        $dbName = $stmt->fetchColumn();
                
                        // create message
                        $message = "Please check error log..!  select_query()  ( File: " . $e->getFile() . " On line: " . $e->getLine() . " )  ( Message: " . $e->getMessage() . " )  ( Table Name: "  . $table . " )  ( Database Name: "  . $dbName . " )";
                
                        // create discord alert
                        discord($message);
        return false;
    }
}
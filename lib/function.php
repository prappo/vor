<?php
if(file_exists('lib/config.php')) {
 //require 'lib/config.php'; 
}
$pdo;

function settings($val)
{
    mysql_connect(HOST, USER, PASS) or die ("can't connect <br>");
    mysql_select_db(DB) or die ("Can't counnect to database<br>");
    
    $sql = "SELECT * FROM vor_settings";
    $query = mysql_query($sql);
    $row = mysql_fetch_array($query);
    return $row[$val];
}

function settings_update($col, $val)
{
    mysql_connect(HOST, USER, PASS) or die ("can't connect <br>");
    mysql_select_db(DB) or die ("Can't counnect to database<br>");
    $sql = "UPDATE vor_settings SET $col='$val' WHERE id=1";
    $query = mysql_query($sql);
    return $query;
}

function add_menu($url, $value, $style){
    
    echo "<li>
          <a href='$url'>
              <i class='fa fa-$style'></i>
              <span>$value</span>
          </a>
        </li>";
}

function menu_start($surl , $svalue , $sstyle){

echo " <li class='sub-menu'>
        <a href='$surl'>
          <i class='fa fa-$sstyle'></i>
          <span>$svalue</span>
        </a>
        <ul class='sub'>
          
        ";
}

function menu_end(){
    echo "</ul></li>";
}

/**
 * 
 * @param string $plug_name current plugin name
 * @return string will return current plugin path
 */

function plugin_path($plug_name) {
    $plugin_path = 'plugins/'.$plug_name.'/';
    return $plugin_path;
}

function is_assoc_array($a) {
    return is_array($a) && (count($a) !== array_reduce(array_keys($a), create_function('$a, $b', 'return ($b === $a ? $a + 1 : 0);'), 0));
}

function is_admin() {
    if(strtolower(user_type()) == 'admin') {
        return true;
    } else {
        return false;
    }
}

function user_type() {
    global $pdo;

    $username = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

    if(empty($username)) {
        return false;
    } else {
        try {
            $query = "SELECT `type` FROM `vor_admin` WHERE `username` = ?";
            $stmt  = $pdo->prepare($query);
            $stmt->bindParam(1, $username);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['type'];
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

/**
 *
 * @param string $data filter data
 * @return string will return filtered data
 */

function sanitize($data) {
    if(!empty($data)) {
        $data = trim($data);
        $data = strip_tags($data);
        $data = preg_replace('/[^A-Za-z0-9\_\-]/', '', $data);
        $data = strip_tags($data);
        return $data;
    }
}

function db_connect() {
    global $pdo;

    try{
        $pdo = new PDO('mysql:host='.HOST.';dbname='.DB, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Error! Connecting with Database '.$e->getMessage().'<br>';
    }
    return $pdo;
}

/**
 * 
 * @param string $db_name Database name to create
 * @return boolean will return true if successfully created the database
 */

function db_create($db_name) {
    db_connect();
    global $pdo;

    if(empty($db_name) || !is_string($db_name)) {
        echo 'Error! expecting one string parameter (Database Name).<br>';
    } else {
        $result = $pdo->query("SHOW DATABASES LIKE '{$db_name}'");
        if($result->rowCount() > 0) {
            echo 'Error! <b>`'.$db_name.'`</b> Database Already Exists.<br>';
        } else {
            try{
                $stmt = $pdo->prepare("CREATE DATABASE IF NOT EXISTS {$db_name}");
                if($stmt->execute()) {
                    return true;
                }
            } catch (PDOException $e) {
                echo 'Error! Creating Database <b>`'.$db_name.'`</b>'.$e->getMessage().'<br>';
            }
        }
    }
}

/**
 * 
 * @param string $db_name Database name to drop
 * @return boolean will return true if successfully dropped the database
 */

function db_drop($db_name) {
    db_connect();
    global $pdo;

    if(empty($db_name) && !is_string($db_name)) {
        echo 'Error! expecting one string parameter (Database Name).<br>';
    } else {
        $result = $pdo->query("SHOW DATABASES LIKE '{$db_name}'");
        if($result->rowCount() < 1) {
            echo 'Error! <b>`'.$db_name.'`</b> Database not Exists.<br>';
            die();
        } else {
            try{
                $stmt  = $pdo->prepare("DROP DATABASE IF EXISTS {$db_name}");
                if($stmt->execute()) {
                    return true;
                }
            } catch (PDOException $e) {
                echo 'Error! Dropping Database <b>`'.$db_name.'`</b>'.$e->getMessage().'<br>';
            }
        }
    }
}

/**
 * 
 * @param string $tbl_name Table name to create
 * @param array $fields Table structure into an array
 * @return boolean will return true if successfully created the table
 */

function tbl_create($tbl_name, $fields) {
    db_connect();
    global $pdo;

    if(empty($tbl_name) || !is_string($tbl_name) || empty($fields)) {
        echo 'Error! expecting two parameter (Database Name, Fields).<br>';
    } else {
        if(!is_assoc_array($fields)) {
            echo 'Error! fields parameter must be an associative array.<br>';
        } else {
            $result = $pdo->query("SHOW TABLES LIKE '{$tbl_name}'");
            if($result->rowCount() > 0) {
                echo 'Error! <b>`'.$tbl_name.'`<b> Table Already Exists.<br>';
            } else {
                $values = implode(',', $fields);
                $values = explode(",", $values);
                $values = array_map('trim', $values);

                $columns   = array_keys($fields);
                $columns   = implode(',', $columns);
                $columns   = explode(",", $columns);
                $r_columns = array_map('trim', $columns);

                $columns = implode(', ', array_map(function ($c) { return "`$c`";}, $r_columns));
                $params  = implode(', ', array_map(function ($c) { return ":$c";}, $r_columns));

                $query_opt = implode(', ', array_map(function ($values, $columns) { return $columns.' '.$values; }, $fields, array_keys($fields)));

                try{
                    $query  = "CREATE TABLE IF NOT EXISTS {$tbl_name} ({$query_opt})";
                    $stmt   = $pdo->prepare($query);
                    for ($i = 0; $i < count($r_columns); $i++) {
                        $stmt->bindParam(':'.$r_columns[$i], $values[$i]);
                    }
                    if($stmt->execute()) {
                        return true;
                    }
                } catch (PDOException $e) {
                    echo 'Error! Creating Table <b>`'.$tbl_name.'`</b> '.$e->getMessage().'<br>';
                }
            }
        }
    }
}

/**
 * 
 * @param string $tbl_name Table name to drop
 * @return boolean will return true if successfully dropped the table
 */

function tbl_drop($tbl_name) {
    db_connect();
    global $pdo;

    if(empty($tbl_name) && !is_string($tbl_name)) {
        echo 'Error! expecting one string parameter (Table Name).<br>';
    } else {
        $result = $pdo->query("SHOW TABLES LIKE '{$tbl_name}'");
        if($result->rowCount() < 1) {
            echo 'Error! <b>`'.$tbl_name.'`</b> Table not Exists.</br>';
        } else {
            try{
                $stmt = $pdo->prepare("DROP DATABASE IF EXISTS {$tbl_name}");
                if($stmt->execute()) {
                    return true;
                }
            } catch (PDOException $e) {
                echo 'Error! Dropping Table <b>`'.$tbl_name.'`</b>'.$e->getMessage().'<br>';
            }
        }
    }
}

/**
 * 
 * @param string $tbl_name Table name to get rows
 * @param integer $limit [optional] if want to limit rows
 * @param integer $offset [optional] offset of limited rows
 * @return array will return rows from given table
 */

function db_get($tbl_name, $limit = NULL, $offset = NULL) {
    db_connect();
    global $pdo;

    if(empty($tbl_name) || !is_string($tbl_name)) {
        echo 'Error! expecting at least one string parameter (Table Name).<br>';
    } else {
        $result = $pdo->query("SHOW TABLES LIKE '{$tbl_name}'");
        if($result->rowCount() < 1) {
            echo 'Error! <b>`'.$tbl_name.'`</b> Table not Exists.</br>';
        } else {
            if($limit != NULL) {
                if(!is_int($limit)) {
                    echo 'Error! limit parameter must be an integer.<br>';
                } else {
                    if($offset !== NULL) {
                        if(!is_int($offset)) {
                            echo 'Error! offset Parameter must be an integer.<br>';
                            die();
                        } else {
                            $query = "SELECT * FROM {$tbl_name} LIMIT {$offset}, {$limit}";
                        }
                    } else {
                        $query = "SELECT * FROM {$tbl_name} LIMIT {$limit}";
                    }
                }
            } else {
                $query = "SELECT * FROM {$tbl_name}";
            }
            try{
                $stmt = $pdo->prepare($query);
                if($stmt->execute()) {
                     return $stmt->fetchAll();
                }
            } catch (PDOException $e) {
                echo 'Error! Getting Data From <b>`'.$tbl_name.'`</b> '.$e->getMessage().'<br>';
            }
        }
    }
}

/**
 * 
 * @param string $tbl_name Table name to get rows with where clause
 * @param array $where where clause information into an array (column name and coulumn value)
 * @param integer $limit [optional] if want to limit rows
 * @param integer $offset [optional] offset of limited rows
 * @return array will return rows from given table 
 */

function db_get_where($tbl_name, $where, $limit = NULL, $offset = NULL) {
    db_connect();
    global $pdo;

    if(empty($tbl_name) || !is_string($tbl_name) || empty($where)) {
        echo 'Error! expecting at least two parameter (Table Name, Condition).<br>';
    } else {
        $result = $pdo->query("SHOW TABLES LIKE '{$tbl_name}'");
        if($result->rowCount() < 1) {
            echo 'Error! <b>`'.$tbl_name.'`</b> Table not Exists.</br>';
        } else {
            if(!is_assoc_array($where) || count($where) > 1) {
                echo 'Error! where clause parameter must be an associative array and can contain only one value.';
            } else {
                $where_column = array_keys($where);
                $where_column = implode(',', $where_column);
                $where_value  = implode(',', $where);

                if($limit != NULL) {
                    if(!is_int($limit)) {
                        echo 'Error! limit parameter must be an integer.<br>';
                    } else {
                        if($offset !== NULL) {
                            if(!is_int($offset)) {
                                echo 'Error! offset Parameter must be an integer.<br>';
                                die();
                            } else {
                                $query= "SELECT * FROM {$tbl_name} WHERE {$where_column} = ? LIMIT {$offset}, {$limit}";
                            }
                        } else {
                            $query= "SELECT * FROM {$tbl_name} WHERE {$where_column} = ? LIMIT {$limit}";
                        }
                    }
                } else {
                    $query= "SELECT * FROM {$tbl_name} WHERE {$where_column} = ?";
                }
                try{
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(1, $where_value, PDO::PARAM_STR);
                    if($stmt->execute()) {
                        return $stmt->fetchAll();
                    }
                } catch (PDOException $e) {
                    echo 'Error! Getting Data From <b>`'.$tbl_name.'`</b> '.$e->getMessage().'<br>';
                }
            }
        }
    }
}

/**
 * 
 * @param string $tbl_name Table name to insert into the table
 * @param array $fields columns name and columns value into an array
 * @return boolean will return true if successfully inserted
 */

function db_insert($tbl_name, $fields) {
    db_connect();
    global $pdo;
    
    if(empty($tbl_name) || !is_string($tbl_name) || empty($fields)) {
        echo 'Error! expecting at least two parameter (Table Name, Values).<br>';
    } else {
        if(!is_assoc_array($fields)) {
            echo 'Error! fields parameter must be an associative array.<br>';
        } else {
            $values = implode(',', $fields);
            $values = explode(",", $values);
            $values = array_map('trim', $values);

            $columns   = array_keys($fields);
            $columns   = implode(',', $columns);
            $columns   = explode(",", $columns);
            $r_columns = array_map('trim', $columns);

            $columns = implode(', ', array_map(function ($c) { return "`$c`";}, $r_columns));
            $params  = implode(', ', array_map(function ($c) { return ":$c";}, $r_columns));
            try{
                $query = "INSERT INTO {$tbl_name}($columns) VALUES($params)";
                $stmt  = $pdo->prepare($query);
                for ($i = 0; $i < count($r_columns); $i++) {
                    $stmt->bindParam(':'.$r_columns[$i], $values[$i]);
                }
                if($stmt->execute()) {
                    return true;
                }
            } catch (PDOException $e) {
                echo 'Error! Inserting into <b>`'.$tbl_name.'`</b> '.$e->getMessage().'<br>';
            }
        }
    }
}

/**
 * 
 * @param string $tbl_name Table name to update
 * @param array $fields columns name and values into an array to update given table
 * @param array $where column name and value into and array to specify which row to update
 * @return boolean will will return true if successfully updated
 */

function db_update($tbl_name, $fields, $where) {
    db_connect();
    global $pdo;

    if(empty($tbl_name) || !is_string($tbl_name) || empty($fields) || empty($where)) {
        echo 'Error! expecting 3 parameter (Table Name, Fields, Condition).<br>';
    } else {
        if(!is_assoc_array($fields) && !is_assoc_array($where)) {
            echo 'Error! fields and condition parameter must be an associative array.<br>';
        } else {
            $values = implode(', ', $fields);
            $values = explode(', ', $values);
            $values = array_map('trim', $values);

            $columns = array_keys($fields);
            $columns = implode(',', $columns);
            $columns = explode(",", $columns);
            $columns = array_map('trim', $columns);
            $r_columns = $columns;

            $x_columns = implode(', ', $columns);
            $params    = implode(', ', array_map(function ($c) { return ":$c";}, $columns));

            $params  = explode(',', $params);
            $columns = explode(',', $x_columns);
            
            $fields = array_combine($columns, $params);

            $query_set   = implode(', ', array_map(function ($values, $columns) { return $columns.'='.$values; }, $fields, array_keys($fields)));
            $query_where = implode(', ', array_map(function ($values, $columns) { return $columns.'=\''.$values.'\''; }, $where, array_keys($where)));

            $result = $pdo->prepare("SELECT * FROM {$tbl_name} WHERE {$columns[0]} = ?");
            $result->bindParam(1, $values[0]);
            $result->execute();
            if($result->rowCount() < 0) {
                echo 'Error! Not Exists.</br>';
            } else {
                try{
                    $query = "UPDATE {$tbl_name} SET {$query_set} WHERE {$query_where}";
                    $stmt = $pdo->prepare($query);
                    for ($i = 0; $i < count($r_columns); $i++) {
                        $stmt->bindParam(':'.$r_columns[$i], $values[$i]);
                    }
                    if($stmt->execute()) {
                        return true;
                    }
                } catch (PDOException $e) {
                    echo 'Error! Updating <b>`'.$tbl_name.'`</b> '.$e->getMessage().'<br>';
                }
            }
        }
    }
}

/**
 * 
 * @param string $tbl_name Table name to delete row
 * @param array $where an associative array with column name and row's value
 * @return boolean will return true if deleted successfully
 */

function db_delete($tbl_name, $where) {
    db_connect();
    global $pdo;
    
    if(empty($tbl_name) || !is_string($tbl_name) || empty($where)) {
        echo 'Error! expecting two parameter (Table Name, Where).<br>';
    } else {
        $column = '`'.implode('', array_keys($where)).'`';
        $value = implode('', array_values($where));
        
        try{
            $query = "DELETE FROM {$tbl_name} WHERE {$column} = ?";
            $stmt  = $pdo->prepare($query);
            $stmt->bindParam(1, $value);

            if($stmt->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            echo 'Error! Inserting into <b>`'.$tbl_name.'`</b> '.$e->getMessage().'<br>';
        }
    }
}
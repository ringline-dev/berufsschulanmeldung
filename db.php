<?php

//Basic code from https://phppot.com/php/php-login-script-with-session/

class DataModel{

    const SERVERNAME = "db4451.mydbserver.com";
    const USERNAME = "p517531";
    const PASSWORD = "2r+0,ouasmRtmp";
    const DBNAME = "usr_p517531_2";

    //const SERVERNAME = "localhost";
    //const USERNAME = "root";
    //const PASSWORD = "";
    //const DBNAME = "fitnessstudio";

    private $con;

    function __construct(){
        $this->con = $this->getConnection();
    }

    public function getConnection(){
        $con = new mysqli(self::SERVERNAME, self::USERNAME, self::PASSWORD, self::DBNAME);
        if (mysqli_connect_errno()) {
            trigger_error("Problem with connecting to database.");
        }
        return $con;
    }

    //example: select("select * FROM registered_users WHERE id = ? and locked = ?", "is", array($id, $locked))
    public function select($query, $paramType = "", $paramArray = array()){
        $stmt = $this->con->prepare($query);
        if (! empty($paramType) && ! empty($paramArray)) {

            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            return $result;
        }
    }

    public function insert($query, $paramType, $paramArray)
    {
        $stmt = $this->con->prepare($query);
        $this->bindQueryParams($stmt, $paramType, $paramArray);

        $stmt->execute();
        $insertId = $stmt->insert_id;
        return $insertId;
    }


    public function execute($query, $paramType = "", $paramArray = array())
    {
        $stmt = $this->con->prepare($query);

        if (! empty($paramType) && ! empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        $stmt->execute();
    }

    //neccessary to use call_user_func_array, because bind_param will not work with arrays
    public function bindQueryParams($stmt, $paramType, $paramArray = array())
    {
        $paramValueReference[] = & $paramType;
        for ($i = 0; $i < count($paramArray); $i ++) {
            $paramValueReference[] = & $paramArray[$i];
        }
        call_user_func_array(array($stmt,'bind_param'),$paramValueReference);
        //$stmt->bind_param($paramType, $paramArray);
    }

    public function getRecordCount($query, $paramType = "", $paramArray = array())
    {
        $stmt = $this->con->prepare($query);
        if (! empty($paramType) && ! empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        $stmt->execute();
        $stmt->store_result();
        $recordCount = $stmt->num_rows;

        return $recordCount;
    }
}
?>
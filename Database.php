<?php
/**
 * Created by PhpStorm.
 * User: Peace Dube
 * Date: 2018/06/01
 * Time: 07:23 PM
 * Description: This is include and code database class for php.
 */

class Database{

    private $connection;

    public function __construct($sHost, $sUsername, $sPassword, $sDatabase)
    {
        $rCon = mysqli_connect($sHost, $sUsername, $sPassword,$sDatabase);

        // Check connection
        if ( !$rCon ) die("Connection failed: " . mysqli_connect_error());
        return $this->connection = $rCon;
    }

    public function query($sSQL = '')
    {
        $rResult = $this->connection->query($sSQL);
        if ($rResult->num_rows > 0)
            return new ResultSet($rResult);
        else die($this->connection->error);
    }

    function verify($sUsername, $sPassword)
    {
        $rResult = $this->query("select id from users where email='$sUsername' and password='$sPassword'");
        if ( $rResult->numrows() > 0 ) return $rResult->fetchrow();
        else return false;
    }

    public function is_user($sUsername)
    {
        $rResult = $this->query("select id from users where email='$sUsername'");
        if ($rResult->numrows() > 0) return true;
        else return false;
    }
}

class ResultSet {

    private $iNumRows;
    private $iFieldCount;
    private $iCurrentField;
    private $rResultSet;

    function __construct($rResultSet)
    {
        $this->rResultSet = $rResultSet;
    }

    public function numrows()
    {
        return $this->rResultSet->num_rows;
    }

    public function fieldCount()
    {
        return $this->rResultSet->field_count;
    }

    public function currentField()
    {
        return $this->rResultSet->current_field;
    }

    public function fetchrow()
    {
        return $this->rResultSet->fetch_assoc();
    }

    public function seek($iSeekNum = 0)
    {
        return $this->rResultSet->data_seek($iSeekNum);
    }

}

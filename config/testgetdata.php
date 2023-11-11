<?php

include("systemconfig.php");

class TestGetData
{
    private $dbReference;
    var $dbConnect;
    var $result;

    // constructor
    function __construct($dbReference)
    {
        $this->dbReference = $dbReference;
    }
    function __destruct()
    {
    }

    function getAllData()
    {
        $this->dbReference = new systemConfig();
        $this->dbConnect = $this->dbReference->connectDB();
        if ($this->dbConnect == null) {
            $this->dbReference->sendResponse(
                503,
                '{"error_message":}' . $this->dbReference->getStatusCodeMessage(503) . '}'
            );
        }
    }
}
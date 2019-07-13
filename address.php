<?php
include('../config.php');
//CREDENTIALS FOR DB


//LET'S INITIATE CONNECT TO DB
$connection = new mysqli(DBSERVER, DBUSER, DBPASS,DBNAME) or die("Can't connect to server. Please check credentials and try again");
if ($connection->connect_errno) {
    echo "Failed to connect to MySQL: " . $connection->connect_error;
}
//echo $_REQUEST['query'];
//$_POST['address'] = '834 Hollins St';
//$_REQUEST['query'] = '50513';
//CREATE QUERY TO DB AND PUT RECEIVED DATA INTO ASSOCIATIVE ARRAY

if (isset($_GET['partialaddress'])) {
    $query = $_GET['partialaddress'];
    $partial = $connection->real_escape_string($_GET['partialaddress']);
    $sql = $connection->query("SELECT DISTINCT Service_Address FROM waterbill_complete WHERE Service_Address LIKE '%{$partial}%' AND Service_Address NOT LIKE 'B-%' LIMIT 10");
	$returnarray = array();
    while ($row = $sql->fetch_assoc()) {
        $returnarray[] = strtoupper($row['Service_Address']);
        
    }
    //RETURN JSON ARRAY
    echo json_encode ($returnarray);

        /* free result set */
    $sql->free();
    /* close connection */
    $connection->close();
}else if(isset($_POST['address'])){
    $address = $connection->real_escape_string($_POST['address']);
    $sql = $connection->query("SELECT Service_Address,Account_Number,Current_Bill_Date,Current_Balance,Current_Bill_Amount FROM waterbill_complete WHERE Service_Address ='$address' AND Timestamp > '2018-10-12' LIMIT 50");
    $array = array();
    $currentbilldates = array();
    while ($row = $sql->fetch_assoc()) {
        if(!in_array($row['Current_Bill_Date'],$currentbilldates)){
            $array[] = $row;
            $currentbilldates[] = $row['Current_Bill_Date'];
        }

        
    }
    //RETURN JSON ARRAY
    echo json_encode ($array);
    $sql->free();
    /* close connection */
    $connection->close();

}

?>
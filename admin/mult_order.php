<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
//include('config/code-generator.php');
require_once("dbcontroller.php");
$db_handle = new DBController();
// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$database = "rposystem";

// Connect to the database
$conn = mysqli_connect($host, $user, $password, $database);

$item =  $_SESSION["cart_item"];
$prod_code = $item["prod_code"];

$order_id = $_POST['order_id'];
$order_code  = $_POST['order_code'];
$customer_id = $_POST['customer_id'];
$customer_name = $_POST['customer_name'];


//  echo "TOotal Price" . $total_price;
$stmt = $conn->prepare('SELECT  * FROM rpos_products WHERE prod_code = prod_code'); ///select all data from database
$stmt->execute(); ////query execute ($stmt)
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$prod_id =  $row['prod_id'];
print_r($prod_id);


foreach ($_SESSION["cart_item"] as $item) {
    $prod_code = $item["prod_code"];
    $prod_name = $item["prod_name"];
    $quantity = $item["quantity"];
    $prod_price = $item["prod_price"];
    $prod_qty = $item["quantity"];

    $item_price = $item["quantity"] * $item["prod_price"];
    $total_price = ($item["prod_price"] * $item["quantity"]);



    print_r($prod_code);
    $sql = "INSERT INTO rpos_orders (prod_qty, order_id, order_code, customer_id, customer_name, prod_id, prod_name, prod_price)
     VALUES('$prod_qty', '$order_id', '$order_code', '$customer_id', '$customer_name', '$prod_id', '$prod_name', '$prod_price')";

    $stmt = mysqli_prepare($conn, $sql);
    $stmt->execute();



    header('Location: orders.php');
}

<?php
include("db_connection.php");

if (isset($_GET['id'])) {
    $sql = "SELECT * FROM images WHERE img_id=?";
    $statement = $dbc->prepare($sql);
    $statement->bind_param("i", $_GET['id']);
    $statement->execute();
    $result = $statement->get_result();
    $row = $result->fetch_assoc();
    header("Content-type: " . $row["mime_type"]);
    echo $row["img"];
    $statement->close();
}

<?php

include("db_connection.php");

$html = file_get_contents("example.html");

$html_pieces = explode("<!--===entries===-->", $html);

echo $html_pieces[0];

$query = "SELECT * FROM posts";

if ($stmt = $dbc->prepare($query)) {

    // Execute the statement.
    $stmt->execute();

    $result = $stmt->get_result();

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) {

            $a = str_replace('---no---', $row['post_id'], $html_pieces[1]);
            $b = str_replace('---time---', $row['created_at'], $a);
            $c = str_replace('---homepage---', $row['homepage'], $b);
            $d = str_replace('---name---', $row['name'], $c);
            $e = str_replace('---email---', $row['email'], $d);
            $f = str_replace('---comment---', $row['comment'], $e);

            echo $f;
        }
    } else {
        echo "No posts currently";
    }

    // Close the prepared statement.
    $stmt->close();
}

echo $html_pieces[2];

if (isset($_POST['push_button'])) {

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $homepage = validate($_POST['homepage']);
    $comment = validate($_POST['comment']);

    $query = "INSERT INTO posts (post_id, created_at, name, email, homepage, comment) VALUES (NULL, CURRENT_TIMESTAMP(), ?, ?, ?, ?)";

    if ($stmt = $dbc->prepare($query)) {

        // Bind the variables to the parameter as strings. 
        $stmt->bind_param("ssss", $name, $email, $homepage, $comment);

        // Execute the statement.
        $stmt->execute();

        // Close the prepared statement.
        $stmt->close();
    }
}

function validate($data)
{

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);

    return $data;
}

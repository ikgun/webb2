<?php

include("db_connection.php");

$html = file_get_contents("example.html");

$html_pieces = explode("<!--===entries===-->", $html);

echo $html_pieces[0];

$query = "SELECT * FROM posts";

if ($stmt = $dbc->prepare($query)) {

    $stmt->execute();

    $result1 = $stmt->get_result();

    if (mysqli_num_rows($result1) > 0) {
        while ($row1 = $result1->fetch_array(MYSQLI_ASSOC)) {

            $a = str_replace('---no---', $row1['post_id'], $html_pieces[1]);

            $sql = "SELECT * FROM images";
            $stmt = $dbc->prepare($sql);
            $stmt->execute();
            $result2 = $stmt->get_result();

            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
                    if ($row1['post_id'] == $row2['img_id']) {
                        $a = str_replace('---image_src---', "example_2.php?id=" . $row2['img_id'], $a);
                    }
                }
            }

            global $a;

            $a = str_replace('---time---', $row1['created_at'], $a);
            $a = str_replace('---homepage---', $row1['homepage'], $a);
            $a = str_replace('---name---', $row1['name'], $a);
            $a = str_replace('---email---', $row1['email'], $a);
            $a = str_replace('---comment---', $row1['comment'], $a);

            echo $a;
        }
    } else {
        echo "No posts currently";
    }

    $stmt->close();
}

echo $html_pieces[2];

$postInserted = false;
$imgInserted = false;

if (isset($_POST['push_button'])) {

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $homepage = validate($_POST['homepage']);
    $comment = validate($_POST['comment']);

    $dbc->autocommit(false);
    $dbc->begin_transaction();

    $query = "INSERT INTO posts (post_id, created_at, name, email, homepage, comment) 
              VALUES (NULL, CURRENT_TIMESTAMP(), ?, ?, ?, ?)";

    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("ssss", $name, $email, $homepage, $comment);
        $stmt->execute();
        $postInserted = true;
    }

    if (count($_FILES) > 0) {
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $image = file_get_contents($_FILES['file']['tmp_name']);
            $mimetype = $_FILES['file']['type'];
        }
    }

    $sql = "INSERT INTO images (img_id, img, mime_type) VALUES(NULL, ?, ?)";
    $statement = $dbc->prepare($sql);
    $statement->bind_param('ss', $image, $mimetype);
    $statement->execute();
    $imgInserted = true;

    global $postInserted;
    global $imgInserted;

    if ($postInserted && $imgInserted) {
        $dbc->commit();
        echo "Success posting, refresh to see changes!";
    } else {
        $dbc->rollback();
        echo "Error while posting!";
    }
}

function validate($data)
{

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);

    return $data;
}

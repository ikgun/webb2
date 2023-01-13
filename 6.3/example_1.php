<?php

//This program inserts a post with an image to the database, however the the image insertion and post insertion are bound
//together in 1 transaction as they make up 1 post. If one fails the other cant execute also. 

include("db_connection.php"); //connecting to the db

$html = file_get_contents("example.html"); //reading html page

$html_pieces = explode("<!--===entries===-->", $html); //splitting html page

echo $html_pieces[0]; //printing the first piece

$query = "SELECT * FROM posts"; //selecting all posts in db

if ($stmt = $dbc->prepare($query)) { //if query is prepared to execute

    $stmt->execute(); //execute the statement

    $result1 = $stmt->get_result(); //get the result set of the query

    if (mysqli_num_rows($result1) > 0) { //if the result set has any data
        while ($row1 = $result1->fetch_array(MYSQLI_ASSOC)) { //fetch the data one by one

            $a = str_replace('---no---', $row1['post_id'], $html_pieces[1]); //replace the first string with the data

            //select all images in db
            $sql = "SELECT * FROM images";
            $stmt = $dbc->prepare($sql);
            $stmt->execute();
            $result2 = $stmt->get_result();

            //if there are any images
            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) { //fetch img data
                    //if the post id is same with the img id (as they are submitted together they have the same insert number)
                    if ($row1['post_id'] == $row2['img_id']) { 
                        //replace the image source string with the second pages link so that the image can be shown
                        $a = str_replace('---image_src---', "example_2.php?id=" . $row2['img_id'], $a);
                    }
                }
            }

            global $a; // make the returned new string global as its local

            //continue replacing the string with the data fetched from the db each time a new string is given,
            //each time the changes are made inside the newly returned string
            $a = str_replace('---time---', $row1['created_at'], $a); 
            $a = str_replace('---homepage---', $row1['homepage'], $a);
            $a = str_replace('---name---', $row1['name'], $a);
            $a = str_replace('---email---', $row1['email'], $a);
            $a = str_replace('---comment---', $row1['comment'], $a);

            echo $a;  //print the page with posts
        }
    } else { //if there are no posts 
        echo "No posts currently";
    }

    $stmt->close(); //close the statement
}

echo $html_pieces[2]; //print the last piece of html to complete the page

//creating two flags to keep track of the two transactions (making them one) because if one is not true, the 
//other one cant be inserted either
$postInserted = false;
$imgInserted = false;

if (isset($_POST['push_button'])) { //if the user submits the form

    //clean user input to defend against XSS attack
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $homepage = validate($_POST['homepage']);
    $comment = validate($_POST['comment']);

    //stop the queries from automatically comitting, basically stopping any transactions that would cause
    //changes in db
    $dbc->autocommit(false);
    //beginning the transaction
    $dbc->begin_transaction();

    //first query, binding the values later on to defend against SQL injection
    $query = "INSERT INTO posts (post_id, created_at, name, email, homepage, comment) 
              VALUES (NULL, CURRENT_TIMESTAMP(), ?, ?, ?, ?)";

    if ($stmt = $dbc->prepare($query)) {
        $stmt->bind_param("ssss", $name, $email, $homepage, $comment);
        $stmt->execute();
        $postInserted = true; //if everything goes well, post is inserted
    }

    if (count($_FILES) > 0) { //if there are any files in the FILE array
        if (is_uploaded_file($_FILES['file']['tmp_name'])) { //if the file taken from the form is uploaded
            $image = file_get_contents($_FILES['file']['tmp_name']); //get its contents
            $mimetype = $_FILES['file']['type']; //get its MIME type
        }
    }

    //the second query
    $sql = "INSERT INTO images (img_id, img, mime_type) VALUES(NULL, ?, ?)";
    $statement = $dbc->prepare($sql);
    $statement->bind_param('ss', $image, $mimetype);
    $statement->execute();
    //if everything goes correctly the code will continue to execute, if sth goes wrong it will stop so the second
    //flag wont be true
    $imgInserted = true;

    global $postInserted;
    global $imgInserted;

    //if both of the flags are true, if both of the insertions were successfully executed
    if ($postInserted && $imgInserted) {
        $dbc->commit(); //then we can commit the changes to the db together
        echo "Success posting, refresh to see changes!";
    } else {
        //if there was an error the transaction is cancelled, restoring the db to an error-free state
        echo "Error while posting!";
    }
}

function validate($data) //function to clean the user input to defend against XSS attack
{

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);

    return $data;
}

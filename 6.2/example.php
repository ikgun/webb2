<?php
//This program inserts data to db and outputs those values to the webpage as well
include("db_connection.php"); //fetching db connection

$html = file_get_contents("example.html"); //reading html file

$html_pieces = explode("<!--===entries===-->", $html); //splitting the page according to the delimiter

echo $html_pieces[0]; //printing out the first piece

$query = "SELECT * FROM posts"; // selecting all posts to print out all posts

if ($stmt = $dbc->prepare($query)) { //if query successfully prepared for execution

    // Execute the statement.
    $stmt->execute();

    $result = $stmt->get_result(); //fetch the result set

    if (mysqli_num_rows($result) > 0) { //if there is any data
        while ($row = $result->fetch_array(MYSQLI_ASSOC)) { //fetch each data to gets its info

            //replace the string inside the html page with the values fetched from the data
            // each time the method successfully executes it returns back the newley changed string
            // thats why we use the new string everytime, not the second html piece we got in the first place
            $a = str_replace('---no---', $row['post_id'], $html_pieces[1]);
            $b = str_replace('---time---', $row['created_at'], $a);
            $c = str_replace('---homepage---', $row['homepage'], $b);
            $d = str_replace('---name---', $row['name'], $c);
            $e = str_replace('---email---', $row['email'], $d);
            $f = str_replace('---comment---', $row['comment'], $e);

            echo $f; //we echo the last replaced string
        }
    } else { //if there is np data
        echo "No posts currently";
    }

    // Close the prepared statement.
    $stmt->close();
}

echo $html_pieces[2]; // we echo the last html piece so the page is complete 

if (isset($_POST['push_button'])) { //if user submits the form

    //clean up all user input to prevent XSS attacks
    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $homepage = validate($_POST['homepage']);
    $comment = validate($_POST['comment']);


    //insert the new post with the user input values, however not putting the values directly to prevent SQL injection
    $query = "INSERT INTO posts (post_id, created_at, name, email, homepage, comment) VALUES (NULL, CURRENT_TIMESTAMP(), ?, ?, ?, ?)";

    if ($stmt = $dbc->prepare($query)) { //if the query is successfully prepared to be executed

        // Bind the variables to the parameter as strings. 
        $stmt->bind_param("ssss", $name, $email, $homepage, $comment); //first bind the clean input values with the query

        // Execute the statement.
        $stmt->execute();

        // Close the prepared statement.
        $stmt->close();
    }
}

//This function cleans the user input to defend against XSS attack
function validate($data)
{

    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);

    return $data;
}

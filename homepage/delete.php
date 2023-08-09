<?php
if (isset($_GET['id'])) {
    include("connect.php");
    $id = $_GET['id'];
    $sql = "DELETE FROM people WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        // Set cookie instead of session
        setcookie("delete", "Person Information Deleted Successfully!", time() + 3600, "/");

        header("Location: homelog.php");
    } else {
        die("Something went wrong");
    }
} else {
    echo "Person does not exist";
}
?>

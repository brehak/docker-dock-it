<?php
require_once "includes/database.php";

/**
 * @var mysqli $db Database Connection
 */

$movie_id = $_GET['horror_movie_id'] ?? null;

if ($movie_id) {
    // deleting the movie from database.
    $query = "DELETE 
                FROM horrormovie 
                WHERE horror_movie_id = '$movie_id'";
    $result = mysqli_query($db, $query);

    if ($result) {
        header("Location: movies.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>

<?php include 'includes/footer.php' ?>
<?php
include "includes/header.php";
require_once "includes/database.php";

/**
 * @var mysqli $db Database Connection
 */

$movie_id = $_GET['horror_movie_id'] ?? null;

if ($movie_id) {
    // fetch movie data
    $query = "SELECT * 
            FROM horrormovie 
            WHERE horror_movie_id = '$movie_id'";
    $result = mysqli_query($db, $query);
    $movie = mysqli_fetch_assoc($result);
}

// form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $year = $_POST['year'] ?? '';
    $theme = $_POST['theme'] ?? '';
    $rating = $_POST['rating'] ?? '';

    // Update movie record
    $query = "UPDATE horrormovie 
              SET horror_movie_name = '$name', horror_movie_year = '$year', horror_movie_theme = '$theme', horror_rating = '$rating'
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

<h1>Edit Movie</h1>
<form method="post">
    <div>
        <label>Movie Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($movie['horror_movie_name'] ?? '') ?>" required>
    </div>
    <div>
        <label>Release Year:</label>
        <input type="number" name="year" value="<?= htmlspecialchars($movie['horror_movie_year'] ?? '') ?>" required>
    </div>
    <div>
        <label>Theme:</label>
        <input type="text" name="theme" value="<?= htmlspecialchars($movie['horror_movie_theme'] ?? '') ?>" required>
    </div>
    <div>
        <label>Rating:</label>
        <input type="number" name="rating" step="0.1" value="<?= htmlspecialchars($movie['horror_rating'] ?? '') ?>" required>
    </div>
    <button type="submit">Save</button>
</form>

<?php include 'includes/footer.php' ?>
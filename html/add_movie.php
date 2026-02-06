<?php
include "includes/header.php";
require_once "includes/database.php";

/**
 * @var mysqli $db Database Connection
 */

// form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $year = $_POST['year'] ?? '';
    $theme = $_POST['theme'] ?? '';
    $rating = $_POST['rating'] ?? '';

    // new horror movie record
    $query = "INSERT 
                INTO horrormovie (horror_movie_name, horror_movie_year, horror_movie_theme, horror_rating)
                VALUES ('$name', '$year', '$theme', '$rating')";
    $result = mysqli_query($db, $query);

    if ($result) {
        header("Location: movies.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($db);
    }
}
?>

<h1>Add New Movie</h1>
<form method="post">
    <div>
        <label>Movie Name:</label>
        <input type="text" name="name" required>
    </div>
    <div>
        <label>Release Year:</label>
        <input type="number" name="year" required>
    </div>
    <div>
        <label>Theme:</label>
        <input type="text" name="theme" required>
    </div>
    <div>
        <label>Rating:</label>
        <input type="number" name="rating" step="0.1" required>
    </div>
    <button type="submit">Add Movie</button>
</form>

<?php include "includes/footer.php"; ?>

<?php
$pageTitle = "MoviesPage";
include "includes/header.php";

/**
 * @var $db mysqli Database Connection
 */
require_once "includes/database.php";

// Sorting and Selection
$selected_movie = isset($_GET['horror_movie_id']) ? (int)$_GET['horror_movie_id'] : null;
$sort = $_GET['sort'] ?? 'horror_movie_name';
$dir = $_GET['dir'] ?? 'ASC';
$next_dir = $dir === 'ASC' ? 'DESC' : 'ASC';

// review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $movie_id = (int)$_POST['movie_id'];
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($db, $_POST['comment']);

    if ($rating >= 1 && $rating <= 5) {
        $insert = "INSERT INTO horrorreviewuser (horror_movie_id, review_rating, review_comment)
                   VALUES ($movie_id, $rating, '$comment')";
        $result = mysqli_query($db, $insert);

        if ($result) {
            header("Location: movies.php?horror_movie_id=$movie_id");
            exit;
        } else {
            echo "<p style='color:red;'>Error submitting review: " . mysqli_error($db) . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Rating must be between 1 and 5.</p>";
    }
}
?>

<h1>Horror Movies</h1>

<p>
    Browse the collection! This page lists all the horror movies in my
    database—each with a short review, release year, theme, and honest
    rating. You can sort movies by rating (1–5 stars), name (A–Z), or
    release year (2020–2025) to find exactly what you're looking for.
    Add your own favorites or want to clean things up? You can add, edit,
    or delete movies anytime on this page as well.
</p>

<button class="btn btn-primary" onclick="location.href='index.php'">Home</button>
<button class="btn btn-primary" onclick="location.href='add_movie.php'">Add New Movie</button>

<div class="container">
    <?php if ($selected_movie): ?>
        <section>
            <h2>Movie Reviews</h2>
            <button onclick="location.href='movies.php'">Back to Movies</button>

            <h3>Official Reviews</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Review Name</th>
                    <th>Comment</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT horror_review_name, horror_review_comment 
                          FROM horrorreview 
                          WHERE horror_review_movie_id = $selected_movie";

                $result = mysqli_query($db, $query);
                if (!$result) {
                    die("Query failed: " . mysqli_error($db));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['horror_review_name']) . "</td>
                        <td>" . htmlspecialchars($row['horror_review_comment']) . "</td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>

            <br>

            <h3>Leave Your Review</h3>
            <form method="post">
                <input type="hidden" name="movie_id" value="<?= $selected_movie ?>">
                <div>
                    <label for="rating">Rating (1–5):</label>
                    <input type="number" name="rating" min="1" max="5" required>
                </div>
                <div>
                    <label for="comment">Comment (max 255 characters):</label>
                    <textarea name="comment" maxlength="255" required></textarea>
                </div>
                <button type="submit" name="submit_review" >Submit Review</button>
            </form>

            <h3>User Reviews</h3>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Rating</th>
                    <th>Comment</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT review_rating, review_comment 
                          FROM horrorreviewuser 
                          WHERE horror_movie_id = $selected_movie";

                $result = mysqli_query($db, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['review_rating']} / 5</td>
                        <td>" . htmlspecialchars($row['review_comment']) . "</td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
    <?php else: ?>
        <section>
            <h2>Horror Movies</h2>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th><a href="?sort=horror_movie_name&dir=<?= $next_dir ?>">Movie Name</a></th>
                    <th><a href="?sort=horror_movie_year&dir=<?= $next_dir ?>">Release Year</a></th>
                    <th>Theme</th>
                    <th><a href="?sort=horror_rating&dir=<?= $next_dir ?>">Rating</a></th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT horror_movie_id, horror_movie_name, horror_movie_year, horror_movie_theme, horror_rating 
                          FROM horrormovie 
                          ORDER BY $sort $dir";
                $result = mysqli_query($db, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td><a href='movies.php?horror_movie_id={$row['horror_movie_id']}'>{$row['horror_movie_name']}</a></td>
                        <td>{$row['horror_movie_year']}</td>
                        <td>{$row['horror_movie_theme']}</td>
                        <td>{$row['horror_rating']}</td>
                        <td>
                            <a href='edit_movie.php?horror_movie_id={$row['horror_movie_id']}'>Edit</a> |
                            <a href='delete_movie.php?horror_movie_id={$row['horror_movie_id']}'
                               onclick=\"return confirm('Are you suuuuuuure you want to delete this movie???');\">Delete</a>
                        </td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </section>
    <?php endif; ?>
</div>

<?php include "includes/footer.php"; ?>

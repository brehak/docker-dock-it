<?php
$pageTitle = "RehakFinalHome";
include "includes/header.php"; ?>

<?php

/**
 * @var $db mysqli Database Connection
 */
require_once "includes/database.php";
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

<h1>Horror Movie Database (2020 - 2025)</h1>

<p>
    This is a chill place to check out some of the best (and weirdest)
    horror movies from the past few years. Every movie has a quick review,
    honest rating, and is sorted by theme—so you can find your next scary
    movie fast. Feel free to add new ones, update info, or delete stuff
    that doesn’t belong.
</p>

    <button onclick="location.href='movies.php'">Movies</button>

<div id="carouselExampleFade" class="carousel slide carousel-fade">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="includes/images/substance.jpg" class="d-block w-100" alt="SubstancePoster">
        </div>
        <div class="carousel-item">
            <img src="includes/images/smile.jpg" class="d-block w-100" alt="SmilePoster">
        </div>
        <div class="carousel-item">
            <img src="includes/images/evildead.jpg" class="d-block w-100" alt="EvilDeadPoster">
        </div>
        <div class="carousel-item">
            <img src="includes/images/invisibleman.jpg" class="d-block w-100" alt="InvisibleManPoster">
        </div>
        <div class="carousel-item">
            <img src="includes/images/vhs.jpg" class="d-block w-100" alt="VHSPoster">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<?php include 'includes/footer.php'; ?>
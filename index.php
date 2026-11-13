<?php
/*
    Author: Michael Barnes
    Date: November 13, 2026
*/
$today = date('F j, Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Student Directory project for Web, Programming, and Database Foundations.">
    <title>Student Directory | Home</title>
    <link rel="stylesheet" href="styles/main.css">
    <script src="scripts/main.js" defer></script>
</head>
<body>
    <header class="site-header">
        <h1>Student Directory</h1>
        <h2>Michael Barnes</h2>
        <p class="date">Today's date: <?php echo htmlspecialchars($today); ?></p>
    </header>

    <main class="container">
        <section id="ImageGallery" aria-labelledby="gallery-heading">
            <h2 id="gallery-heading">Technology Gallery</h2>

            <div class="gallery">
                <figure>
                    <img src="media/computer.svg" alt="Illustration of a desktop computer and monitor">
                    <figcaption>Computer Technology</figcaption>
                </figure>

                <figure>
                    <img src="media/database.svg" alt="Illustration of a database server with stored information">
                    <figcaption>Database Management</figcaption>
                </figure>

                <figure>
                    <img src="media/web-development.svg" alt="Illustration of a web development workspace">
                    <figcaption>Web Development</figcaption>
                </figure>
            </div>
        </section>

        <section class="search-section" aria-labelledby="search-heading">
            <h2 id="search-heading">Find a Student</h2>
            <p>Enter a student's last name to search the directory.</p>

            <form action="search.php" method="POST">
                <label for="last_name">Student Last Name</label>
                <input
                    type="text"
                    id="last_name"
                    name="last_name"
                    maxlength="50"
                    autocomplete="family-name"
                    required
                >
                <button type="submit">Search Students</button>
            </form>
        </section>
    </main>

    <footer class="site-footer">
        <p>&copy; <?php echo date('Y'); ?> Michael Barnes | Student Directory Project</p>
    </footer>
</body>
</html>

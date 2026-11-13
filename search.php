<?php
/*
    Author: Michael Barnes
    Date: November 13, 2026
*/

$students = [];
$searchTerm = '';
$errorMessage = '';
$searchSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST';

if ($searchSubmitted) {
    $searchTerm = trim($_POST['last_name'] ?? '');

    if ($searchTerm === '') {
        $errorMessage = 'Please enter a last name to search.';
    } else {
        try {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

            $connection = new mysqli(
                'db',
                'db',
                'db',
                'student_directory'
            );

            $connection->set_charset('utf8mb4');

            $statement = $connection->prepare(
                'CALL search_students(?)'
            );

            $statement->bind_param('s', $searchTerm);
            $statement->execute();

            $result = $statement->get_result();

            while ($student = $result->fetch_assoc()) {
                $students[] = $student;
            }

            $result->free();

            // Clear any additional stored-procedure result sets.
            while ($statement->more_results()) {
                $statement->next_result();

                if ($extraResult = $statement->get_result()) {
                    $extraResult->free();
                }
            }

            $statement->close();
            $connection->close();

        } catch (mysqli_sql_exception $exception) {
            error_log($exception->getMessage());
            $errorMessage = 'Unable to complete the search. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Search results from the student directory.">
    <title>Search Results | Student Directory</title>
    <link rel="stylesheet" href="styles/main.css">
    <script src="scripts/main.js" defer></script>
</head>
<body>
    <header class="site-header">
        <h1>Student Directory</h1>
    </header>

    <main class="container results-section">
        <?php if ($errorMessage !== ''): ?>
            <p class="message error" role="alert">
                <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?>
            </p>

        <?php elseif (!$searchSubmitted): ?>
            <p class="message">Please return to the home page to search for a student.</p>

        <?php elseif (count($students) === 0): ?>
            <p class="message">No students found.</p>

        <?php else: ?>
            <p class="message">
                Found <?php echo count($students); ?> student(s) matching
                "<?php echo htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>".
            </p>

            <h3>Search Results</h3>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $studentIndex = 0;
                        while ($studentIndex < count($students)):
                            $student = $students[$studentIndex];
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars((string) $student['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($student['first_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($student['last_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($student['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php $studentIndex++; endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a class="back-link" href="index.php">Return to Home Page</a>
    </main>

    <footer class="site-footer">
        <p>&copy; <?php echo date('Y'); ?> Michael Barnes | Student Directory Project</p>
    </footer>
</body>
</html>

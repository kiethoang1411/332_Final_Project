<?php
    include_once 'mysql_connector.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Professor Panel</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
    <div class="center">
        <h1>Professor and Course Search</h1>

        <!-- Professor SSN input -->
        <form method="post">
            <label for="ssn">Professor's SSN:</label>
            <input type="text" id="ssn" name="ssn">
            <input type="submit" value="Submit">
        </form>

        <!-- Course and Section input -->
        <form method="post">
            <label for="course_id">Course ID:</label>
            <input type="text" id="course_id" name="course_id">
            <label for="section_id">Section ID:</label>
            <input type="text" id="section_id" name="section_id">
            <input type="submit" value="Submit">
        </form>

        <?php
            // Query the professor's information given ssn
            if (isset($_POST['ssn'])) {
                $ssn = $_POST['ssn'];
                $query = "SELECT Course.title, Section.classroom, Section.meeting_days, Section.start_time, Section.end_time
                        FROM Professor
                        JOIN Section ON Professor.id = Section.professor_id
                        JOIN Course ON Section.course_id = Course.id
                        WHERE Professor.ssn = '$ssn'";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    // Display classes taught by professor
                    echo "<br>" . "Classes taught by professor with SSN $ssn:<br><br>";
                    echo "<table>
                    <tr>
                        <th>Course Title</th>
                        <th>Meeting Days</th>
                        <th>Time</th>
                        <th>Classroom</th>
                    </tr>";
                    // Table data
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>
                                <td>" . $row['title'] . "</td>
                                <td>" . $row['meeting_days'] . "</td>
                                <td>" . $row['start_time'] . " - " . $row['end_time'] . "</td>
                                <td>" . $row['classroom'] . "</td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "This professor does not teach any courses or there is no professors with that SSN.";
                }
            }
        ?>

        <?php
            // Query the number of students and their grades for a given course section
            if (isset($_POST['course_id']) && isset($_POST['section_id'])) {
                $course_id = $_POST['course_id'];
                $section_id = $_POST['section_id'];

                $query = "SELECT grade, COUNT(*) AS count
                        FROM Enrollment
                        WHERE course_id = $course_id AND section_id = $section_id
                        GROUP BY grade";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    echo "<table>
                    <tr>
                        <th>Grade</th>
                        <th>Student Count</th>
                    </tr>";
                    // Display number of students and their grades
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row['grade'] . "</td>
                                <td>" . $row['count'] . "</td>
                        </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "This course section has no students or there is no courses/sections with those IDs.";
                }
            }
        ?>
    </div>    
</body>
</html>

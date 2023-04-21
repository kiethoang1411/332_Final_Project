<?php
    include_once 'mysql_connector.php';
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Student Panel</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
    <div class="center">
        <h1>Student Search</h1>

        <!-- Course ID input -->
        <form method="post">
          <label for="course_id">Course ID:</label>
          <input type="text" name="course_id" id="course_id">
          <input type="submit" value="Submit">
        </form>

        <!-- Student Campus ID input -->
        <form method="post">
          <label for="campus_id">Campus ID:</label>
          <input type="text" name="campus_id" id="campus_id">
          <input type="submit" value="Submit">
        </form>

        <?php
          if(isset($_POST['course_id'])){
              $course_id = $_POST['course_id'];

              // Query the course sections given course_id
              $query = "SELECT Section.id, Section.classroom, Section.meeting_days, Section.start_time, Section.end_time, COUNT(Enrollment.campus_id) as student_count
                        FROM Section LEFT JOIN Enrollment ON Section.id = Enrollment.section_id AND Section.course_id = Enrollment.course_id
                        WHERE Section.course_id = $course_id
                        GROUP BY Section.id";

              // Execute the query
              $result = mysqli_query($conn, $query);

              // If there is one or more records
              if(mysqli_num_rows($result) > 0){
                  // Display the results as a table
                  // Table headers
                  echo "<br>Sections for course $course_id:<br><br>";
                  echo "<table>
                          <tr>
                              <th>Section ID</th>
                              <th>Meeting Days</th>
                              <th>Start Time</th>
                              <th>End Time</th>
                              <th>Classroom</th>
                              <th>Number of Students</th>
                          </tr>";
                  // Table data
                  while($row = mysqli_fetch_assoc($result)){
                      echo "<tr>
                              <td>" . $row['id'] . "</td>
                              <td>" . $row['meeting_days'] . "</td>
                              <td>" . $row['start_time'] . "</td>
                              <td>" . $row['end_time'] . "</td>
                              <td>" . $row['classroom'] . "</td>
                              <td>" . $row['student_count'] . "</td>
                          </tr>";
                  }
                  echo "</table>";
              } else {
                  echo "This course has no sections.";
              }
          }
        ?>
        
        <?php
          if(isset($_POST['campus_id'])){
              $campus_id = $_POST['campus_id'];

              // Query the courses and grades for a given student
              $query = "SELECT Course.title, Enrollment.grade
                        FROM Enrollment INNER JOIN Course ON Enrollment.course_id = Course.id
                        WHERE Enrollment.campus_id = '$campus_id'";

              // Execute the query
              $result = mysqli_query($conn, $query);

              // If there is one or more records
              if(mysqli_num_rows($result) > 0){
                  // Display the results as a table
                  // Table headers
                  echo "<br>Courses for student $campus_id:<br><br>";
                  echo "<table>
                          <tr>
                              <th>Title</th>
                              <th>Grade</th>
                          </tr>";
                  // Table data
                  while($row = mysqli_fetch_assoc($result)){
                              echo "<tr>
                                      <td>" . $row['title'] . "</td>
                                      <td>" . $row['grade'] . "</td>
                                  </tr>";
                          }
                  echo "</table>";
              }
              else {
                  echo "No courses/sections found for this student";
              }
          }
        ?>
    </div>  
  </body>
</html>

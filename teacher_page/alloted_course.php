<?php
$sem_courses_list = get_courses($semester, $_SESSION['emp_sel_branch'], $_SESSION['emp_sel_stream']);
?>

<div class='form-container'>
    <form method='post'>
        <label for='course_code'>Select course for semester: <?php echo $semester ?></label>
        <select name="course_code" id="course_code" class="spinner">
            <?php
            foreach ($sem_courses_list as $course) {
                echo "<option value='{$course['course_code']}'>(" . ucfirst($course['course_type']) . ") {$course['course_code']} - {$course['course_name']}</option>";
            }
            ?>
        </select>
        <button type='submit' name='emp_enter_course'>Enter</button>
    </form>
</div>
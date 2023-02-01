<?php
$branch_list = get_branches($_SESSION['emp_sel_stream']);
?>

<div class='form-container'>
    <form method='post'>
        <label for='course_branch'>Select branch for stream: <?php echo $_SESSION['emp_sel_stream'] ?></label>
        <select name="course_branch" id="course_branch" class="spinner">
            <?php
            foreach ($branch_list as $branch) {
                echo "<option value='{$branch['branch']}'>{$branch['branch']}</option>";
            }
            ?>
        </select>
        <button type='submit' name='emp_enter_br'>Enter</button>
    </form>
</div>
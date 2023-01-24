<?php
$dist = $_SESSION['marks_dist'];
$end_sem = $dist['end_semester_exam'];
$ta_sem = $dist['teacher_assessment'];

$student = $_SESSION['student'][0];
?>

<h2><?php echo $student['registration_number'] . " - " . $student['first_name'] . " " . $student['last_name'] ?></h2>
<h4>Branch : <?php echo $student['branch'] ?></h4>
<div class='form-container'>
    <form method='post'>
        <label for='pr_end_sem_en'>End Semester &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $end_sem ?> )</label>
        <input type='number' name='pr_end_sem_en' id='pr_end_sem_en' max='<?php echo $end_sem ?>' step=' 1'>
        <label for='pr_ta_sem_en'>Teacher's Assessment &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $ta_sem ?> )</label>
        <input type='number' name='pr_ta_sem_en' id='pr_ta_sem_en' max='<?php echo $ta_sem ?>' step='1'>
        <button type='submit' name='emp_std_cc_en'>Enter</button>
    </form>
</div>
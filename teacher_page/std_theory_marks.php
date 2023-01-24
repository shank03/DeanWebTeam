<?php
$dist = $_SESSION['marks_dist'];
$mid_sem = $dist['mid_semester_exam'];
$end_sem = $dist['end_semester_exam'];
$ta_sem = $dist['teacher_assessment'];

$student = $_SESSION['student'][0];
?>

<h4><?php echo $student['registration_number'] . " - " . $student['first_name'] . " " . $student['last_name'] ?></h4>
<h4>Branch : <?php echo $student['branch'] ?></h4>
<div class='form-container'>
    <form method='post'>
        <label for='mid_sem_en'>Mid Semester &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $mid_sem ?> )</label>
        <input type='number' name='mid_sem_en' id='mid_sem_en' max='<?php echo $mid_sem ?>' value="0" step='1'>
        <label for='end_sem_en'>End Semester &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $end_sem ?> )</label>
        <input type='number' name='end_sem_en' id='end_sem_en' max='<?php echo $end_sem ?>' value="0" step='1'>
        <label for='ta_sem_en'>Teacher's Assessment &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $ta_sem ?> )</label>
        <input type='number' name='ta_sem_en' id='ta_sem_en' max='<?php echo $ta_sem ?>' value="0" step='1'>
        <button type='submit' name='emp_std_cc_en'>Enter</button>
    </form>
</div>
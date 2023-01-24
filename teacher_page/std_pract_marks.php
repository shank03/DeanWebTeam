<?php
$dist = $_SESSION['marks_dist'];
$pract = $dist['practical'];
$viva = $dist['viva'];
$lab_file = $dist['lab_file'];
$ta_sem = $dist['teacher_assessment'];

$student = $_SESSION['student'][0];
?>

<h2><?php echo $student['registration_number'] . " - " . $student['first_name'] . " " . $student['last_name'] ?></h2>
<h4>Branch : <?php echo $student['branch'] ?></h4>
<div class='form-container'>
    <form method='post'>
        <label for='pract_en'>Practical &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $pract ?> )</label>
        <input type='number' name='pract_en' id='pract_en' max='<?php echo $pract ?>' step=' 1'>
        <label for='viva_en'>Viva &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $viva ?> )</label>
        <input type='number' name='viva_en' id='viva_en' max='<?php echo $viva ?>' step='1'>
        <label for='lab_file_en'>Lab File &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $lab_file ?> )</label>
        <input type='number' name='lab_file_en' id='lab_file_en' max='<?php echo $lab_file ?>' step='1'>
        <label for='pr_ta_sem_en'>Teacher's Assessment &nbsp;&nbsp;&nbsp;&nbsp; (Out of <?php echo $ta_sem ?> )</label>
        <input type='number' name='pr_ta_sem_en' id='pr_ta_sem_en' max='<?php echo $ta_sem ?>' step='1'>
        <button type='submit' name='emp_std_cc_en'>Enter</button>
    </form>
</div>
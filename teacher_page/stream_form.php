<?php
$stream_list = get_streams();
?>

<div class='form-container'>
    <form method='post'>
        <label for='course_stream'>Select stream</label>
        <select name="course_stream" id="course_stream" class="spinner">
            <?php
            foreach ($stream_list as $stream) {
                echo "<option value='{$stream['stream']}'>{$stream['stream']}</option>";
            }
            ?>
        </select>
        <button type='submit' name='emp_enter_str'>Enter</button>
    </form>
</div>
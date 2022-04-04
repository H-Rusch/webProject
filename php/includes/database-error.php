<?php
    if (isset($databaseError)) {
?>
    <div class="flex-container-vertical">
        <h2 class="error-text"> <?php echo $databaseError ?> </h2>
    </div>
<?php
    }
?>

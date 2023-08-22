<?php
if(isset($_GET['file']) && !empty($_GET['file'])) {
    $file = $_GET['file'];
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=" . basename($file));
    header("Content-Length: " . filesize($file));
    readfile($file);
} else {
    echo '<div class="not-found-message">File not found.<br><a href="javascript:history.go(-1);" class="go-back-button">Go Back</a></div>';
}
?>



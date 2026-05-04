<?php
require_once __DIR__ . '/../includes/db.php';

if ($conn) {
    echo 'DB Connected';
} else {
    echo 'Failed';
}
?>


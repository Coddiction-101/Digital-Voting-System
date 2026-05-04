<?php
$page_title = $page_title ?? 'Digital Voting System';
$asset_base = $asset_base ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo h($page_title); ?></title>
    <link rel="stylesheet" href="<?php echo h($asset_base); ?>css/dashboard.css" />
    <?php if (!empty($include_admin_css)): ?>
        <link rel="stylesheet" href="<?php echo h($asset_base); ?>css/admin.css" />
    <?php endif; ?>
</head>
<body class="<?php echo h($body_class ?? ''); ?>">


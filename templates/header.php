<?php
/**
 * Header Template
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo get_page_title(false); ?></title>

    <meta http-equiv="refresh" content="<?php echo get_refresh_interval(false, true); ?>">

    <link type="text/css" href="<?php echo URL_PATH; ?>styles/font-awesome.min.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo URL_PATH; ?>styles/base-styles.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo URL_PATH; ?>styles/stylesheet.css" rel="stylesheet" />
    <link type="text/css" href="<?php echo URL_PATH; ?>styles/modules.css" rel="stylesheet" />

    <?php if(DARK_THEME_ENABLED){
        echo '<link type="text/css" href="' . URL_PATH . 'styles/dark-theme.css" rel="stylesheet" />';
    } ?>

    <script type="text/javascript" src="<?php echo URL_PATH; ?>js/lib/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?php echo URL_PATH; ?>js/lib/underscore-min.js"></script>
    <script type="text/javascript" src="<?php echo URL_PATH; ?>js/lib/d3.min.js"></script>

</head>
<body>


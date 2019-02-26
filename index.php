<?php
/**
 * Created by PhpStorm.
 * User: Allison
 * Date: 6/11/2018
 * Time: 9:16 AM
 */

require("config.php");
require("lib/api_access.php");
require("includes/functions.php");
require("includes/process-data.php");

include('templates/header.php');

?>

    <header id="main-header" class="dashboard-header">
        <div class="header-logo"></div>
        <div class="header-title"><h3><?php echo get_page_title(false); ?></h3></div>
    </header>

    <div id="main">
        <div id="outer-container">
            <div class="table-container grid-table-container">
                <table id="header-fixed" class="grid-table grid-view-table"></table>
                <table id="column-fixed" class="grid-table grid-view-table"></table>
            </div>
        </div>

        <?php display_legend(); ?>

    </div>


<?php include('templates/footer.php'); ?>

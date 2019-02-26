<?php
/**
 * Created by PhpStorm.
 * User: Allison
 * Date: 6/19/2018
 * Time: 3:31 PM
 */

/**
 * @param $is_settings_page
 * @return string
 */
function get_page_title($is_settings_page){
    $title = DASHBOARD_LOCATION_NAME;
    if($is_settings_page){
        $title = $title . " Settings";
    }

    return $title;
}

function footer_scripts(){

    $grid_data = new Process_Grid_Data();
    $grid_data_obj = $grid_data->build_grid_data();
?>
    <script type="text/javascript" src="js/grid.js"></script>
    <script type="text/javascript">
        $(function() {

            var realData = <?php echo $grid_data_obj; ?>;

            var grid = new Grid(realData, $(".grid-table-container"));

        });

    </script>

<?php
}

function display_admin_footer_scripts(){
?>
    <script type="text/javascript" src="js/settings-form-handler.js"></script>
<?php
}

function get_refresh_interval($is_admin_page, $is_in_seconds){

    $directory = '';
    if(!$is_admin_page){
        $directory = 'admin/';
    }

    $settings_data = file_get_contents($directory . 'settings.json');
    $refresh_interval_in_minutes = json_decode($settings_data)->{'refresh_interval'};

    if($is_in_seconds){
        return $refresh_interval_in_minutes * 60;
    } else {
        return $refresh_interval_in_minutes;
    }
}

function display_legend(){

    $success = '#2FB52C';
    $fail = '#EB2D08';
    $unknown = '#08C';
    $maintenance = '#AAAAAA';

?>
    <div id="grid-legend">
        <div class="legend-key">
            <i class="fa fa-square success" aria-hidden="true" style="color:<?php echo $success; ?>"></i> <span class="legend-key-label">Success</span>
        </div>
        <div class="legend-key">
            <i class="fa fa-square fail" aria-hidden="true" style="color:<?php echo $fail; ?>"></i> <span class="legend-key-label">Fail</span>
        </div>
        <div class="legend-key">
            <i class="fa fa-square unknown" aria-hidden="true" style="color:<?php echo $unknown; ?>"></i> <span class="legend-key-label">Unknown</span>
        </div>
        <div class="legend-key">
            <i class="fa fa-square maintenance" aria-hidden="true" style="color:<?php echo $maintenance; ?>"></i> <span class="legend-key-label">Under Maintenance</span>
        </div>
    </div>

<?php

}
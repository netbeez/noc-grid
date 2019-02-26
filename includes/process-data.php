<?php
/**
 * Created by PhpStorm.
 * User: Allison
 * Date: 6/22/2018
 * Time: 10:19 AM
 */

class Process_Grid_Data {
    function __construct() {
        $this->settings_data = file_get_contents('admin/settings.json');
        $this->settings_data_decoded = json_decode($this->settings_data);

        $this->selected_agents = $this->settings_data_decoded->{'selected_agents'};
        $this->agents_under_maintenance = $this->settings_data_decoded->{'agents_under_maintenance'};

        $this->selected_targets = $this->settings_data_decoded->{'selected_targets'};
        $this->targets_under_maintenance = $this->settings_data_decoded->{'targets_under_maintenance'};
    }

    function build_grid_data(){

        $test_data = json_decode(Nb_Tests::statuses($this->selected_targets, $this->selected_agents));

        $agent_names_obj = $this->get_agent_names_from_data($test_data);

        $test_data_targets = $test_data->{'nb_targets'};

        $formatted_grid_data = array();

        foreach($test_data_targets as $target_row){

            $formatted_row = array();

            $target_id = $target_row->{'id'};
            $agents = $target_row->{'agents'};
            $agent_ids = array_column($agents, 'id');

            foreach($this->selected_agents as $agent_id){

                if($this->is_under_maintenance($agent_id, $target_id)){
                    $status = "maintenance";
                } else {
                    $key = array_search($agent_id, $agent_ids);
                    if ($key >= 0 && $key !== false) {
                            $is_failing = false;
                        $unknown_count = 0;
                        foreach ($agents[$key]->{'nb_tests'} as $test) {
                            
                            if ($test->{'current_alert_mode'} == "fail") {
                                $is_failing = true;
                            }
                            if ($test->{'current_alert_mode'} == "unknown") {
                                $unknown_count++;
                            }
                        }

                        if ($is_failing) {
                            $status = "fail";
                        } else if ($unknown_count == count($agents[$key]->{'nb_tests'})) {
                            $status = "unknown";
                        } else {
                            $status = "success";
                        }
                    } else {
                        $status = "null";
                    }
                }

                $cell = array(
                    "agent_id" => $agent_id,
                    "agent_name" => $agent_names_obj[$agent_id],
                    "target_id" => $target_id,
                    "target_name" => $target_row->{'name'},
                    "status" => $status
                );

                array_push($formatted_row, $cell);
            }

            array_push($formatted_grid_data, $formatted_row);
        }

        return json_encode($formatted_grid_data);
    }

    private function get_agent_names_from_data($data){

        $target_rows = $data->{'nb_targets'};
        $agent_array = array();
        $agent_names_obj = array();

        foreach($target_rows as $target_row){
            $agent_array = array_merge($agent_array, $target_row->{'agents'});
        }

        if($data->{'unassigned_agents'}){
            $agent_array = array_merge($agent_array, $data->{'unassigned_agents'});
        }

        foreach($this->selected_agents as $agent_id){
            $key = array_search($agent_id, array_column($agent_array, 'id'));
            $agent_names_obj[$agent_id] = $agent_array[$key]->{'name'};
        }

        return $agent_names_obj;
    }

    private function is_under_maintenance($agent_id, $target_id){
        if(in_array($agent_id, $this->agents_under_maintenance) || in_array($target_id, $this->targets_under_maintenance)){
            return true;
        } else {
            return false;
        }
    }
}
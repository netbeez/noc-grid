/**
 * Created by Allison on 6/25/2018.
 */

//import '/lib/d3.min.js';

class Grid {
    constructor(data, container){

        this.data = data;
        this.agentKeys = this.getAgentKeys(this.data);
        this.agentIds = this.getAgentIds(this.data);

        this.grid = d3.select(container[0]).append("table")
            .attr("id", "grid-table")
            .attr("class", "grid-table grid-view-table");

        this.gridHeader = this.grid.append("thead");
        this.gridHeader.append("th");

        this.gridBody = this.grid.append("tbody");

        this.sort(this.data);

        this.draw(this.data);
    }

    draw(data){

        this.data = data;

        this.agentKeys = this.getAgentKeys(this.data);
        console.log(this.agentKeys);

        const headerLabels = this.gridHeader.selectAll(".grid-label")
            .data(this.agentKeys).enter()
            .append("th")
            .append("div")
            .attr("class", "grid-label grid-label-45")
            .text((d) => {
                console.log(d);
                return d;
            });

        const rows = this.gridBody.selectAll(".grid-row")
            .data(this.data, (d) => {
                return d;
            }).enter()
            .append("tr")
                .attr("class", "grid-row");

        const rowLabels = rows.append("th")
            .append("div")
            .attr("class", "grid-label")
            .text((d) => {
                return d[0].target_name;
            });

        const cells = rows.selectAll(".cell")
            .data((d) => {
                return d;
            }).enter()
            .append("td")
                .attr("class", "cell")
                .append("div")
                    .attr("class", (d) => {
                        return "grid-cell " + d.status;
                    });
    }

    sort(data){

        var agentFailCounts = getAgentFailCounts(this.agentIds);

        function agentFailStatusCountById(agent_id){
            var failCount = 0;
            var maintenanceCount = 0;
            var unknownCount = 0;
            var cellCount = 0;
            //console.log(data.length);
            _.each(data, (row) => {
                var cell = _.find(row, (cell) => {
                    return cell.agent_id === agent_id;
                });

                if(cell.status != "null"){
                    //console.log(cell);
                    //console.log(cell.status);
                    cellCount++;
                }

                if(cell && cell.status == "fail"){
                    failCount++;
                } else if (cell && cell.status == "maintenance"){
                    maintenanceCount++;
                } else if (cell && cell.status == "unknown"){
                    unknownCount++;
                }
            });

            //console.log(cellCount, maintenanceCount, unknownCount);

            if(failCount === 0){
                if(maintenanceCount == cellCount){
                    failCount = -3;
                } else if(unknownCount == cellCount || unknownCount == cellCount - maintenanceCount){
                    failCount = -2;
                }
            }

            //console.log(failCount);
            return failCount;
        }

        function getAgentFailCounts(keys){
            var failCountObj = {};
            _.each(keys, (key) => {
                failCountObj[key] = agentFailStatusCountById(key);
            });
            console.log(failCountObj);
            return failCountObj;
        }

        function failStatusTargetCount(row){
            var failCount = 0;
            var maintenanceCount = 0;
            var cellCount = 0;
            _.each(row, (d) => {
                //console.log(d);
                if(d.status != "null"){
                    cellCount++;
                }

                if (d.status == "fail"){
                    failCount++;
                }

                if (d.status == "maintenance"){
                    maintenanceCount++;
                }
            });

            console.log(maintenanceCount);

            /*if(failCount === 0 && maintenanceCount > 0){
                failCount = -1;
            }*/

            if (maintenanceCount === cellCount){
                failCount = -1;
            }

            return failCount;
        }


        _.each(data, (d) => {
            d.sort((a, b) => {
                return d3.descending(agentFailCounts[a.agent_id], agentFailCounts[b.agent_id]);
            });
        });

        return data.sort((a, b) => {
            return d3.descending(failStatusTargetCount(a), failStatusTargetCount(b));
        });
    }

    getAgentKeys(data){
        console.log(data);
        return d3.map(data[0], (d) => {
            /*console.log(d.agent_name);
            if(d.agent_name){
                return d.agent_name;
            } else {
                return d.agent_id;
            }*/
            return d.agent_name + " " + d.agent_id;
            //return d.agent_name;
        }).keys();
    }

     getAgentIds(data){
        return d3.map(data[0], (d) => {
            return d.agent_id;
        }).keys().map(Number);
    }

    destroy(){
        this.grid.remove();
    }
}

/**
 * The Grid
 */

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

        let agentFailCounts = getAgentFailCounts(this.agentIds);

        function agentFailStatusCountById(agent_id){
            let failCount = 0;
            let maintenanceCount = 0;
            let unknownCount = 0;
            let cellCount = 0;

            _.each(data, (row) => {
                let cell = _.find(row, (cell) => {
                    return cell.agent_id === agent_id;
                });

                if(cell.status != "null"){
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

            if(failCount === 0){
                if(maintenanceCount === cellCount){
                    failCount = -3;
                } else if(unknownCount === cellCount || unknownCount === cellCount - maintenanceCount){
                    failCount = -2;
                }
            }

            return failCount;
        }

        function getAgentFailCounts(keys){
            let failCountObj = {};
            _.each(keys, (key) => {
                failCountObj[key] = agentFailStatusCountById(key);
            });
            return failCountObj;
        }

        function failStatusTargetCount(row){
            let failCount = 0;
            let maintenanceCount = 0;
            let cellCount = 0;
            _.each(row, (d) => {
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
        return d3.map(data[0], (d) => {
            if(d.agent_name){
                return d.agent_name;
            } else {
                return d.agent_id;
            }
            //return d.agent_name + " " + d.agent_id; //Use instead if there are agents with missing or duplicate names
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

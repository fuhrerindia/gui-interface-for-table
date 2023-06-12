<?php
include('./modules/frontend.php');
// HOME PAGE IS BUILT IN helloworld.php in ./src DIRECTORY and then included here.
// include_once('./src/helloworld.php');
script(<<<JS
const { $ } = yugal;
JS);
def_page([
    'render' => <<<HTML
    <form id="form" onsubmit="page.onSubmit(event)">
        <label>Number of Rows</label>
        <input type="number" min="1" id="rows" required>
        <br>
        <label>Number of Columns</label>
        <input type="number" min="1" id="cols" required>
        <br>
        <p>NOTE: TABLE WILL INCLUDE ADDITIONAL <xmp><thead></xmp> ROW.</p>
        <input type="submit" value="Ok" />
        <br>
    </form>
    <div id="table"></div>
    <button onclick="page.generateCode()">GET HTML CODE</button>
    <textarea id="table-result"></textarea>
HTML,
    "didMount" => <<<JS
        ()=>{
        page.generateCode = () =>{
            const table = $("#table");
            const ntbl = document.createElement("table");
            const thead = table.querySelector("thead");
            const thtds = thead.querySelectorAll("td");
            const newThead = document.createElement("thead");
            thtds.forEach(td=>{
                const ntd = document.createElement("td");
                const value = td.querySelector("input").value;
                ntd.innerHTML = value;
                newThead.appendChild(ntd);
            });
            const tbody = document.querySelector("tbody");
            const ntbd = document.createElement("tbody");
            const trs = tbody.querySelectorAll("tr");
            trs.forEach(tr => {
                const ntr = document.createElement("tr");
                const tds = tr.querySelectorAll("td");
                tds.forEach(td => {
                    const ntd = document.createElement("td");
                    const value = td.querySelector("input").value;
                    ntd.innerHTML = value;
                    ntr.appendChild(ntd);
                });
                ntbd.appendChild(ntr);
            });
            ntbl.appendChild(newThead);
            ntbl.appendChild(ntbd);
            const div = document.createElement("div");
            div.appendChild(ntbl);
            const final_color = page.color !== undefined ? page.color : "#ededed";
            const final_html = div.innerHTML + '<style>table thead td{font-weight:bold}table td{width:177px;border:1px solid #000;}table thead{background:'+final_color+';}table{border-collapse:collapse;font-family:sans-serif;}</style>';
            $("#table-result").value = final_html;
            $("#table").innerHTML = "";
        } 
        page.onSubmit = (e) => {
            e.preventDefault();
            if ($("#form").checkValidity() === true){
                const table = $("#table");
                const rows = parseInt($("#rows").value);
                const cols = parseInt($("#cols").value);

                const tbl = document.createElement('table');
                const thead = document.createElement('thead');
                thead.addEventListener("click", ()=>{
                    const colour = prompt("Enter HEX colour code for <thead>: ");
                    page.color = colour;
                    document.querySelector("thead").style.background = page.color;
                })
                for (let index = 0; index < cols; index++) {
                    const col = document.createElement('td');
                    const input = document.createElement('input');
                    input.setAttribute("type", "text");
                    col.appendChild(input);
                    thead.appendChild(col);
                }
                tbl.appendChild(thead);
                const tbody = document.createElement('tbody');
                for (i = 0; i < rows; i++){
                    tr = document.createElement('tr');
                    for (j = 0; j<cols; j++){
                        const td = document.createElement('td');
                        const inpt = document.createElement('input');
                        inpt.setAttribute("type", "text");
                        td.appendChild(inpt);
                        tr.appendChild(td);
                    }
                    tbody.appendChild(tr);
                }
                tbl.appendChild(tbody);
                table.appendChild(tbl);
            }
        };
    }
    JS,
    "uri" => "/",
    "header" => <<<HTML
        <title>
            Dynamic Table
        </title>
HTML,
"style"=><<<CSS
    *{
        outline:0;
    }
    thead {
        padding:10px;
        background:#ededed;
    }
    table input{
        background: transparent;
        outline:0;
        border:0;
    }
    table{
        border-collapse: collapse;
    }
    td{
        border:1px solid #404040;
    }
    thead input{
        font-weight:bold;
    }
CSS
]);
end_doc();
?>
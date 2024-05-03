<html>

<head>
    <title>My Ticket Count Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = [
                ['Date Logged', 'Ticket Count'],
                <?php
                $sql = "SELECT date_logged, COUNT(*) AS ticket_count FROM tickets GROUP BY date_logged;";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $ticket_count = intval($row['ticket_count']);
                        $date_logged = date("d-m-Y", strtotime($row["date_logged"]));
                        echo "['$date_logged', $ticket_count],";
                    }
                }
                ?>
            ];

            var chartData = google.visualization.arrayToDataTable(data);

            var options = {
                // title: 'Ticket Count by Date',
                pieHole: 0.4,
                backgroundColor: { fill: 'transparent' },
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(chartData, options);
        }
    </script>
</head>

<body>

    <script>
    function allowDrop(ev) {
    ev.preventDefault();
    }

    function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
    }
    </script>

    <div class="w-100 h-100" style="cursor:grab;" draggable="true" ondragstart="drag(event)" id="drag1">
        <div class="position-absolute mt-2 ms-2 z-1 d-flex flex-row align-items-center">
            <i class="bi bi-grip-vertical"></i>
            <h5 class="m-0 ms-1 fw-semibold">All tickets</h5>
        </div>
        <div id="donutchart" class="w-100 h-100" style="cursor:default;"></div>
    </div>
</body>

</html>
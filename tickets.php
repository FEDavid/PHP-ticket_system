<?php
include 'config/config.php';

session_start();

list($user_id, $username, $access_level) = get_session_data();

if (!$user_id) {
    header('location:login.php');
    exit;
}

function ticket_data($conn)
{

    echo "<table id='ticket_tbl' class='table table-striped table-hover text lh-1' style='font-size: 0.9rem'>";
    echo "<thead><tr class='text-center'><th class='border-end bg-primary text-white'><button id='tkt_num_head' class='transparent_button text-white' onclick='sort_table_column(0, this.id)'>Ticket number<i class='bi bi-sort-down ms-1'></i></button></th><th class='border-end bg-primary text-white'><button id='tkt_date_head' class='transparent_button text-white' onclick='sort_table_column(1, this.id)'>Date Logged<i class='bi bi-sort-down ms-1'></i></button></th><th class='bg-primary text-white'><button id='tkt_log_head' class='transparent_button text-white' onclick='sort_table_column(2, this.id)'>Logged by<i class='bi bi-sort-down ms-1'></i></button></th></tr></thead>";

    $sql = "SELECT * FROM tickets";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ticket_id = '<form action="view_ticket.php?id=' . $row["id"] . '" method="post"><input type="hidden" name="id" value="' . $row["id"] . '"><input class="w-100 border-0 py-1 bg-transparent" type="submit" value=' . $row["id"] . '></form>';
            $date_logged = date("d/m/Y", strtotime($row["date_logged"]));
            $logged_by = $row['logged_by'];

            echo "<tr class='text-center'><td class='border-end p-0 align-middle'>$ticket_id</td><td class='border-end p-0 align-middle'>$date_logged</td><td class='p-0 align-middle'>$logged_by</td></tr>";
        }
    }

    echo "</table>";

}
?>

<?php
include 'page_sections/head.php';
?>

<script>
    function amend_class(headerId) {
        var element = document.getElementById(headerId);
        var iElement = element.querySelector('i');

        if (iElement.classList.contains('bi-sort-down')) {
            iElement.classList.remove('bi-sort-down');
            iElement.classList.add('bi-sort-up');
        } else {
            iElement.classList.remove('bi-sort-up');
            iElement.classList.add('bi-sort-down');
        }
    }

    function sort_table_column(columnIndex, headerId) {
        amend_class(headerId);

        var table = document.getElementById('ticket_tbl');
        var tbody = table.getElementsByTagName('tbody')[0];
        var rows = Array.from(tbody.getElementsByTagName('tr'));
        var data = [];
        var dir = (tbody.dataset.sortDirection === "asc") ? "desc" : "asc";

        // Create an array of objects, each object contains a row element and its value
        for (var i = 0; i < rows.length; i++) {
            var cell = rows[i].getElementsByTagName('td')[columnIndex];
            var value;
            switch (columnIndex) {
                case 0:
                    // First column - numeric 
                    value = Number(cell.getElementsByTagName('input')[0].value);
                    break;
                case 1:
                    // Second column - date
                    value = parseDate(cell.innerText);
                    break;
                case 2:
                    // Third column - text
                    value = cell.innerText;
                    break;
            }
            data.push({ row: rows[i], value: value });
        }

        // Sort the data array
        data.sort(function (a, b) {
            if (typeof a.value === 'number' || a.value instanceof Date) {
                return (dir === "asc") ? a.value - b.value : b.value - a.value;
            } else {
                return (dir === "asc") ? a.value.localeCompare(b.value) : b.value.localeCompare(a.value);
            }
        });

        // Create a new tbody and append sorted rows to it
        var newTbody = document.createElement('tbody');
        for (var i = 0; i < data.length; i++) {
            newTbody.appendChild(data[i].row);
        }

        // Replace the old tbody with the new one
        table.replaceChild(newTbody, tbody);
        newTbody.dataset.sortDirection = dir; // Store the current sort direction
    }

    function parseDate(dateString) {
        var parts = dateString.split('/');
        // new Date(year, monthIndex [, day [, hours [, minutes [, seconds [, milliseconds]]]]])
        return new Date(parts[2], parts[1] - 1, parts[0]); // Month is 0-based
    }
</script>

<body>
    <?php
    include 'page_sections/navbar.php';
    ?>
    <div class="container-sm p-0 w-75 mb-3" style="min-width: 800px;">
        <div><?php ticket_data($conn) ?></div>
    </div>
    <?php
    include 'page_sections/footer.php';
    ?>
</body>
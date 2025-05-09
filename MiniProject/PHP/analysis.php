<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
}
include('connection.php');
$Smonth=$_SESSION['monthNo'];
$select = "SELECT SUM(e.expense) AS totalEx, c.category FROM expense e INNER JOIN category c  WHERE e.category_id = c.category_id and e.user_id = $_SESSION[user_id] and date_format(date, '%Y-%m') = '$Smonth'  GROUP BY e.category_id";
$result = mysqli_query($connect, $select);

$selecti = "select sum(i.income) as totalIn, c.category from income i inner join category c  where i.category_id = c.category_id and i.user_id = $_SESSION[user_id] and date_format(date, '%Y-%m') = '$Smonth' GROUP BY i.category_id";
$resulti = mysqli_query($connect, $selecti);

$totalExArray = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $totalExArray[] = [$row['category'], (float) $row['totalEx']];
    }
} else {
    echo 'Error: ' . mysqli_error($connect);
}

$totalExArray1 = [];
if ($resulti) {
    while ($rowi = mysqli_fetch_assoc($resulti)) {
        $totalExArray1[] = [$rowi['category'], (float) $rowi['totalIn']];
    }
} else {
    echo 'Error: ' . mysqli_error($connect);
}


$totalExJson = json_encode($totalExArray);
$totalExJson1 = json_encode($totalExArray1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analysis - Expense Tracker</title>
    <link rel="stylesheet" href="../CSS/Expense.css">
    <link rel="stylesheet" href="../CSS/UTILITY.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load("current", { packages: ["corechart"] });
        google.charts.setOnLoadCallback(drawExpenseChart);
        google.charts.setOnLoadCallback(drawIncomeChart);

        function drawExpenseChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Total Expense'],
                <?php
                echo implode(",\n", array_map(function ($row) {
                    return "['" . addslashes($row[0]) . "', " . $row[1] . "]";
                }, json_decode($totalExJson, true)));
                ?>
            ]);

            var options = {
                title: 'Total Expense by Category',
                pieHole: 0.4,
                backgroundColor: 'transparent'
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
            chart.draw(data, options);
        }

        function drawIncomeChart() {
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Total Income'],
                <?php
                echo implode(",\n", array_map(function ($rowi) {
                    return "['" . addslashes($rowi[0]) . "', " . $rowi[1] . "]";
                }, json_decode($totalExJson1, true)));
                ?>
            ]);

            var options = {
                title: 'Total Income by Category',
                pieHole: 0.4,
                backgroundColor: 'transparent'
            };

            var chart = new google.visualization.PieChart(document.getElementById('donutchart1'));
            chart.draw(data, options);
        }
    </script>

</head>
<body>
    <div class="container flex  f1">
        <header class="header">
            <nav class="navbar">
                <div class="name flex align-center justify-center">
                    Expense Tracker
                </div>
                <ul>
                    <a href="expense.php">
                        <li class="flex align-center"><span class="icon"><ion-icon
                                    name="newspaper"></ion-icon></span>Records</li>
                    </a>
                    <a href="analysis.php">
                        <li class="flex align-center"><span class="icon"><ion-icon
                                    name="pie-chart"></ion-icon></span>Analysis</li>
                    </a>
                    <a href="budgets.php">
                        <li class="flex align-center"><span class="icon"><ion-icon
                                    name="calculator"></ion-icon></span>Budgets</li>
                    </a>
                    <a href="account.php">
                        <li class="flex align-center"><span class="icon"><ion-icon
                                    name="wallet"></ion-icon></span>Account</li>
                    </a>

                    <a href="logout.php">
                        <li class="flex align-center"><span><ion-icon name="log-out"></ion-icon></span>Logout</li>
                    </a>
                </ul>
            </nav>
        </header>
        <main class="main">
            <div class="upper">
                <div class="name">Expense Tracker</div>
                <div class="iet flex align-center">
                    <div class="expense flex justify-center align-center ietc">
                        <div class="eup">Expense</div>
                        <div class="edown"><?php 
                        $Smonth=$_SESSION['monthNo'];
                        $selt = "select sum(expense) as totalEx from expense where user_id=$_SESSION[user_id] and date_format(date, '%Y-%m') = '$Smonth'";
                        $reselt = mysqli_query($connect, $selt);
                        $seltData = mysqli_fetch_assoc($reselt);
                        if (isset($seltData['totalEx'])) {
                            echo "-" . $seltData['totalEx'];
                        } else {
                            echo 0;
                        } ?></div>
                    </div>
                    <div class="income ietc flex justify-center align-center">
                        <div class="iup">Income</div>
                        <div class="idown"><?php
                        if (isset($_POST['btnmonth'])) {
                            $monthN = $_POST['txtmonth'];
                            if ($monthN < 10) {
                                $monthN = '0' . $monthN;
                                $monthNo = "2024-$monthN";
                            } else {
                                $monthNo = "2024-$monthN";
                            }
                        } else {
                            $monthN = date('m');
                            $monthNo = "2024-$monthN";
                        }

                        $selti = "select sum(income) as totalIn from income where user_id=$_SESSION[user_id] and date_format(date, '%Y-%m') = '$Smonth'";
                        $reselti = mysqli_query($connect, $selti);
                        $seltDatai = mysqli_fetch_assoc($reselti);
                        if (isset($seltDatai['totalIn'])) {
                            echo $seltDatai['totalIn'];
                        } else {
                            echo 0;
                        } ?></div>
                    </div>
                    <div class="total flex justify-center align-center ietc">
                        <div class="tup">Total</div>
                        <div class="tdown"></div>
                    </div>
                </div>
            </div>
            <div class="records flex align-center justify-center">
                <div id="donutchart" style="width: 900px; height: 500px;"></div>
                <div id="donutchart1" style="width: 900px; height: 500px;"></div>
            </div>

        </main>
    </div>
    <script src="../JS/expense.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location:login.php');
}
include('connection.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget - Expense Tracker</title>
    <link rel="stylesheet" href="../CSS/Expense.css">
    <link rel="stylesheet" href="../CSS/UTILITY.css">
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
            <div class="records flex align-center justify-center dircol">
                <h1>Accounts</h1>
              <?php 
                $selectea="select a.ac_id,a.ac_type, a.icon, COALESCE(exp.totalEx, 0) AS totalEx, COALESCE(inc.totalIn, 0) AS totalIn FROM account a LEFT JOIN (SELECT ac_id, SUM(expense) AS totalEx FROM expense WHERE user_id =$_SESSION[user_id] GROUP BY ac_id) exp ON exp.ac_id = a.ac_id LEFT JOIN (SELECT ac_id, SUM(income) AS totalIn FROM income GROUP BY ac_id) inc ON inc.ac_id = a.ac_id";
                $resultea=mysqli_query($connect, $selectea);
               
                while( $row=mysqli_fetch_assoc($resultea)){
                    ?>
                    <a href="displayAc.php?ac_id=<?php echo $row['ac_id']; ?>" class="w100">
                    <div class="acdetails flex align-center">
                        <div class="acdetail flex align-center">
                        <div class="Acicon"><img src="<?php echo $row['icon'] ?>" alt=""></div>
                        <div class="acname"><?php echo $row['ac_type'] ?></div>
                        </div>
                        <div class="acamount"><?php echo $row['totalIn']-$row['totalEx']; ?></div>
                    </div>
                    </a>
                <?php
                }
              
              ?>
            </div>

        </main>
    </div>
    <script src="../JS/expense.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
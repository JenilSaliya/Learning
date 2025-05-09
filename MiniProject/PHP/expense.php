<?php
session_start();
if (!isset($_SESSION["user_id"]))
    header("location:login.php");

include('connection.php');
global $connect;
$selectCat = "select * from category";
$selresultCat = mysqli_query($connect, $selectCat);

$selectAc = "select * from account";
$selresultAc = mysqli_query($connect, $selectAc);

if (isset($_POST['btnSubmit'])) {
    $type = $_POST['selectIE'];
    $ac_id = $_POST['selectAc'];
    $category_id = $_POST['selectCat'];
    $note = "";
    if (isset($_POST['txtAreaNote'])) {
        $note = $_POST['txtAreaNote'];
    }
    $expense = $_POST['txtExpense'];
    $date = $_POST['date'];
    $userId = $_SESSION["user_id"];
    if ($type == 'expense') {
        $insert = "insert into expense values ('','$expense','$category_id','$ac_id','$date','$note','$userId')";
        mysqli_query($connect, $insert);
    } else {
        $insert = "insert into income values ('','$expense','$category_id','$ac_id','$date','$note','$userId')";
        mysqli_query($connect, $insert);
    }

}


// $selectCat = "select * from category order by category_id desc";
// $selresultCat = mysqli_query($connect, $selectCat);
// $dataCat = mysqli_fetch_assoc($selresultCat);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker- Expense Home</title>
    <link rel="stylesheet" href="../CSS/Expense.css">
    <link rel="stylesheet" href="../CSS/UTILITY.css">
</head>

<body>
    <div></div>
    <div class="container flex  f1">

        <header class="header">
            <nav class="navbar">
                <div class="name flex align-center justify-center">
                    Expense Tracker
                </div>
                <ul>
                    <a href="expense.php">
                        <li class="flex align-center"><span class="icon flex align-center"><ion-icon
                                    name="newspaper"></ion-icon></span>Records</li>
                    </a>
                    <a href="analysis.php">
                        <li class="flex align-center"><span class="icon flex align-center"><ion-icon
                                    name="pie-chart"></ion-icon></span>Analysis</li>
                    </a>
                    <a href="budgets.php">
                        <li class="flex align-center"><span class="icon flex align-center"><ion-icon
                                    name="calculator"></ion-icon></span>Budgets</li>
                    </a>
                    <a href="account.php">
                        <li class="flex align-center"><span class="icon flex align-center"><ion-icon
                                    name="wallet"></ion-icon></span>Account</li>
                    </a>

                    <a href="logout.php">
                        <li class="flex align-center"><span class="flex align-center icon"><ion-icon
                                    name="log-out"></ion-icon></span>Logout</li>
                    </a>
                </ul>
            </nav>
        </header>
        <main class="main">
            <div class="upper">
                <div class="name">Expense Tracker</div>
                <div class="montn flex justify-center align-center">
                    <form method="post">
                        <input type="text" class="monthName" name="txtmonth" placeholder="Enter Month 1-12 "><button
                            type="submit" class="gbtn" name="btnmonth">Go</button>
                    </form>
                </div>
                <div class="iet flex align-center">
                    <div class="expense flex justify-center align-center ietc">
                        <div class="eup">Expense</div>
                        <div class="edown"><?php 
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
                        $selt = "select sum(expense) as totalEx from expense where user_id=$_SESSION[user_id] and date_format(date, '%Y-%m') = '$monthNo'";
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
                                $_SESSION['monthNo'] = "2024-$monthN";
                            } else {
                                $_SESSION['monthNo'] = "2024-$monthN";
                            }
                        } else {
                            $monthN = date('m');
                            $_SESSION['monthNo'] = "2024-$monthN";
                        }
                        $Smonth=$_SESSION['monthNo'];
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
            <div class="records">
                <?php
                function formatDate($dateString)
                {
                    $date = new DateTime($dateString);

                    return $date->format('M d, l');
                }
                ?>
                <?php
                global $connect;
                if (isset($_POST['btnmonth'])) {
                    $monthN = $_POST['txtmonth'];
                    if ($monthN < 10) {
                        $monthN = '0' . $monthN;
                        $_SESSION['monthNo'] = "2024-$monthN";
                    } else {
                        $_SESSION['monthNo'] = "2024-$monthN";
                        
                    }
                     $Smonth=$_SESSION['monthNo'];
                     $selectEx = "select * from expense where user_id = $_SESSION[user_id] and date_format(date, '%Y-%m') = '$Smonth' order by date desc";
                } else {
                    $monthN = date('m');
                    $_SESSION['monthNo'] = "2024-$monthN";
                    $Smonth=$_SESSION['monthNo'];
                    $selectEx = "select * from expense where user_id = $_SESSION[user_id] and date_format(date, '%Y-%m') = '$Smonth' order by date desc";
                }
                $selresultEx = mysqli_query($connect, $selectEx);
                while ($Exdata = mysqli_fetch_assoc($selresultEx)) { ?>
                    <a href="exupdate.php?expense_id=<?php echo $Exdata['expense_id'] ?>">
                        <div class="record">

                            <div class="date"><?php
                            $dateString = $Exdata['date'];
                            echo formatDate($dateString);

                            ?>
                            </div>
                            <div class="content flex">
                                <div class="lta flex justify-center align-center">
                                    <div class="categoryLogo flex align-center justify-center">
                                        <?php
                                        $selCatid = $Exdata['category_id'];
                                        $selCaticon = "select * from category where category_id=$selCatid";
                                        $selCatRe = mysqli_query($connect, $selCaticon);
                                        $catIcon = mysqli_fetch_assoc($selCatRe);
                                        ?>
                                        <img src="<?php if ($catIcon) {
                                            echo $catIcon['icons'];
                                        } else {
                                            $catIcon = '../Assets/money-bag.png';
                                        } ?>
                                    " alt="icons">
                                    </div>
                                    <div class="accate flex justify-center">
                                        <div class="title"><?php echo $catIcon['category'] ?></div>
                                        <div class="ac flex align-center">
                                            <div class="acLogo flex justify-center align-center">
                                                <?php
                                                $selAcid = $Exdata['ac_id'];
                                                $selAcIcon = "select * from account where ac_id=$selAcid";
                                                $selAcRe = mysqli_query($connect, $selAcIcon);
                                                $AcIcon = mysqli_fetch_assoc($selAcRe);
                                                ?>
                                                <img src="<?php echo $AcIcon['icon']; ?>" alt="">
                                            </div>
                                            <div class="acName"><?php echo $AcIcon['ac_type'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ieno"><?php echo '-' . $Exdata['expense']; ?></div>
                            </div>
                        </div>
                    </a>
                    <?php
                }

                ?>
                <?php
                global $connect;
                $selectIn = "select * from income where user_id=$_SESSION[user_id] and date_format(date, '%Y-%m') = '$Smonth' order by date desc";
                $selresultIn = mysqli_query($connect, $selectIn);
                while ($Indata = mysqli_fetch_array($selresultIn)) { ?>
                    <a href="exupdate.php?income_id=<?php echo $Indata['income_id'] ?>">
                        <div class="record">

                            <div class="date"><?php
                            $dateString = $Indata['date'];
                            echo formatDate($dateString);

                            ?>
                            </div>
                            <div class="content flex">
                                <div class="lta flex justify-center align-center">
                                    <div class="categoryLogo flex align-center justify-center">
                                        <?php
                                        $selCatid = $Indata['category_id'];
                                        $selCaticon = "select * from category where category_id=$selCatid";
                                        $selCatRe = mysqli_query($connect, $selCaticon);
                                        $catIcon = mysqli_fetch_assoc($selCatRe);
                                        ?>
                                        <img src="<?php if ($catIcon) {
                                            echo $catIcon['icons'];
                                        } else {
                                            $catIcon = '../Assets/money-bag.png';
                                        } ?>
                                    " alt="icons">
                                    </div>
                                    <div class="accate flex justify-center">
                                        <div class="title"><?php echo $catIcon['category'] ?></div>
                                        <div class="ac flex align-center">
                                            <div class="acLogo flex justify-center align-center">
                                                <?php
                                                $selAcid = $Indata['ac_id'];
                                                $selAcIcon = "select * from account where ac_id=$selAcid";
                                                $selAcRe = mysqli_query($connect, $selAcIcon);
                                                $AcIcon = mysqli_fetch_assoc($selAcRe);
                                                ?>
                                                <img src="<?php echo $AcIcon['icon']; ?>" alt="">
                                            </div>
                                            <div class="acName"><?php echo $AcIcon['ac_type'] ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ieno"><?php echo $Indata['income']; ?></div>
                            </div>
                        </div>
                    </a>
                    <?php
                }

                ?>
            </div>
            <div class="addicon flex justify-center align-center">
                <ion-icon name="add"></ion-icon>
            </div>
        </main>
    </div>

    <script src="../JS/expense.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
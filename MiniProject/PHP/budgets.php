<?php
session_start();
include('connection.php');
global $connect;
if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
}
include('connection.php');

$select = "select * from category where inen='expense'";
$selresultCat = mysqli_query($connect, $select);

if(isset($_POST['btnSubmit'])) {
    $budget=$_POST['txtbudget'];
    $category_id=$_POST['selectCat'];
    $user_id=$_SESSION['user_id'];
    $insert="insert into budget values ('','$budget','$category_id','$user_id') ";
    mysqli_query($connect, $insert);
}

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
            <div class="records">
                <div class="bgtdetail flex align-center">
                    <div class="bgtTitle">Budget</div>
                    <button type="button" class="btnbgt">Add Budget</button>
                </div>
                <div class="addbgt">
                    <form method="post" class="formbgt">
                        <div class="input-box">
                            <input type="text" name="txtbudget" class="allInput itxt inplace" placeholder="Budget">
                        </div>
                        <div class="input-box">
                            <select name="selectCat" class="allInput catoption" required>
                                <option value="" class="cb">Category</option>
                                <?php
                                while ($dataCat = mysqli_fetch_assoc($selresultCat)) {
                                    ?>
                                    <option value="<?php echo $dataCat['category_id'] ?>" class="cb">
                                        <?php echo $dataCat['category'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" name="btnSubmit" class="btnit">Add Budget</button>
                    </form>
                </div>
           <div class="disconbgt flex justify-center align-center">
           <?php $selbgt="select * from budget  where user_id=$_SESSION[user_id] order by budget_id desc"; $rel=mysqli_query($connect, $selbgt);
                while($fetchrel=mysqli_fetch_assoc($rel)){
                    ?>

                <a href="exupdate.php?bgt_id=<?php echo $fetchrel['budget_id'] ?>">
                <div class="disbgt">
                    <div class="conbgt">
                        <div class="category">
                            category : <?php $catID=$fetchrel['category_id']; $selcat="select * from category where category_id=$catID"; $relcat=mysqli_query($connect,$selcat); $fetchrelcat=mysqli_fetch_assoc($relcat); echo $fetchrelcat['category']?>
                        </div>
                        <div class="bgt">
                            budget : <?php echo $fetchrel['budget']; ?>
                        </div>
                        <div class="expense">
                            expense : <?php $seltex = "select sum(expense) as totalEx from expense where category_id=$catID and date_format(date, '%Y-%m') = '$Smonth'";
                        $reseltex = mysqli_query($connect, $seltex);
                        $seltDataex = mysqli_fetch_assoc($reseltex);
                        if(!$seltDataex['totalEx']){
                            echo 0;
                        }else{
                        echo $seltDataex['totalEx'];
                        }
                        ?>
                        </div>
                        <div class="remain">
                            remain : <?php echo $fetchrel['budget']-$seltDataex['totalEx']; ?>
                        </div>
                    </div>
                </div>
                </a>
                <?php
            }?>
           </div>
            </div>

        </main>
    </div>
    <script src="../JS/expense.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION["user_id"]))
    header("location:login.php");
include('connection.php');
global $connect;
$selectAc = "select * from account";
$selresultAc = mysqli_query($connect, $selectAc);
if (isset($_GET['expense_id'])) {
    $selectCat = "select * from category where inen='expense'";
    $selresultCat = mysqli_query($connect, $selectCat);
    $expense_id = $_GET['expense_id'];
    $select = "select * from expense where expense_id=$expense_id";
    $selresult = mysqli_query($connect, $select);
    $data = mysqli_fetch_assoc($selresult);
    $catId = $data['category_id'];
    $acId = $data['ac_id'];
    $selCatN = "select * from category where category_id=$catId";
    $selResult = mysqli_query($connect, $selCatN);
    $catData = mysqli_fetch_assoc($selResult);
    $selAcN = "select * from account where ac_id=$acId";
    $selAcResult = mysqli_query($connect, $selAcN);
    $acData = mysqli_fetch_assoc($selAcResult);

}else{
    echo mysqli_error($connect);
}
if (isset($_GET['income_id'])) {
    $selectCat = "select * from category where inen='income'";
    $selresultCat = mysqli_query($connect, $selectCat);
    $income_id = $_GET['income_id'];
    $select = "select * from income where income_id=$income_id";
    $selresult = mysqli_query($connect, $select);
    $data = mysqli_fetch_assoc($selresult);
    $catId = $data['category_id'];
    $acId = $data['ac_id'];
    $selCatN = "select * from category where category_id=$catId";
    $selResult = mysqli_query($connect, $selCatN);
    $catData = mysqli_fetch_assoc($selResult);
    $selAcN = "select * from account where ac_id=$acId";
    $selAcResult = mysqli_query($connect, $selAcN);
    $acData = mysqli_fetch_assoc($selAcResult);

}
$selcat = "select * from category where inen='expense'";
$relcat = mysqli_query($connect, $selcat);
if (isset($_GET['bgt_id'])) {
    $selbgt = "select * from budget where budget_id=$_GET[bgt_id]";
    $rel = mysqli_query($connect, $selbgt);
    $fetchrel = mysqli_fetch_assoc($rel);
    $catID = $fetchrel['category_id'];
    $selbgtcat = "select * from category where category_id=$catID";
    $relbgtcat = mysqli_query($connect, $selbgtcat);
    $fetchrelbgtcat = mysqli_fetch_assoc($relbgtcat);
}

if (isset($_POST['btndelete'])) {
    if (isset($_GET['expense_id'])) {
        $expense_id = $_GET['expense_id'];
        $delete = "delete from expense where expense_id=$expense_id";
        mysqli_query($connect, $delete);
        header('location:expense.php');
    } elseif (isset($_GET['income_id'])) {
        $income_id = $_GET['income_id'];
        $delete = "delete from income where income_id=$income_id";
        mysqli_query($connect, $delete);
        header('location:expense.php');
    }elseif(isset($_GET['bgt_id'])){
        $bgt_id=$_GET['bgt_id'];
        $delete="delete from budget where budget_id=$bgt_id";
        mysqli_query($connect,$delete);
        header("location:budgets.php");
    }
}

if (isset($_POST['btnupdate'])) {
   if(isset($_GET['bgt_id'])){
    $bgt_id=$_GET['bgt_id'];
    $budget=$_POST['txtbudget'];
    $category_id=$_POST['selectCat1'];
    echo $category_id;
    $update="update budget set budget='$budget',category_id=$category_id where budget_id=$bgt_id";
    mysqli_query($connect,$update);
    header('location:budgets.php');
   }else{
    $type = $_POST['selectIE'];
    $ac_id = $_POST['selectAc'];
    $category_id = $_POST['selectCat'];
    $note = "";
    if (isset($_POST['txtAreaNote'])) {
        $note = $_POST['txtAreaNote'];
    }
    $expense = $_POST['txtExpense'];
    $date = $_POST['date'];
    $userId = 1;
    if ($type == 'expense') {
        $update = "update expense 
            set expense='$expense',category_id='$category_id',
            ac_id='$ac_id',
            date='$date',
            note='$note'
            where expense_id=$_GET[expense_id]";
        mysqli_query($connect, $update);
        header('location:expense.php');
    } elseif ($type == 'income') {
        $update = "update income
            set income='$expense',category_id='$category_id',
            ac_id='$ac_id',
            date='$date',
            note='$note'
            where income_id=$_GET[income_id]";
        mysqli_query($connect, $update);
        header('location:expense.php');
    }
   }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update -Expense Tracker</title>
    <link rel="stylesheet" href="../CSS/Expense.css">
    <link rel="stylesheet" href="../CSS/UTILITY.css">
</head>

<body class="flex justify-center align-center hwfull">
    <div class="incon">
        <form method="post">
            <?php if (isset($_GET['bgt_id'])) { ?>

                <div class="input-box">
                    <input type="text" name="txtbudget" class="allInput itxt inplace" placeholder="Budget" value="<?php echo $fetchrel['budget'] ?>">
                </div>
                <div class="input-box">
                    <select name="selectCat1" id="<?php echo $fetchrelbgtcat['category_id']; ?>"class="allInput catoption sfc" required >
                        <option value="Category" class="cb">Category</option>
                        <?php
                        while ( $fetchrelcat1 = mysqli_fetch_assoc($relcat)) {
                            ?>
                            <option value="<?php echo $fetchrelcat1['category_id'] ?>" class="cb">
                                <?php echo $fetchrelcat1['category'] ?>
                            </option>
                            
                            <?php
                        }
                        ?>
                    </select>
                    
                </div>
                <button type="submit" name="btnupdate" class="btnithalf">Update</button>
            <button type="submit" name="btndelete" class="btnithalf"
                onclick="return confirm('Are you sure to delete?');">Delete</button>
            <a href="budgets.php"><button type="button" name="btnclose" class="btnit">Back</button></a>
            <?php } else{?>
            <div class="input-box"><select name="selectIE" class="<?php
            if (isset($_GET['expense_id'])) {
                echo "expense";
            } elseif (isset($_GET['income_id'])) {
                echo "income";
            }
            ?> allInput sie">
                    <option value="expense" selected>Expense</option>
                    <option value="income">Income</option>
                </select>
            </div>
            <div class="input-box">
                <select name="selectAc" class="allInput soption" id="<?php echo $acData['ac_id'];
                ?>" required>
                    <option value="" class="cb">Account</option>
                    <?php
                    while ($dataAc = mysqli_fetch_assoc($selresultAc)) {
                        ?>
                        <option value="<?php echo $dataAc['ac_id'] ?>" class="cb"><?php echo $dataAc['ac_type'] ?></option>
                        <?php
                    }
                    ?>
                </select>
                <select name="selectCat" class="allInput soption selfn" id="<?php
                echo $catData['category_id'];
                ?>" required>
                    <option value="" class="cb">Category</option>
                    <?php
                    while ($dataCat = mysqli_fetch_assoc($selresultCat)) {
                        ?>
                        <option value="<?php echo $dataCat['category_id'] ?>" class="cb"><?php echo $dataCat['category'] ?>
                        </option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="input-box"><textarea name="txtAreaNote" class="allInput txtArea"
                    placeholder="Note"><?php if (isset($data['note'])) {
                        echo $data['note'];
                    } ?></textarea>
            </div>
            <div class="input-box"><input type="text" name="txtExpense" class="allInput itxt" placeholder="₹" required
                    value="<?php
                    if(isset($_GET['expense_id'])){echo $data['expense'];}else{echo $data['income'];}
                    ?>">
            </div>
            <div class="input-box">
                <input type="date" name="date" class="allInput dbox" required value="<?php
                echo $data['date'];
                ?>">
            </div>
            <button type="submit" name="btnupdate" class="btnithalf">Update</button>
            <button type="submit" name="btndelete" class="btnithalf"
                onclick="return confirm('Are you sure to delete?');">Delete</button>
            <a href="expense.php"><button type="button" name="btnclose" class="btnit">Back</button></a>
            <?php } ?>
        </form>
    </div>
    <script src="../JS/exUpdate.js"></script>
</body>

</html>
<?php
session_start();
if (!isset($_SESSION["user_id"]))
    {header("location:login.php");}
include("connection.php");

if (isset($_GET['dcategory_id'])) {
    $delete = "delete from category where category_id=$_GET[dcategory_id]";
    mysqli_query($connect, $delete);
}

if (isset($_POST['btnadd'])) {
    $txtCatName = $_POST['txtCatName'];
    $type = $_POST['type'];
    $uploadName = "../Assets/catImage/" . $_FILES['file']['name'];
    $tmpname = $_FILES['file']['tmp_name'];
    move_uploaded_file($tmpname, $uploadName);
    global $connect;
    $insertqry = "insert into category values('','$txtCatName','$type','$uploadName')";
    mysqli_query($connect, $insertqry);


}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker-adminpanel</title>
    <link rel="stylesheet" href="../CSS/adminpanel.css">
    <link rel="stylesheet" href="../CSS/UTILITY.css">
</head>

<body>
    <div></div>
    <div class="up flex align-center">Expense Tracker</div>
    <div class="down">
        <div class="left flex justify-center">
            <ul>
                <a href="adminPanel.php" class="active">
                    <li>Category</li>
                </a>
                <a href="adAc.php" class="liac">
                    <li>Account</li>
                </a>
                <a href="logout.php">
                    <li>Logout</li>
                </a>
            </ul>
        </div>
        <div class="right">
            <div class="heading flex align-center">
                <h1>Category</h1>
                <!-- <a href="./admincatinsert.php"><button class="btnaddcat">Add Category</button></a> -->
                <button class="btnaddcat">Add Category</button>
            </div>
            <div class="content">
                <table>
                    <tr>
                        <th>icons</th>
                        <th>category</th>
                        <th>income/expanse</th>
                        <th>edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    $select = "select * from category order by category_id desc";
                    $selresult = mysqli_query($connect, $select);
                    while ($data = mysqli_fetch_assoc($selresult)) {
                        ?>
                        <tr>
                            <td><img src="<?php echo $data['icons'] ?>" alt="CategoryIcon" class="categoryIcon" /></td>
                            <td><?php echo $data['category']; ?></td>
                            <td><?php echo $data['inen']; ?></td>
                            <td class="button"><a
                                    href="adEdit.php?category_id=<?php echo $data['category_id']; ?>"><button>
                                        Edit</button></a></td>
                            <td class="button"><a href="adminpanel.php?dcategory_id=<?php echo $data['category_id']; ?>"
                                    onclick="return confirm('Are you sure to delete?');"><button>Delete</button></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script src="../JS/adminpanel.js"></script>
</body>

</html>
<?php
include("connection.php");

if (isset($_GET['dac_id'])) {
    $delete = "delete from account where ac_id=$_GET[dac_id]";
    mysqli_query($connect, $delete);
}

if (isset($_POST['btnadd'])) {
    $ac_type = $_POST['txtAcType'];
    $uploadName = "../Assets/acImage/" . $_FILES['file']['name'];
    $tmpname = $_FILES['file']['tmp_name'];
    move_uploaded_file($tmpname, $uploadName);
    global $connect;
    $insertqry = "insert into account values('','$ac_type','$uploadName')";
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
                <a href="adminPanel.php">
                    <li>Category</li>
                </a>
                <a href="adAc.php" class="active">
                    <li>Account</li>
                </a>
                <a href="logout.php">
                    <li>Logout</li>
                </a>
            </ul>
        </div>
        <div class="right">
            <div class="heading flex align-center">
                <h1>Account</h1>
                <button class="btnAddAc">Add Account</button>
            </div>
            <div class="content">
                <table>
                    <tr>
                        <th>icons</th>
                        <th>ac_Type</th>
                        <th>edit</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    $select = "select * from account order by ac_id desc";
                    $selresult = mysqli_query($connect, $select);
                    while ($data = mysqli_fetch_assoc($selresult)) {
                        ?>
                        <tr>
                            <td><img src="<?php echo $data['icon'] ?>" alt="CategoryIcon" class="categoryIcon" /></td>
                            <td><?php echo $data['ac_type']; ?></td>
                            <td class="button"><a
                                    href="adEdit.php?ac_id=<?php echo $data['ac_id']; ?>"><button>
                                        Edit</button></a></td>
                            <td class="button"><a href="adAc.php?dac_id=<?php echo $data['ac_id']; ?>"
                                    onclick="return confirm('Are you sure to delete?');"> <button>Delete</button></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script src="../JS/adAc.js"></script>
</body>

</html>
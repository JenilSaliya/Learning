<?php
session_start();
if (!isset($_SESSION["user_id"]))
    header("location:login.php");
include("connection.php");

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $select = "select * from category where category_id=$category_id";
    $selresult = mysqli_query($connect, $select);
    $data = mysqli_fetch_assoc($selresult);
}

if (isset($_POST['btnupdate']) && isset($_GET['category_id'])) {
    $txtCatName = $_POST['txtCatName'];
    $type = $_POST['type'];
    if (empty($_FILES['file']['name'])) {
        $uploadName = $_POST['txtfilename'];
    } else {
        if (isset($_POST['txtfilename'])) {
            unlink($_POST['txtfilename']);
        }
        $uploadName = "../Assets/catImage" . $_FILES['file']['name'];
        $tmpname = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmpname, $uploadName);
    }

    $update = "update category set category='$txtCatName',inen='$type',icons='$uploadName' where category_id=$_GET[category_id]";
    if (mysqli_query($connect, $update)) {
        header("location:adminpanel.php");
    } else {
        echo mysqli_error($connect);
    }
}
if (isset($_GET['ac_id'])) {
    $ac_id = $_GET['ac_id'];
    $select = "select * from account where ac_id=$ac_id";
    $selresult = mysqli_query($connect, $select);
    $data = mysqli_fetch_assoc($selresult);
}

if (isset($_POST['btnupdate']) && isset($_GET['ac_id'])) {
    $txtAcType = $_POST['txtAcType'];
    if (empty($_FILES['file']['name'])) {
        $uploadName = $_POST['txtfilename'];
    } else {
        if (isset($_POST['txtfilename'])) {
            unlink($_POST['txtfilename']);
        }
        $uploadName = "../Assets/acImage" . $_FILES['file']['name'];
        $tmpname = $_FILES['file']['tmp_name'];
        move_uploaded_file($tmpname, $uploadName);
    }

    $update = "update account set ac_type='$txtAcType',icon='$uploadName' where ac_id=$_GET[ac_id]";
    if (mysqli_query($connect, $update)) {
        header("location:adAc.php");
    } else {
        echo mysqli_error($connect);
    }
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
    <div class="up flex align-center">Expense Tracker</div>
    <div class="down">
        <div class="left flex justify-center">
            <ul>
                <a href="adminPanel.php">
                    <li>Category</li>
                </a>
                <a href="adAc.php">
                    <li>Account</li>
                </a>
                <a href="logout.php">
                    <li>Logout</li>
                </a>
            </ul>
        </div>
        <?php
        if (isset($_GET['category_id'])) {
            ?>
            <div class="right flex justify-center align-center">
                <div class="flex justify-center align-center">
                    <div class="addCat flex align-center justify-center" id="upcat">
                        <h2>Update Category</h2>
                        <form method="post" enctype="multipart/form-data">
                            <div class="input-box">
                                <label>Icon</label>
                                <?php
                                if (isset($_GET['category_id'])) {
                                    ?>
                                    <input type="hidden" name="txtfilename" value="<?php echo $data['icons'] ?>" />
                                    <br /><img src="<?php echo $data['icons'] ?>" width="30" height="30"
                                        style="margin-bottom: 5px;" />
                                    <?php
                                }
                                ?>
                                <input type="file" name="file" accept=".png">

                            </div>
                            <div class=" input-box">
                                <label>Name</label>
                                <input type="text" name="txtCatName" value="<?php if (isset($_GET['category_id'])) {
                                    echo $data['category'];
                                } ?> ">
                            </div>
                            <div class="input-box">

                                <label>Type</label>
                                <select name="type" class="<?php
                                if (isset($_GET['category_id'])) {
                                    echo $data['inen'];
                                }
                                ?> selecti">
                                    <option value="expense">Expense</option>
                                    <option value="income">Income</option>
                                </select>
                            </div>
                            <button type="submit" class="btn" name="btnupdate">Update</button>
                            <a href="adminPanel.php"><button type="button" class="btn cbtn" name="cbtn">Back</button></a>
                        </form>


                    </div>
                </div>
            </div>
        <?php
        } elseif (isset($_GET['ac_id'])) { ?>
            <div class="right flex justify-center align-center">
                <div class="flex justify-center align-center">
                    <div class="addCat flex align-center justify-center" id="upcat">
                        <h2>Update Account</h2>
                        <form method="post" enctype="multipart/form-data">
                            <div class="input-box">
                                <label>Icon</label>
                                <?php
                                if (isset($_GET['ac_id'])) {
                                    ?>
                                    <input type="hidden" name="txtfilename" value="<?php echo $data['icon'] ?>" />
                                    <br /><img src="<?php echo $data['icon'] ?>" width="30" height="30"
                                        style="margin-bottom: 5px;" />
                                    <?php
                                }
                                ?>
                                <input type="file" name="file" accept=".png">

                            </div>
                            <div class=" input-box">
                                <label>ac_Type</label>
                                <input type="text" name="txtAcType" value="<?php if (isset($_GET['ac_id'])) {
                                    echo $data['ac_type'];
                                } ?> ">
                            </div>
                            <button type="submit" class="btn" name="btnupdate">Update</button>
                            <a href="adAc.php"><button type="button" class="btn cbtn" name="cbtn">Back</button></a>
                        </form>


                    </div>
                </div>
            </div>
            <?php
        } 
        ?>
    </div>
    <script src="../JS/adminEdit.js"></script>
</body>

</html>
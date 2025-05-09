<?php
include('connection.php');
    global $connect;
    $selectCat = "select * from category where inen='expense'";
    $selresultCat = mysqli_query($connect, $selectCat);
    

    $selectAc = "select * from account";
    $selresultAc = mysqli_query($connect, $selectAc);
?>
<!-- form.php -->
<div class="incon">
    <form method="post">
        <div class="input-box"><select name="selectIE" class="allInput sie">
                <option value="expense" selected>Expense</option>
                <option value="income">Income</option>
            </select>
        </div>
        <div class="input-box">
            <select name="selectAc" class="allInput soption" required>
                <option value="" class="cb">Account</option>
                <?php
                while ($dataAc = mysqli_fetch_assoc($selresultAc)) {
                    ?>
                    <option value="<?php echo $dataAc['ac_id'] ?>" class="cb"><?php echo $dataAc['ac_type'] ?></option>
                    <?php
                }
                ?>
            </select>
            <select name="selectCat" class="allInput soption" required>
                <option value="" class="cb">Category</option>
                <?php
                while ($dataCat = mysqli_fetch_assoc($selresultCat)) {
                    ?>
                    <option value="<?php echo $dataCat['category_id'] ?>" class="cb"><?php echo $dataCat['category'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="input-box"><textarea name="txtAreaNote" class="allInput txtArea" placeholder="Note"></textarea>
        </div>
        <div class="input-box"><input type="text" name="txtExpense" class="allInput itxt" placeholder="₹" required>
        </div>
        <div class="input-box">
            <input type="date" name="date" class="allInput dbox" required>
        </div>
        <button type="submit" name="btnSubmit" class="btnit">Add</button>
        <button type="button" class="btnClose btnit">Close</button>
    </form>
</div>

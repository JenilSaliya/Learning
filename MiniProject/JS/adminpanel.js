let btn = document.querySelector('.btnaddcat')
if(!btn){
    console.log('btn not found');
    
}else{
btn.addEventListener('click',() => {
    let body = document.body.firstElementChild;
    body.setAttribute("class","activeAdd flex align-center justify-center");
   let html = `<div class="addCat flex align-center justify-center">
            <h2>New Category</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="input-box">
                    <label>Icon</label>
                    <input type="file" name="file" required accept=".png">
                </div>
                <div class="input-box">
                    <label>Name</label>
                    <input type="text" name="txtCatName" required>
                </div>
                <div class="input-box">
                    <label>Type</label>
                    <select name="type">
                        <option value="expense" select>Expanse</option>
                        <option value="income">Income</option>
                    </select>
                </div>
                <button type="submit" class="btn" name="btnadd">Add</button>
                <button type="button" class="btn cbtn" name="cbtn">Close</button>
            </form>
                            

        </div>`;
    body.innerHTML=html

    let cbtn = document.querySelector('.cbtn');

    cbtn.addEventListener('click',() =>{
        let body = document.body.firstElementChild;
        body.innerHTML=""
        body.setAttribute("class","")
    });
    
});

}


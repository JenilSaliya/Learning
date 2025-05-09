// const month = document.querySelector('.monthName');
// const monthno = document.querySelector('.monthNumber');
const btnl = document.querySelector('.clbtn');
const btnr = document.querySelector('.crbtn');
const monthN = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", " December"];
const rg=document.querySelector('.idown');
const rg1=document.querySelector('.edown');
const rg2=document.querySelector('.tdown');
const addicon=document.querySelector('.addicon')
const record=document.querySelector('.record')
const acamount=document.querySelectorAll('.acamount')


acamount.forEach(element => {
        const textContent = parseFloat(element.textContent);
    
        if (textContent < 0) {
        element.classList.add('red');
    } else {
        element.classList.add('green');
    }
});


// const d = new Date();
// var a = d.getMonth();
// // console.log(a);
// month.value = monthN[a]
// monthno.value=a
// console.log(monthno.value);



// btnl.addEventListener('click', () => {
//     if (a > 0) {
//         a = a - 1;
//     }
//     else {
//         a = 11;
//     }
   
//     month.value = monthN[a]
//     monthno.value=a
//     // console.log(monthN[a]);
// });
// btnr.addEventListener('click', () => {
//     if (a >= 11) {
//         a = 0;
//     }
//     else {
//         a = a + 1;
//     }   
//     month.value = monthN[a]
//     monthno.value=a
//     // console.log(monthN[a]);
// });
if(rg.textContent<0){
    document.querySelector('.idown').classList.add('red')
}
else{
    document.querySelector('.idown').classList.add('green') 
}
if(rg1.textContent<0){
    document.querySelector('.edown').classList.add('red')
}
else{
    document.querySelector('.edown').classList.add('green') 
}
rg2.innerHTML=parseInt(rg.textContent)+parseInt(rg1.textContent);
// console.log(rg2);
if(rg2.textContent<0){
    document.querySelector('.tdown').classList.add('red')
}
else{
    document.querySelector('.tdown').classList.add('green') 
}


document.addEventListener('DOMContentLoaded', () => {
    const ienoElements= document.querySelectorAll('.ieno');
    // console.log(ienoElements);

    ienoElements.forEach(element => {
            const textContent = parseFloat(element.textContent);
        
            if (textContent < 0) {
            element.classList.add('red');
        } else {
            element.classList.add('green');
        }
    });
});

addicon.addEventListener('click', () => {
    let body = document.body.firstElementChild;
    body.setAttribute("class", "inset flex justify-center align-center");

    loadForm('form.php', body);

    document.addEventListener('change', (event) => {
        if (event.target.name === 'selectIE') {
            const selectedValue = event.target.value;
            const formToLoad = selectedValue === 'expense' ? 'form.php' : 'form1.php';
            loadForm(formToLoad, body);
        }
    });
});

function loadForm(formName, body) {
    fetch(formName)
        .then(response => response.text())
        .then(html => {
            body.innerHTML = html;

            // Re-attach the close button event listener
            const btnClose = document.querySelector('.btnClose');
            btnClose.addEventListener('click', () => {
                body.innerHTML = "";
                body.setAttribute("class", "");
            });
        })
        .catch(error => console.error('Error loading form:', error));
}



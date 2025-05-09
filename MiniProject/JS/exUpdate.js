const select = document.querySelector('.sie')
if(!select){
    console.log('not found select');
    
}else{
console.log(select.className);

if(select.className=='expense allInput sie'){
 
    select.value='expense'
    
    
}
else{
   select.value='income'
    
}
}



const selac=document.querySelector('.soption')
if(!selac){
    console.log('not found selac');
    
}else{
selac.value=selac.id
}


const selcat=document.querySelector('.selfn')
// console.log(selcat.id);
if(!selcat){
    console.log('not found selcat');
    
}else{
selcat.value=selcat.id
}


const selbgtcat=document.querySelector('.sfc')
if(!selbgtcat){
    console.log('not found sselbgtcat');
    
}else{
console.log(selbgtcat.id);

selbgtcat.value=selbgtcat.id
}

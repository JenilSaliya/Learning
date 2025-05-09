let select = document.querySelector('.selecti')
if(!select){
    console.log('select not found');
    
}else{
console.log(select.className);

if(select.className=='income selecti'){
 
    select.value='income'
    
}
else{
   select.value='expense'

}
}
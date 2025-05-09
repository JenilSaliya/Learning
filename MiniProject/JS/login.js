const main = document.querySelector('main');
const loginlink = document.querySelector('.login-link');
const registerlink = document.querySelector('.register-link');
const errorde = document.querySelector('.cancle');
const regbtn = document.querySelector('.regbtn');

registerlink.addEventListener('click', () => {
    main.classList.add('active');
});
loginlink.addEventListener('click', () => {
    main.classList.remove('active');
});
errorde.addEventListener('click', () => {
    document.querySelector('.error').classList.add('deactive');
});
regbtn.addEventListener('click',()=>{
    main.classList.add('active');
});
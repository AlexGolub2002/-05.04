const signInBtn = document.querySelector('.signin-btn');
const signUpBtn = document.querySelector('.signup-btn');
const formBox = document.querySelector('.form-box');
const body = document.body;

signUpBtn.addEventListener('click', function () {
   formBox.classList.add('_active');
   body.classList.add('_active');
});
signInBtn.addEventListener('click', function () {
   formBox.classList.remove('_active');
   body.classList.remove('_active');
});
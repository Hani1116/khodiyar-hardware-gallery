let navbar = document.querySelector('.header .flex .navbar');
let profile = document.querySelector('.header .flex .profile');

document.querySelector('#menu-btn').onclick = () =>{
   navbar.classList.toggle('active');
   profile.classList.remove('active');
}

document.querySelector('#user-btn').onclick = () =>{
   profile.classList.toggle('active');
   navbar.classList.remove('active');
}

window.onscroll = () =>{
   navbar.classList.remove('active');
   profile.classList.remove('active');
}

let mainImage = document.querySelector('.quick-view .box .row .image-container .main-image img');
let subImages = document.querySelectorAll('.quick-view .box .row .image-container .sub-image img');

subImages.forEach(images =>{
   images.onclick = () =>{
      src = images.getAttribute('src');
      mainImage.src = src;
   }
});



const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
const mobileRegex = /^([0-9]{10})$/;
const form = document.querySelector("#form")
const contact = document.querySelector("#contact_number")
const email = document.querySelector("#email")
const password = document.querySelector("#password")
const confirm_password = document.querySelector("#confirm_password")
const message = document.querySelector("#message")
const submit_button = document.querySelector("#submit_button")


let isValidEmail = false
let isValidContact = false
let isValidPassword = false
let isValidConfirmPassword = false

function removeMessage(){
   message.textContent = ""
}

function showMessage () {
   message.innerHTML = `• Must be at least 8 characters long <br>• At least one uppercase letter, one lowercase letter<br>• And one special character, one number.`
}

password.onfocus = showMessage

email.addEventListener("input", function () {
   let value = email.value
   console.log(value)
   if (value != "") {
      if (!emailRegex.test(value)) {
         email.classList.add("error")
         isValidEmail = false
         checkValidation()
      }
      else {
         email.classList.remove("error")
         checkValidation()
         isValidEmail = true
      }
   }
   else {
      if (email.classList.contains("error")) {
         email.classList.remove("error")
         checkValidation()
         isValidEmail = false
      }
   }
})

contact.addEventListener("input",function () {
   let value = contact.value
   console.log(value)
   if (value != "") {
      if (!mobileRegex.test(value)) {
         contact.classList.add("error")
         isValidContact = false
         checkValidation()

      }
      else {
         contact.classList.remove("error")
         isValidContact = true
         checkValidation()

      }
   }
   else {
      if (contact.classList.contains("error")) {
         contact.classList.remove("error")
         isValidContact = false
         checkValidation()

      }
   }
})

password.addEventListener("input", function () {
   let value = password.value
   console.log(value)
   if (value != "") {
      if (!passwordRegex.test(value)) {
         isValidPassword = false
         checkValidation()

         password.onfocus = showMessage
         showMessage()
         password.classList.add("error")
         console.log("if executed")
      }
      else {
         password.onfocus = removeMessage
         removeMessage()
         password.classList.remove("error")
         isValidPassword = true
         checkValidation()

      }
   }
   else {
      if (password.classList.contains("error")) {
         password.classList.remove("error")
         isValidPassword = false
         checkValidation()

      }
   }
})

confirm_password.addEventListener("input", function () {
   let password_val = password.value;
   let confirm_password_val = confirm_password.value;
   if (confirm_password_val != "") {
      if (password_val !== confirm_password_val) {
         confirm_password.classList.add("error")
         isValidConfirmPassword = false
         checkValidation()

      }
      else {
         confirm_password.classList.remove("error")
         isValidConfirmPassword = true
         checkValidation()

      }
   }
   else {
      if (confirm_password.classList.contains("error")) {
         confirm_password.classList.remove("error")
         isValidConfirmPassword = false
         checkValidation()

      }
   }
})

function checkValidation() {
  if (isValidEmail && isValidContact && isValidPassword && isValidConfirmPassword) {
    submit_button.classList.remove("disabled")
  } else {
     submit_button.classList.add("disabled")
  }
}




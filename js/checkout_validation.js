const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const mobileRegex = /^([0-9]{10})$/;
const contact = document.querySelector("#contact_number")
const email = document.querySelector("#email")
const submit_button = document.querySelector("#submit_button")

let isValidEmail = false
let isValidContact = false

email.addEventListener("input", function () {
   let value = email.value
   if (value != "") {
      if (!emailRegex.test(value)) {
          email.classList.add("error")
          email.classList.remove("border")
         isValidEmail = false
          checkoutValidation()
          console.log("ivalid")
      }
      else {
         email.classList.remove("error")
         email.classList.add("border")
         checkoutValidation()
        isValidEmail = true
        console.log("valid")  
      }
   }
   else {
      if (email.classList.contains("error")) {
         email.classList.remove("error")
         email.classList.add("border")
         checkoutValidation()
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
          contact.classList.remove("border")
         isValidContact = false
         checkoutValidation()
        console.log("invalid")
      }
      else {
          contact.classList.remove("error")
          contact.classList.add("border")
         isValidContact = true
         checkoutValidation()
        console.log("valid  ")
      }
   }
   else {
      if (contact.classList.contains("error")) {
          contact.classList.remove("error")
          contact.classList.add("border")
         isValidContact = false
         checkoutValidation()
      }
   }
})

function checkoutValidation() {
  if (isValidEmail && isValidContact) {
    submit_button.classList.remove("disabled")
  } else {
     submit_button.classList.add("disabled")
  }
}
let body = document.body;

let profile = document.querySelector(".header .flex .profile");
// let report = document.querySelector('.header .flex .report');

document.querySelector("#user-btn").onclick = () => {
  profile.classList.toggle("active");
  searchForm.classList.remove("active");
};

// document.querySelector('#reoprt-btn').onclick = () =>{
//    report.classList.toggle('active');
//    searchForm.classList.remove('active');
// }

let searchForm = document.querySelector(".header .flex .search-form");

document.querySelector("#search-btn").onclick = () => {
  searchForm.classList.toggle("active");
  profile.classList.remove("active");
};

let sideBar = document.querySelector(".side-bar");

document.querySelector("#menu-btn").onclick = () => {
  sideBar.classList.toggle("active");
  body.classList.toggle("active");
};

document.querySelector(".side-bar .close-side-bar").onclick = () => {
  sideBar.classList.remove("active");
  body.classList.remove("active");
};

window.onscroll = () => {
  profile.classList.remove("active");
  searchForm.classList.remove("active");

  if (window.innerWidth < 1200) {
    sideBar.classList.remove("active");
    body.classList.remove("active");
  }
};

let toggleBtn = document.querySelector("#toggle-btn");
let darkMode = localStorage.getItem("dark-mode");

const enabelDarkMode = () => {
  toggleBtn.classList.replace("fa-sun", "fa-moon");
  body.classList.add("dark");
  localStorage.setItem("dark-mode", "enabled");
};

const disableDarkMode = () => {
  toggleBtn.classList.replace("fa-moon", "fa-sun");
  body.classList.remove("dark");
  localStorage.setItem("dark-mode", "disabled");
};

toggleBtn.onclick = (e) => {
  let darkMode = localStorage.getItem("dark-mode");
  if (darkMode === "disabled") {
    enabelDarkMode();
  } else {
    disableDarkMode();
  }
};

if (darkMode === "enabled") {
  enabelDarkMode();
}

let mainImage = document.querySelector(
  ".update-product .image-container .main-image img"
);
let subImages = document.querySelectorAll(
  ".update-product .image-container .sub-image img"
);

subImages.forEach((images) => {
  images.onclick = () => {
    src = images.getAttribute("src");
    mainImage.src = src;
  };
});

const report = document.querySelector("#report");
const start_date_input = document.querySelector("#start-date");
const end_date_input = document.querySelector("#end-date");
const submit_btn = document.querySelector("#submit-btn");

report.addEventListener("change", function handleReportChange(event) {
  if (this.value == "payment") {
    document.querySelector(".dates").classList.remove("hidden");
    start_date_input.setAttribute("required", "");
    end_date_input.setAttribute("required", "");
    submit_btn.classList.add("disabled");
  } else {
    document.querySelector(".dates").classList.add("hidden");
    start_date_input.removeAttribute("required");
    end_date_input.removeAttribute("required");
    submit_btn.classList.remove("disabled");
  }
});

end_date_input.addEventListener("change", function () {
  let start_date = new Date(start_date_input.value);
  let end_date = new Date(this.value);
  console.log(start_date, end_date);
  if (end_date < start_date) {
    alert("please enter proper dates");
    submit_btn.classList.add("disabled");
    console.log("failure");
  } else {
    submit_btn.classList.remove("disabled");
    console.log("success");
  }
});

this.onload = function () {
  if (report.value == "payment") {
    document.querySelector(".dates").classList.remove("hidden");
    start_date_input.setAttribute("required", "");
    end_date_input.setAttribute("required", "");
    submit_btn.classList.add("disabled");
    let start_date = new Date(start_date_input.value);
    let end_date = new Date(this.value);
    console.log(start_date, end_date);
    if (end_date < start_date) {
      alert("please enter proper dates");
      submit_btn.classList.add("disabled");
      console.log("failure");
    } else {
      submit_btn.classList.remove("disabled");
      console.log("success");
    }
  } else {
    document.querySelector(".dates").classList.add("hidden");
    start_date_input.removeAttribute("required");
    end_date_input.removeAttribute("required");
    submit_btn.classList.remove("disabled");
  }
};

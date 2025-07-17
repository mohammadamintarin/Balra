const toggleThemeBtns = document.querySelectorAll(".toggle-theme");
const submenuBtn = document.querySelector(".submenu-btn");
const submenu = document.querySelector(".submenu");
const navIcon = document.querySelector(".nav-icon");
const navIconClose = document.querySelector(".close");
const nav = document.querySelector(".nav");
const overlay = document.querySelector(".overlay");
toggleThemeBtns.forEach(btn => {
    btn.addEventListener("click" , () => {
        if (localStorage.theme === "dark"){
            document.documentElement.classList.remove("dark");
            localStorage.theme = "light";
        } else {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme" , "dark");
        }
})
})

submenuBtn.addEventListener("click" , () => {
    submenu.classList.toggle("submenu--open");
})

navIcon.addEventListener("click" , () => {
    nav.classList.remove('-right-64')
    nav.classList.add('right-0')
    overlay.classList.add('overlay--visible')
})
navIconClose.addEventListener("click" , () => {
    nav.classList.add('-right-64')
    nav.classList.remove('right-0')
    overlay.classList.remove('overlay--visible')
})
overlay.addEventListener("click" , () => {
    nav.classList.add('-right-64')
    nav.classList.remove('right-0')
    overlay.classList.remove('overlay--visible')
})

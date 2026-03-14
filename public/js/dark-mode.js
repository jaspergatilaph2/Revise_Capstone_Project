
// document.addEventListener("DOMContentLoaded", function () {

//     const toggle = document.getElementById("darkModeToggle");

//     // Load saved mode
//     if (localStorage.getItem("theme") === "dark") {
//         document.body.classList.add("dark-mode");
//         toggle.checked = true;
//     }

//     toggle.addEventListener("change", function () {

//         if (this.checked) {
//             document.body.classList.add("dark-mode");
//             localStorage.setItem("theme", "dark");
//         } else {
//             document.body.classList.remove("dark-mode");
//             localStorage.setItem("theme", "light");
//         }

//     });

// });


document.addEventListener("DOMContentLoaded", function () {

    const toggle = document.getElementById("darkModeToggle");
    const dashboard = document.querySelector(".applicant-dashboard");

    if (!dashboard) return;

    // Load saved theme
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme === "dark") {
        dashboard.classList.add("dark-mode");
        if (toggle) toggle.checked = true;
    }

    if (toggle) {
        toggle.addEventListener("change", function () {

            if (this.checked) {
                dashboard.classList.add("dark-mode");
                localStorage.setItem("theme", "dark");
            } else {
                dashboard.classList.remove("dark-mode");
                localStorage.setItem("theme", "light");
            }

        });
    }

});
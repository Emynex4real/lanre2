function accountRecord(formId, url, successDiv, dangerDiv, successUrl = null) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    scrollToTop(); clearTextDanger();

    document.getElementById(dangerDiv).classList.add("d-none");
    document.getElementById(successDiv).classList.add("d-none");

    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);

    xhr.onload = function () {
        try {
            console.log(this.responseText);
            const response = JSON.parse(this.responseText);

            if (response.success) {
                document.getElementById(successDiv).classList.remove("d-none");
                form.reset(); 

                if (successUrl) {
                    setTimeout(() => {
                        document.querySelectorAll("button")[0].disabled = false;
                        window.location.replace(successUrl);
                    }, 3000);
                }

            } else {
                // Display validation errors
                Object.keys(response.errors).forEach(key => {
                    const errorField = document.getElementById(key + "Err");
                    errorField.textContent = response.errors[key]; // Display error message
                });

                if (submitButtons.length > 0) {
                    submitButtons.forEach(button => {
                        button.disabled = false;; // Disable the button
                    });
                }

                document.getElementById(dangerDiv).classList.remove("d-none");
            }
        } catch (e) { console.log(e);}
    };
    xhr.send(formData);
}

console.log(document.querySelectorAll("input[type='submit']"));

function clearTextDanger() {
    const errorElements = document.querySelectorAll('.danger-text');
    errorElements.forEach(element => {
        element.innerHTML = ''; // Clear the inner HTML
    });
}


const submitButtons = document.querySelectorAll("input[type='submit']");
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Smooth scroll animation
    });
}


if (document.getElementById("register-form")) {
    document.getElementById("register-form").addEventListener("submit", function (e) {
        e.preventDefault();
        accountRecord("register-form", "users/config/register_user.php", "registerationSuccess", "registerationFailed", "/account/registered");
    });
}

if (document.getElementById("login-form")) {
    document.getElementById("login-form").addEventListener("submit", function (e) {
        e.preventDefault();
        accountRecord("login-form", "users/config/user_login.php", "loginSuccess", "loginFailed", "/account/logged_in");
    });
}

if (document.getElementById("forgot-password-form")) {
    document.getElementById("forgot-password-form").addEventListener("submit", function (e) {
        e.preventDefault();
        submitButtons.forEach(button => {
            button.disabled = true; // Disable the button
        });
        accountRecord("forgot-password-form", "users/config/forgot_password.php", "forgotSuccess", "forgotFailed");
    });
}

if (document.getElementById("reset-password-form")) {
    document.getElementById("reset-password-form").addEventListener("submit", function (e) {
        e.preventDefault();
        submitButtons.forEach(button => {
            button.disabled = true; // Disable the button
        });
        accountRecord("reset-password-form", "users/config/forgot_password.php", "resetSuccess", "resetFailed", "/login");
    });
}

if (document.getElementById('togglePassword')) {
    document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordField = document.getElementById('password');
        var passwordToggleEye = document.getElementById('togglePassword');
 
        // Check if the password field type is 'password'
        if (passwordField.type === 'password') {
            // Change the type to 'text' to show the password
            passwordField.type = 'text';
            passwordToggleEye.classList.remove("fa-eye");
            passwordToggleEye.classList.add("fa-eye-slash");// Update button text
        } else {
            // Change the type back to 'password' to hide the password
            passwordField.type = 'password';
            passwordToggleEye.classList.add("fa-eye");
            passwordToggleEye.classList.remove("fa-eye-slash"); // Update button text
        }
    });
}


if (document.getElementById('togglecPassword')) {
    document.getElementById('togglecPassword').addEventListener('click', function() {
        var passwordField = document.getElementById('cpassword');
        var passwordToggleEye = document.getElementById('togglecPassword');
        
        // Check if the password field type is 'password'
        if (passwordField.type === 'password') {
            // Change the type to 'text' to show the password
            passwordField.type = 'text';
            passwordToggleEye.classList.remove("fa-eye");
            passwordToggleEye.classList.add("fa-eye-slash"); // Update button text
        } else {
            // Change the type back to 'password' to hide the password
            passwordField.type = 'password';
            passwordToggleEye.classList.add("fa-eye");
            passwordToggleEye.classList.remove("fa-eye-slash"); // Update button text
        }
    });
}
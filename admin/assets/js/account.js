// TOGGLE EYE VISIBILITY
function toogleEye() {
    var eye = document.getElementById("toogle-eye");
    var password = document.getElementById("password");
    var new_password = document.getElementById("new_password");
    var confirm_password = document.getElementById("confirm_password");

    // TOOGLE PASSWORD
    if (password) {
        if (password.type === "password") {
            password.type = "text";
            eye.classList.remove("fa-eye");
            eye.classList.add("fa-eye-slash");
        } else {
            password.type = "password";
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
        }
    }

    // TOOGLE NEW PASSWORD
    if (new_password) {
        if (new_password.type === "password") {
            new_password.type = "text";
            eye.classList.remove("fa-eye");
            eye.classList.add("fa-eye-slash");
        } else {
            new_password.type = "password";
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
        }
    }

    // TOOGLE CONFIRM PASSWORD
    if (confirm_password) {
        if (confirm_password.type === "password") {
            confirm_password.type = "text";
            eye.classList.remove("fa-eye");
            eye.classList.add("fa-eye-slash");
        } else {
            confirm_password.type = "password";
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
        }
    }
}



                            //    AJAX SUBMIT MESSAGES
// REGISTER FORM
const form = {
    message: document.getElementById("message"),
    register_form: document.getElementById("login-form"),
    username: document.getElementById("username"),
    mail: document.getElementById("email"),
    password: document.getElementById("password"),
    usernameErr: document.getElementById("usernameErr"),
    mailErr: document.getElementById("emailErr"),
    passwordErr: document.getElementById("passwordErr")
}

if (form.register_form) {
    form.register_form.addEventListener('submit', (e) => {
        e.preventDefault();
        const request = new XMLHttpRequest;

        request.onload = () => {
            let responseObject = null;


            try {
                responseObject = JSON.parse(request.responseText);
            } catch (e) {
            }

            if(responseObject) {
                handleResponse(responseObject);
                if(responseObject.registerOk === 1) {
                    window.location.replace("users/index.php");
                }           
            }
        };


        const requestData = `username=${form.username.value}&email=${form.mail.value}&password=${form.password.value}`;


        request.open('post', 'config/register_form_validation.php');
        request.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
        request.send(requestData);
    });
}


function handleResponse(responseObject) {
    if(responseObject.registerOk) {
        form.usernameErr.innerHTML = null;
        form.mailErr.innerHTML = null;
        form.passwordErr.innerHTML = null;
    } else {
        form.usernameErr.innerHTML = responseObject.username;
        form.mailErr.innerHTML = responseObject.mail;
        form.passwordErr.innerHTML = responseObject.password;
    }
}





// CHANGE PASSWORD
const change_password = {
    button: document.getElementById("change_password"),
    passwordUpdate: document.getElementById("password_updated"),
    successMessage: document.getElementById("success"),
    mail: document.getElementById("mail"),
    newPassword: document.getElementById("new_password"),
    confirmPassword: document.getElementById("confirm_password"),
    newPasswordErr: document.getElementById("new_passwordErr"),
    confirmPasswordErr: document.getElementById("confirm_passwordErr"),
}


if(change_password.button) {
    change_password.button.addEventListener("click", () => {
        const Password = new XMLHttpRequest;

        Password.onload = () => {
            let passwordObject = null;

            try {
                passwordObject = JSON.parse(Password.responseText);
            } catch(e) {
            }

            if(passwordObject) {
                handlePasswordChange(passwordObject);
            }
        }


        const requestPassword = `email=${change_password.mail.value}&new_passowrd=${change_password.newPassword.value}&confirm_passowrd=${change_password.confirmPassword.value}`;


        Password.open('post', '../config/forgot_password_integration.php');
        Password.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
        Password.send(requestPassword);
    })
}


function handlePasswordChange(passwordObject) {
    const showPasswordResult = setTimeout(() => {
        change_password.successMessage.style.display = "none"; 
    }, 3500);

    if(passwordObject.updated) {
        change_password.newPassword.value = "";
        change_password.confirmPassword.value = "";

        change_password.newPasswordErr.innerHTML = null;
        change_password.confirmPasswordErr.innerHTML = null;
    
        change_password.successMessage.style.display = "block"; 
        change_password.passwordUpdate.innerHTML = passwordObject.Update_text;
        showPasswordResult;

        if(passwordObject.redirect == 1 && passwordObject.updated == 1) {
            setTimeout(() => {
                window.location.replace("login");
            }, 4000)
        }
    } else {
        change_password.newPasswordErr.innerHTML = passwordObject.passwordErr;
        change_password.confirmPasswordErr.innerHTML = passwordObject.c_passwordErr;
    }
}





// LOGIN SYSTEM
const login = {
    form: document.querySelector(".login_form"),
    username: document.getElementById("username"),
    password: document.getElementById("password"),
    usernameErr: document.getElementById("usernameErr"),
    passwordErr: document.getElementById("passwordErr")
}

if(login.form) {
    login.form.addEventListener("submit", (e) => {
        e.preventDefault();
        const Login = new XMLHttpRequest;
    
        Login.onload = () => {
            let loginObject = null;
            
            try {
                loginObject = JSON.parse(Login.responseText);
            } catch(e) {
            }

            if(loginObject) {
                handleLogin(loginObject);
                if(loginObject.loginOk == 1) {
                    window.location.replace("index?login=true");
                }
            }
        }


        const requestLogin = `username=${login.username.value}&password=${login.password.value}`;


        Login.open('post', '../config/login_form.php');
        Login.setRequestHeader('content-type', 'application/x-www-form-urlencoded');
        Login.send(requestLogin);
    })
}


function handleLogin(loginObject) {
    if(loginObject.login) {
        login.usernameErr.innerHTML = null;
        login.passwordErr.innerHTML = null;
    } else {
        login.usernameErr.innerHTML = loginObject.usernameErr;
        login.passwordErr.innerHTML = loginObject.passwordErr;
    }
}
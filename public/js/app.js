var loginForm = document.getElementById('loginForm');

loginForm.onsubmit = function (event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/clients/login', false);

    xhr.onload = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status) {
                location.reload();
            } else {
                loginForm.reset();
                addingLoginAlert(loginForm, loginForm.parentNode, "Введеные неправильные логин/пароль.");
            }
        }
    };
    xhr.send(new FormData(loginForm));

};

function addingLoginAlert(form, parent, msg) {
    var div = document.createElement('DIV');
    div.className = "alert alert-danger";
    div.id = "alert";
    div.setAttribute('role', 'alert');
    div.innerText = msg;
    parent.insertBefore(div, form);
}


var registerForm = document.getElementById('registerForm');
registerForm.addEventListener('submit', function (event) {
    event.preventDefault();
    var loginError = false,
        emailError = false,
        passwordError = false,
        fileError = false;
    var data = new FormData(registerForm);
    var login = data.get('login');
    var password = data.get('password');
    var email = data.get('email');
    var file = document.getElementById('photoRegister');
    sleep(1000);
    if (login.length >= 5) {
        checkLogin();
        if (document.getElementById('loginExist')) {
            loginError = true;
        } else {
            loginError = false
        }
        if (password.length >= 6) {
            if (!checkPassword()) {
                passwordError = true;
            } else {
                passwordError = false;
            }
            if (validateEmail(email)) {
                checkEmail();
                if (document.getElementById('emailExist')) {
                    emailError = true;
                } else {
                    emailError = false
                }
                if (validateFileType(file)) {
                    fileError = false;
                } else {
                    fileError = true;
                }
            }
        }
    }


    if (!loginError && !passwordError && !emailError && !fileError) {
        registerForm.submit();
    }
});


function checkPassword() {
    var passwordNode = document.getElementById('passwordRegister');
    var password = passwordNode.value;
    var password2 = document.getElementById('passwordRepeatRegister').value;
    if (password2 !== password) {
        addingAlert(passwordNode.parentNode, passwordNode.parentNode.parentNode, "Пароли не совпадают.", "passwordIncorrect");
        return false;
    }
    return true;


}

function sleep(time) {
    return setTimeout(function () {
    }, time);
}


function checkLogin() {
    var loginNode = document.getElementById('loginRegister');
    var login = loginNode.value;
    if (login.length >= 5) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/clients/checkLoginExist/' + login, false);
        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (!response.status) {
                    addingAlert(loginNode.parentNode, loginNode.parentNode.parentNode, "Имя пользователя уже занято.", "loginExist");
                }
            }
        };
        xhr.send();
    }

}


function checkEmail() {
    var emailNode = document.getElementById('emailRegister');
    var email = emailNode.value;
    if (validateEmail(email)) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/clients/checkEmailExist', false);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onload = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (!response.status) {
                    addingAlert(emailNode.parentNode, emailNode.parentNode.parentNode, "Email уже используется.", "emailExist");
                }
            }
        };
        xhr.send("data=" + email);
    }

}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}


function addingAlert(element, parent, msg, id) {
    if (!document.getElementById(id)) {
        var div = document.createElement('DIV');
        div.className = "alert alert-danger";
        div.id = id;
        div.setAttribute('role', 'alert');
        div.innerText = msg;
        parent.insertBefore(div, element);
    }

}


function validateFileType(file) {
    var fileName = file.value;
    var idxDot = fileName.lastIndexOf(".") + 1;
    var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
    if (extFile === "jpg" || extFile === "jpeg" || extFile === "png" || extFile === "gif") {
        return true;
    } else {
        addingAlert(file.parentNode, file.parentNode.parentNode, "Формат не поддерживается", "fileError");
        return false;
    }
}


IMask(document.getElementById('phoneRegister'), {
    mask: '+{7}(000)000-00-00'
});

IMask(document.getElementById('phoneEdit'), {
    mask: '+{7}(000)000-00-00'
});
function removeAlert(id = '') {
    if (id === '') {
        $("#alert").alert('close');
    } else {
        $("#" + id).alert('close');
    }

}



window.onload = () => {

    const email = document.getElementById('email');
    const password1 = document.getElementById('password1');
    const password2 = document.getElementById('password2');
    const changeEmailButton = document.getElementById('changeEmail');
    const changePasswordButton = document.getElementById('changePassword');

    const resultAreaEmail = document.getElementById('resultAreaEmail');
    const resultAreaPassword = document.getElementById('resultAreaPassword');

    const isPasswordValid = () => {
        const okayLength = (password1.value.length >= 6 && password1.value.length <= 32) ||
            (password2.value.length >= 6 && password2.value.length <= 32);
        if (!okayLength){
            resultAreaPassword.innerText = "Password must have between 6 and 32 characters ";
            return false;
        }

        const match = password1.value ===
            password2.value;

        if (!match) {
            resultAreaPassword.innerText = "Passwords don't match";
        } else {
            resultAreaPassword.innerText = "";
        }
        return match && okayLength;
    }


    const isEmailValid = () => {
        return String(email.value)
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    };

    const passwordInputHandler = () => {
        if (isPasswordValid()){
            changePasswordButton.disabled = false;
        } else {
            changePasswordButton.disabled = true;
        }
    }
    const emailInputHandler = () => {
        if(isEmailValid()){
            changeEmailButton.disabled = false;
        } else {
            resultAreaEmail.innerText = 'But that\'s not an email!';
            changeEmailButton.disabled = true;
        }
    }

    password1.addEventListener('keyup',passwordInputHandler);
    password2.addEventListener('keyup',passwordInputHandler);
    email.addEventListener('keyup',emailInputHandler);

    changePasswordButton.disabled = true;
    changeEmailButton.disabled = true;
}
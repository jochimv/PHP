window.onload = () => {

    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const logIn = document.getElementById('logIn');

    const isValidPassword = () => {
        return password.value.length >= 6 && password.value.length <= 32;
    }
    const isValidEmail = () => {
        return String(email.value)
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    };

    const checkBoth = () => {
        if (isValidEmail() && isValidPassword()) {
            logIn.disabled = false;
        } else {
            logIn.disabled = true;
        }
    }

    const addCheckKeyupListeners = (elements) => {
        elements.forEach(element => element.addEventListener('keyup', checkBoth))
    }

    addCheckKeyupListeners([password, email]);

    checkBoth();
}
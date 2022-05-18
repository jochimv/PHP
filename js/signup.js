window.onload = () => {

    const email = document.getElementById('email');
    const password1 = document.getElementById('password1');
    const password2 = document.getElementById('password2');
    const signUp = document.getElementById('signUp');
    const resultArea = document.getElementById('resultArea');


    const isPasswordValid = () => {
        const okayLength = (password1.value.length >= 6 && password1.value.length <= 32) ||
            (password2.value.length >= 6 && password2.value.length <= 32);
        if (!okayLength){
            resultArea.innerText = "Password must have between 6 and 32 characters ";
            return false;
        }

        const match = password1.value ===
            password2.value;

        if (!match) {
            resultArea.innerText = "Passwords don't match";
        } else {
            resultArea.innerText = "";
        }
        return match && okayLength;
    }
    const isValidEmail = () => {
        return String(email.value)
            .toLowerCase()
            .match(
                /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            );
    };

    const checkBoth = () => {
        if (isValidEmail() && isPasswordValid()) {
            signUp.disabled = false;
        } else {
            signUp.disabled = true;
        }
    }

    const addCheckKeyupListeners = (elements) => {
        elements.forEach(element => element.addEventListener('keyup', checkBoth))
    }

    addCheckKeyupListeners([password1, password2, email]);

    checkBoth();
}
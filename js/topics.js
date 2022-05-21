window.onload = () => {

    const input = document.getElementById('text');
    const addButton = document.getElementById('add');

    const emptyInputsHandler = () => {

        if(input.value === '' || input.value.length > 255){
            addButton.disabled = true;
        } else {
            addButton.disabled = false;
        }
    }

    input.addEventListener('keyup', emptyInputsHandler);

    addButton.disabled = true;
}
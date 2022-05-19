window.onload = () => {

    const heading = document.getElementById('heading');

    const addNoteButton = document.getElementById('addNote');

    const resultArea = document.getElementById('resultArea');

    const emptyInputsHandler = () => {
        if (resultArea.classList.contains('text-success')) {
            resultArea.classList.remove('text-success');
            resultArea.classList.add('text-danger');
            resultArea.innerText = '';
        }
        if(heading.value === '' ){
            resultArea.innerText = 'You need to add heading';
            addNoteButton.disabled = true;
        } else {
            resultArea.innerText = '';
            addNoteButton.disabled = false;
        }

    }

    heading.addEventListener('keyup', emptyInputsHandler);

    addNoteButton.disabled = true;
}
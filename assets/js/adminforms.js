const checkboxes = document.getElementsByClassName('onoffswitch-checkbox');
// eslint-disable-next-line no-undef,no-restricted-syntax
for (checkbox of checkboxes) {
    // eslint-disable-next-line no-undef
    checkbox.addEventListener('change', (event) => {
        event.target.form.submit();
    });
}

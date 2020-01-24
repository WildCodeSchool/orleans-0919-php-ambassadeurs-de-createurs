let checkboxes = document.getElementsByClassName('onoffswitch-checkbox');
for(checkbox of checkboxes) {
    checkbox.addEventListener('change', function(event) {
        event.target.form.submit();
    });
};

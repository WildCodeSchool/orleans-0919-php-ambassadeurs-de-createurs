// Get the modal
const modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
// eslint-disable-next-line no-unused-vars,no-undef
const img = $('.myImg');
// eslint-disable-next-line no-undef
const modalImg = $('#img01');
// eslint-disable-next-line no-undef,func-names
$('.myImg').click(function () {
    modal.style.display = 'block';
    const newSrc = this.src;
    modalImg.attr('src', newSrc);
});

// Get the <span> element that closes the modal
const span = document.getElementsByClassName('close')[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = 'none';
};

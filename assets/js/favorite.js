const axios = require('axios');

function onClickBtnLike(event) {
    event.preventDefault();

    console.log(this.querySelector('.fa-star'));

    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('.fa-star');


    axios.get(url)
        .then(function (response) {
            console.log(response);
            console.log(response.data);

            if (response.status === 403) {
                window.alert("Vous ne pouvez pas ajouter en favoris si vous n'êtes pas connecté !");
            } else {
                spanCount.textContent = response.data.favorites;

                if (icone.dataset.prefix === 'far') {
                    icone.dataset.prefix = 'fas';
                } else {
                    icone.dataset.prefix = 'far';
                }
            }
        }).catch(function (error) {
            console.log(error);
        });
}

document.querySelectorAll('a.js-like').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike);
});

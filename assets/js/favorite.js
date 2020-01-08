const axios = require('axios');

function onClickBtnLike(event) {
    event.preventDefault();

    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('.fa-star');


    axios.get(url)
        .then((response) => {
            if (response.status === 403) {
                // eslint-disable-next-line no-alert
                window.alert("Vous ne pouvez pas ajouter en favoris si vous n'êtes pas connecté !");
            } else {
                spanCount.textContent = response.data.favorites;

                if (icone.dataset.prefix === 'far') {
                    icone.dataset.prefix = 'fas';
                } else {
                    icone.dataset.prefix = 'far';
                }
            }
            // eslint-disable-next-line no-unused-vars
        }).catch((error) => {
        });
}

document.querySelectorAll('a.js-like').forEach((link) => {
    link.addEventListener('click', onClickBtnLike);
});

document.addEventListener('DOMContentLoaded', () => {
    const sliders = document.querySelectorAll('ul.dishes-slider');
    const buttons = document.querySelectorAll('li.item__category');
    const hidden = 'hidden-slider';

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', function() {
            for (let j = 0; j < sliders.length; j++) {
                if (i === j) {
                    sliders[j].classList.remove(hidden);
                } else {
                    sliders[j].classList.add(hidden);
                }
            }
        });
    }
});

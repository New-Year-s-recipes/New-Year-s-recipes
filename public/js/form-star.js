document.addEventListener('DOMContentLoaded', () => {
    // Функция для обновления закрашенных звезд
    function updateStars(rating) {
        // Удаляем класс 'checked' у всех меток
        document.querySelectorAll('.appointment-label-radio').forEach((label) => {
            label.classList.remove('checked');
        });

        // Добавляем класс 'checked' к меткам, соответствующим текущему рейтингу
        for (let i = 1; i <= rating; i++) {
            const label = document.querySelector(`#star${i}`).nextElementSibling;
            if (label) label.classList.add('checked');
        }
    }

    // Обновляем звезды при загрузке страницы, если пользователь уже оставил оценку
    const checkedRadio = document.querySelector('.appointment-radio:checked');
    if (checkedRadio) {
        updateStars(checkedRadio.value);
    }

    // Добавляем обработчик событий для изменения оценки
    document.querySelectorAll('.appointment-radio').forEach((radio) => {
        radio.addEventListener('change', (event) => {
            const rating = event.target.value;
            console.log(`Вы оценили на ${rating} звезд`);
            updateStars(rating);
        });
    });
});

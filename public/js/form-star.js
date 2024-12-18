document.querySelectorAll('.appointment-radio').forEach((radio) => {
    radio.addEventListener('change', (event) => {
        const rating = event.target.value;
        console.log(`Вы оценили блюдо на ${rating} звезд`);
        // Удаляем класс 'checked' у всех меток
        document.querySelectorAll('.appointment-label-radio').forEach((label) => {
            label.classList.remove('checked');
        });
        // Добавляем класс 'checked' к меткам, которые должны быть активными
        for (let i = 1; i <= rating; i++) {
            document.querySelector(`#star${i}`).nextElementSibling.classList.add('checked');
        }
    });
});

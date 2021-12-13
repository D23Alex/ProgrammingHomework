class mainDisplay {
    constructor() {
        this.obj = main_window;
        this.lastDay = null;
        this.message = 'Кажется, трат у Вас нет. Экономите? Так держать!';

        let div, h2;
        div = document.createElement('div');
        h2 = document.createElement('h2');
        h2.textContent = 'Мои расходы';
        div.appendChild(h2);
        this.obj.appendChild(div);
    }
    createNewDay(day, month, year) {
        let new_day = new oneDay(day, month, year, this);
        this.obj.appendChild(new_day.obj);
        this.lastDay = new_day;
    }
}
class oneDay {
    constructor(day,month, year, display) {
        this.day = day;
        this.year = year;
        this.month = parseInt(month);
        this.months = ['января', 'февраля', 'марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря'];


        this.obj = document.createElement('div');
        let str_made = this.day + ' ' + this.months[this.month];
        if (this.year != SETTINGS_YEAR)
            str_made += ' ' + this.year + ' г.'
        this.obj.textContent = str_made;

        this.display = display;
    }


}
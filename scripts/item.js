class Item {

    constructor(price, title, description, amount, price_per_one, measure, category, user, uploaded, display) {
        this.price = price;
        this.title = title;
        this.description = description;
        this.amount = amount;
        this.price_per_one = price_per_one;
        this.measure = measure;
        this.category = category;
        this.user = user;
        this.uploaded = uploaded;
        this.obj = null;
        this.display = display;
        this.day = this.uploaded[8] + this.uploaded[9];
        this.year = this.uploaded[0] + this.uploaded[1] + this.uploaded[2] +this.uploaded[3];
        this.month = this.uploaded[5] + this.uploaded[6];
        this.categories = ['Разное', 'Еда', 'Развлечение', 'Здоровье'];

    }

    createItem() {
        if (this.display.lastDay == null || this.display.lastDay != this.day) {
            this.display.createNewDay(this.day, this.month, this.year);
        }
        // теперь объект нужного дня существует
        let img, div, h3;
        let new_obj = document.createElement('div');
        new_obj.classList.add('item');

        div = document.createElement('div');
        div.classList.add('item-category');
        h3 = document.createElement('h2');
        h3.textContent = this.categories[this.category - 1];
        div.appendChild(h3);
        new_obj.appendChild(div);

        div = document.createElement('div');
        div.classList.add('item-picture');
        img = document.createElement('img');
        img.src = '../images/' + this.category + '.jpg';
        div.appendChild(img);
        new_obj.appendChild(div);

        div = document.createElement('div');
        div.classList.add('item-price');
        div.textContent = this.price;
        new_obj.appendChild(div);

        div = document.createElement('div');
        div.classList.add('item-title');
        div.textContent = this.title;
        new_obj.appendChild(div);



        // осталось лишь добваить new_obj
        this.obj = new_obj;
        this.display.lastDay.obj.appendChild(new_obj);

    }


}
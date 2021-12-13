const AJAXLoader = (function () {
    function dataLoaded() {
        if (this.readyState == 4)
            if (this.status == 200)
                this.success(this.responseText);
            else
                this.error(this.statusText);
    }
    function AJAXLoader() {
        this.ajax = new XMLHttpRequest();
        this.ajax.addEventListener('readystatechange', dataLoaded);
    }
    Object.defineProperty(AJAXLoader, 'GET', {value: 'GET', writable: false});
    Object.defineProperty(AJAXLoader, 'POST', {value: 'POST', writable: false});
    AJAXLoader.prototype.defaultErrorHandler = function(errorText) {
        window.alert(errorText);
    };
    AJAXLoader.prototype.load = function (url, success, error) {
        this.ajax.success = success;
        this.ajax.error = error || this.defaultErrorHandler;
        this.ajax.open(AJAXLoader.GET, url, true);
        this.ajax.send();
    };
    AJAXLoader.prototype.loadPOST = function (url, data, success, error) {
        this.ajax.success = success;
        this.ajax.error = error || this.defaultErrorHandler;
        this.ajax.open(AJAXLoader.POST, url, true);
        this.ajax.send(data);
    };
    AJAXLoader.loadHTML = function (url, el) {
        if (typeof el == 'string')
            el = document.getElementById(el);
        const ajax = new AJAXLoader();
        ajax.load(url, (html) => {
            el.innerHTML = html;
        });
    };
    return AJAXLoader;
})();

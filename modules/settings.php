<?php
namespace Settings {
    const SITE_NAME = 'КОНТРОЛЬ РАСХОДОВ';
    const IMAGE_PATH = '/images/';

    const DB_HOST = 'localhost';
    const DB_NAME = 'finance';
    const DB_USERNAME = 'root';
    const DB_PASSWORD = '';

    const RECORDS_ON_PAGE = 5;

    const GET_PARAMS = ['filter', 'from', 'to', 'pricefrom', 'priceto', 'sortby', 'sortreverse', 'page'];
    const GET_PARAMS_ADVANCED = ['filter', 'from', 'to', 'pricefrom', 'priceto', 'sortby', 'sortreverse', 'page', 'action'];

    const NO_DATA_FOUND_PHRASE = 'Кажется, у вас нет трат, соответствующих указанным условиям фильтрации. Экономите? Так держать!';
}
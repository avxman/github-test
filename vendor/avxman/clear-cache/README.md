# Модуль очистки кэша laravel >=8
#### Очистка указанного кэша в ларавел

## Установка модуля с помощью composer
```dotenv
composer require avxman/clear-cache
```

## Настройка модуля
После установки модуля не забываем запустить команду artisan
`php artisan vendor:publish --tag="avxman-clear-cache-config"` - добавляем
конфигурационный файл в систему

### Команды artisan
- Выгружаем конфигурационный файл
```dotenv
php artisan vendor:publish --tag="avxman-clear-cache-config"
```

## Методы
### Дополнительные (очерёдность вызова метода - первичная)
- **`setEnabled(bool $enabled = true)`** - вкл./откл. работу очистки кэша
- **`setLaravelLocalization(bool $enabled = false)`** - вкл./откл. очистку роута при использовании модуля mcamara/laravel-localization
### Вывод (очерёдность вызова метода - вторичная)
- **`cache()`** - очистка кэша для устройств
- **`config()`** - очистка конфигурационных данных
- **`route()`** - очистка данных роутов
- **`view()`** - очистка шаблонов
- **`all()`** - очистка всех кэшов
### Вывод (очерёдность вызова метода - последняя)
- **`getMessage()`** - результат при очистки кэша(ов)

### Примеры получения результатов
```injectablephp

use Avxman\ClearCache\Facades\ClearCacheFacade;

BreadcrumbFacade::cache();
BreadcrumbFacade::config();
BreadcrumbFacade::route();
BreadcrumbFacade::view();
BreadcrumbFacade::all();
BreadcrumbFacade::config()->route();
BreadcrumbFacade::route()->view()->config();
// Получить сообщение об очистке
BreadcrumbFacade::getMessage(); // возвращает string[]
// Очистить кэш(ы) и получить сообщение об очистке кэша(ов)
BreadcrumbFacade::cache()->getMessage(); // возвращает string[]
BreadcrumbFacade::config()->route()->getMessage(); // возвращает string[]
BreadcrumbFacade::all()->getMessage(); // возвращает string[]


```
Вызов во views
```injectablephp
{!! \Avxman\ClearCache\Facades\ClearCacheFacade::config() !!}
//Получить сообщение об очистке, возвращает string[]
{!! \Avxman\ClearCache\Facades\ClearCacheFacade::getMessage() !!}
// Очистить кэш(ы) и получить сообщение об очистке кэша(ов), возвращает string[]
{!! \Avxman\ClearCache\Facades\ClearCacheFacade::config()->getMessage() !!}
```

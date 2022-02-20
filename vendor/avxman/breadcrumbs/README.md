# Модуль хлебных крошек laravel >= 8.0
#### Работа с хлебными крошками на сайте. Вывод и сохранение хлебных хрошек.

## Установка модуля с помощью composer
```dotenv
composer require avxman/breadcrumbs
```

## Настройка модуля
После установки модуля не забываем объязательно запустить команды artisan
`php artisan vendor:publish --tag="avxman-breadcrumbs-migrate"` и после `php artisan migrate`.
Это установит таблицу хлебных крошек для получения и сохранения данных.

### Команды artisan
- Выгружаем все файлы
```dotenv
php artisan vendor:publish --tag="avxman-breadcrumbs-all"
```
- Выгружаем миграционные файлы
```dotenv
php artisan vendor:publish --tag="avxman-breadcrumbs-migrate"
```
- Выгружаем файлы моделек
```dotenv
php artisan vendor:publish --tag="avxman-breadcrumbs-model"
```
- Выгружаем шаблонные файлы
```dotenv
php artisan vendor:publish --tag="avxman-breadcrumbs-view"
```

## Методы
### Инициализация или сохранение хлебных крошек (очерёдность вызова метода - первичная)
- **`init()`** - инициализация хлебных крошек по выборке модели и id
- **`save()`** - сохраняем список ссылок хлебных крошек определённой модельки и id (после вызова остальные методы не вызываются)
### Дополнительные (очерёдность вызова метода - второстепенная)
- **`all()`** - получаем все ссылки хлебных крошек инициализированной модельки
- **`exceptLast()`** - получаем все родительские ссылки за исключением домашней
- **`onlyLast()`** - получаем последнюю ссылку
- **`setView`** - перезаписываем шаблон вывода хлебных крошек
- **`setAddHome()`** - выводить домашнюю ссылку
### Вывод (очерёдность вызова метода - последняя)
- **`toCollection()`** - получаем результат в виде коллекции
- **`toArray()`** - получаем результат в виде массива
- **`toJson()`** - получаем результат в виде json
- **`toHtml()`** - получаем результат в виде html


### Примеры получения результатов
```injectablephp
use App\Models\User;
use Avxman\Breadcrumb\Facades\BreadcrumbFacade;

$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->setAddHome(false)->all()->toHtml();
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->all()->toHtml();
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->onlyLast()->toHtml();
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->exceptLast()->toHtml();
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->toCollection();
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->toArray();
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->toJson();
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->toHtml();
BreadcrumbFacade::save(
    collect()->push(
        ['url'=>'https://google.ua/', 'name'=>'Google'],
        ['url'=>null, 'name'=>'NEW']
    ),
    User::first());
$breadcrumbs = BreadcrumbFacade::init(User::class, 1)->toHtml();
```
Вызов во views
```injectablephp
{!! BreadcrumbFacade::init(User::class, 1)->all()->toHtml() !!}
{!! BreadcrumbFacade::init(User::class, 1)->toJson(); !!}
{!! BreadcrumbFacade::init(User::class, 1)->toHtml(); !!}
{{ BreadcrumbFacade::save(
    collect()->push(
        ['url'=>'https://google.ua/', 'name'=>'Google'],
        ['url'=>null, 'name'=>'NEW']
    ),
    User::first());
}}
```

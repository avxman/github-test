<?php

namespace Avxman\ClearCache\Classes;

use Illuminate\Support\Facades\Artisan;

class ClearCacheClass
{

    /**
     * Список конфигураций библиотеки
     * @var array $config = []
    */
    protected array $config = [];

    /**
     * Вкл./Откл. работу библиотеки
     * @var bool $enabled = true
    */
    protected bool $enabled = true;

    /**
     * Проверка на использование библиотеки mcamara/laravel-localization
     * @var bool $is_laravel_localization = false
    */
    protected bool $is_laravel_localization = false;

    /**
     * Сохранение сообщений
     * @var array $message = []
    */
    protected array $message = [];

    /**
     * Записать сообщение
     * @return self
    */
    protected function setMessage() : self{
        if(!empty($message = Artisan::output())) $this->message[] = $message;
        return $this;
    }

    /**
     * Конструктор
    */
    public function __construct(){

        $this->config = Config()->has('clearcache') ? Config()->get('clearcache') : [];
        $this->enabled = $this->config['enabled']??false;

    }

    /**
     * Проверка на существование динамического метода
     * @param string $name
     * @param array $arguments
     */
    public function __call(string $name, array $arguments)
    {
        if(method_exists($this, $name)) $this->{$name}($arguments);
    }

    /**
     * Перезапись вкл./откл. работы библиотеки
     * @param bool $enabled = true
     * @return ClearCacheClass
     */
    public function setEnabled(bool $enabled = true) : self{
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * Перезапись проверки на использование библиотеки mcamara/laravel-localization
     * @param bool $enabled = false
     * @return ClearCacheClass
     */
    public function setLaravelLocalization(bool $enabled = false) : self{
        $this->is_laravel_localization = $enabled;
        return $this;
    }

    /**
     * Получаем все сообщения
     * @return array
    */
    public function getMessage() : array{
        return $this->message;
    }

    /**
     * Очистка кэша устройства
     * @return self
    */
    public function cache() : self{
        if($this->enabled) {
            Artisan::call('cache:clear');
            $this->setMessage();
        }
        return $this;
    }

    /**
     * Очистка конфигураций приложения
     * @return self
     */
    public function config() : self{
        if($this->enabled) {
            Artisan::call('config:clear');
            $this->setMessage();
            Artisan::call('config:cache');
        }
        return $this;
    }

    /**
     * Очистка маршрутов приложения
     * @return self
     */
    public function route() : self{
        if($this->enabled) {
            if ($this->is_laravel_localization) {
                Artisan::call('route:trans:clear');
                $this->setMessage();
                Artisan::call('route:trans:cache');
            } else {
                Artisan::call('route:clear');
                $this->setMessage();
                Artisan::call('route:cache');
            }
        }
        return $this;
    }

    /**
     * Очистка шаблонов приложения
     * @return self
     */
    public function view() : self{
        if($this->enabled) {
            Artisan::call('view:clear');
            $this->setMessage();
            Artisan::call('view:cache');
        }
        return $this;
    }

    /**
     * Очистка всех кэшов приложения
     * @return self
     */
    public function all() : self{
        $this->cache()->config()->route()->view();
        return $this;
    }

}

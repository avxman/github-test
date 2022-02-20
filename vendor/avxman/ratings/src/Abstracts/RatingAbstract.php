<?php

namespace Avxman\Rating\Abstracts;

use Avxman\Rating\Traits\RatingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class RatingAbstract
{
    /**
     * Подключаем свойства
    */
    use RatingTrait;

    /**
     * Инициализация свойств
     * @return void
    */
    protected function initParams() : void{
        $config = collect(config()->get('rating'));
        $this->enabled = $config->get('enabled');
        $this->view = $config->get('views');
        $this->except_model = $config->get('except_model');
        $this->type_list = array_merge($this->type_list, $config->get('type_list'));
        $this->convertType($config->get('type'));
        $this->modelName = $config->get('model')['rating'];
        $this->modelUserName = $config->get('model')['rating_user'];
        $this->model = null;
        $this->isError = false;
        $this->items = collect();
        $this->user_id = !Auth()->guest() ? Auth()->id() : 0;
        $this->ip = request()->ip();
        $this->user_agent = request()->userAgent();
        $this->result = collect();
        foreach ($this->setParams as $k=>$param) $this->setParams[$k] = false;
    }

    /**
     * Конвертация типа и количества звезд из общего типа
     * @param string $type
     * @return void
    */
    protected function convertType(string $type) : void{
        $list = collect($this->type_list);
        if($list->has($type)){
            $this->type = $type;
            $this->star_count = $list->get($type);
        }
        else $this->isError = true;
    }

    /**
     * Конвертация рейтинга в HTML код
     * @return string
    */
    protected function convertToHtml() : string{
        if(!$this->enabled || $this->isError) return "";
        $viewItems = view($this->view['list']);
        $viewItem = view($this->view['item']);
        collect($this->items->get('items'))->each(function ($item) use ($viewItem){
            if($item) $this->result->push($viewItem->with($item->toArray())->render());
        });
        return $viewItems->with(['model'=>$this->items->get('model'), 'items'=>$this->result->join('')])->render();
    }

    /**
     * Обрабатываем свойства при инициализации рейтинга
     * @return void
    */
    protected function getData() : void{
        if(!$this->setParams['enabled']) $this->enabled = (bool)$this->model->enabled;
        if(!$this->setParams['type']) $this->type = $this->model->type;
        $this->star_count = collect($this->type_list)->get($this->type);
        $this->model->grade = $this->convertToAVG();
        $this->convertToCollection();
    }

    /**
     * Обрабатываем данные в коллекцию рейтинга
     * @return void
    */
    protected function convertToCollection() : void{
        if($this->isError || !$this->model->enabled) return;
        $items = collect();
        for($i = 1; $i<$this->star_count+1; $i++){
            $items->put($i, collect(['star'=>$i, 'data_id'=>$this->model->id, 'rating'=>$this->model->grade, 'selected'=>$i==round(ceil($this->model->grade))]));
        }
        $this->model->stars = $this->star_count;
        $this->model->type = $this->type;
        $this->model->enabled = (int)$this->enabled;
        $this->items->put('items', $items);
        $this->items->put('model', $this->model);
    }

    /**
     * Конвертируем общую оценку из количества оценок делима на количество проголосовавших
     * @return float
    */
    protected function convertToAVG() : float{
        $r = $this->model->rating < 1 ? 0 : round($this->model->rating / $this->model->voted, 1);
        return $r<1 ? 1 : ($r >= $this->star_count ? $this->star_count : $r);
    }

    /**
     * Валидация входящих данных во время сохранение рейтинга
    */
    protected function isValidDataSave(Collection $request) : bool|Model{
        return $request->has('model')
            && $request->has('model_id')
            && $request->has('rating')
            && (int)$request->get('rating')!==0
            && (int)$request->get('model_id') > 0
            && is_string($request->get('model'));
    }

    /**
     * Преобразовываем данные для записи в таблицу рейтинг пользователя
     * @param array $data
     * @return array
    */
    protected function convertDataRatingUser(array $data) : array{
        return [
            'rating_id'=>$data['id'],
            'user_id'=>$data['user'],
            'status'=>$data['rating'],
            'browser'=>$data['user_agent']
        ];
    }

    /**
     * Конвертация из типа во звезды при сохранении рейтинга
     * @param int $rating
     * @return int
    */
    protected function convertRating(int $rating) : int{
        if($this->star_count === 2 && $this->star_count<=$rating)
            return 1;
        return $this->star_count<=$rating?$this->star_count:$rating;
    }

    /**
     * Рейтинг пользователя найден
     * @param Model|null $model
     * @return bool
    */
    protected function hasRatingUserModel(Model|null $model) : bool{
        return (bool)$this->modelUserName::where('rating_id', $model->id)->where(function ($where){
            $where->where('browser', $this->user_agent)
                ->orWhere('user_id', $this->user_id);
        })->first();
    }

    /**
     * Сохраняем рейтинг
     * @param array $data
     * @return Model|null
    */
    protected function createRating(array $data) : Model|null{
        $model = null;
        DB::transaction(function () use ($data, &$model){
            $model = $this->modelName::create($data);
        });
        return $model;
    }

    /**
     * Сохраняем рейтинг пользователя
     * @param array $data
     * @return bool
    */
    protected function createRatingUser(array $data) : bool{
        $status = false;
        DB::transaction(function () use ($data, &$status){
            $status = (bool)$this->modelUserName::create($data);
        });
        return $status;
    }

    /**
     * Конструктор
    */
    public function __construct()
    {
        $this->initParams();
    }

}

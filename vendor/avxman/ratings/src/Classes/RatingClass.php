<?php

namespace Avxman\Rating\Classes;

use Avxman\Rating\Abstracts\RatingAbstract;
use Avxman\Rating\Interfaces\RatingAdminInterface;
use Avxman\Rating\Interfaces\RatingInterface;
use Avxman\Rating\Models\RatingModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as Collections;

class RatingClass extends RatingAbstract implements RatingInterface, RatingAdminInterface
{

    // Первый уровень
    public function reset() : self{
        $this->initParams();
        return $this;
    }

    public function setEnabled(bool $isEnabled = true) : self{
        $this->enabled = $isEnabled;
        $this->setParams['enabled'] = true;
        return $this;
    }

    public function setView(string $list, string $item) : self{
        $this->view = [
            'list'=>$list,
            'item'=>$item
        ];
        return $this;
    }

    public function setExceptModel(array $except) : self{
        $this->except_model = array_merge($this->except_model, $except);
        return $this;
    }

    public function setType(string $type = 'like') : self{
        if(($list = collect($this->type_list))->has($type)) {
            $this->type = $type;
            $this->star_count = $list->get($type);
            $this->setParams['type'] = true;
        }
        return $this;
    }

    public function setModelName(string $name) : self{
        if(class_exists($name)) $this->modelName = $name;
        return $this;
    }

    public function setModelUserName(string $name) : self{
        if(class_exists($name)) $this->modelUserName = $name;
        return $this;
    }

    public function setIp(string $ip) : self{
        if(filter_var($ip, FILTER_VALIDATE_IP) !== false) $this->ip = $ip;
        return $this;
    }

    public function setUserAgent(string $user_agent) : self{
        $this->user_agent = $user_agent;
        return $this;
    }

    // Второй уровень
    public function getOne(Model|null $model) : self{
        if(!$model) $this->isError = true;
        elseif(!collect($this->except_model)->contains($model::class)) {
            $this->model = $model->isRelation('rating')
                ? $model->getRelation('rating')
                : RatingModel::where('model_class', $model::class)
                    ->where('model_id', $model->id)
                    ->first();
            if(!$this->model || (!$this->setParams['enabled'] && !$this->model->enabled) || ($this->setParams['enabled'] && !$this->enabled)) $this->isError = true;
            else {
                $this->getData();
            }
        }
        else $this->isError = true;
        return $this;
    }

    public function getMany(Collections|null $models, string $type = 'toHtml') : Collections{
        if ($models && $models->count() && method_exists(self::class, $type)){
            $model_first = $models->first();
            if(collect($this->except_model)->contains($model_first::class)){
                $this->isError = true;
                return $models;
            }
            if(!$model_first->isRelation('rating')){
                $ids = $models->pluck('id');
                $rating = RatingModel::where('model_class', $model_first::class)
                    ->whereIn('model_id', $ids->toArray())
                    ->get()->keyBy('id');
                unset($ids);
            }
            else $rating = null;
            unset($model_first);
            $models->map(function ($self) use ($type, $rating){
                $this->model = $self->isRelation('rating') ? $self->getRelation('rating') : $rating->get($self->id);
                if(!$this->model || (!$this->setParams['enabled'] && !$this->model->enabled) || ($this->setParams['enabled'] && !$this->enabled)) $this->isError = true;
                else {
                    $this->getData();
                    $self->getRating = $this->{$type}();
                }
            });
            $this->reset();
        }
        else $this->isError = true;
        return $models;
    }

    public function save(Collection|null $collection = null, bool $isPermission = true) : bool{
        $request = $collection?:collect(request()->all());
        if(!$this->isValidDataSave($request) || !$this->enabled) return false;
        $model_class = $request->get('model');
        $id = $request->get('model_id');
        $model = $this->modelName::where('model_class', $model_class)->where('model_id', $id)->first();
        $user = $this->user_id?:null;
        $type = $this->type = $request->get('type')??$this->type;
        $this->convertType($type);
        $rating = $this->convertRating( $request->get('rating'));
        $data = $this->convertDataRatingUser(['id'=>$model->id??0, 'user'=>$user, 'rating'=>$rating, 'user_agent'=>$this->user_agent]);
        if($model){
            $model->rating += $rating;
            $model->voted += 1;
            return !$this->hasRatingUserModel($model) && $this->createRatingUser($data) && $model->save();
        }
        if(!$isPermission) return false;
        $model = $this->createRating(['model_id'=>$id, 'model_class'=>$model_class, 'enabled'=>1, 'rating'=>$rating, 'voted'=>1, 'type'=>$type]);
        if(!$model) return false;
        $data = array_merge($data, ['rating_id'=>$model->id]);
        return $this->createRatingUser($data);
    }

    public function isError() : bool{
        return $this->isError;
    }

    // Третий уровень при одиночном рейтинге
    public function toCollection() : Collection{
        return $this->items;
    }

    public function toArray() : array{
        return $this->items->toArray();
    }

    public function toJson() : string{
        return $this->items->toJson();
    }

    public function toHtml() : string{
        return $this->convertToHtml();
    }


}

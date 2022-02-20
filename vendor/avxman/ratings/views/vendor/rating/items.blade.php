@if($model->enabled)
    <div class="star-item" data-stars="{{$model->stars}}" data-type="{{$model->type}}" data-grade="{{$model->grade}}" data-rating="{{$model->rating}}" data-count="{{$model->voted}}" data-id="{{$model->id}}" data-model="{{$model->model_class}}" data-model-id="{{$model->model_id}}">
        {!! $items !!}
    </div>
@endif

{{--$items - вывод списка рейтинга--}}
{{--$model->stars - количество звёзд--}}
{{--$model->id - ID рейтинга в общем списке--}}
{{--$model->model_id - ID привязанной модели --}}
{{--$model->model_class - привязанная модель к рейтингу--}}
{{--$model->enabled - статус Вкл./Откл. рейтинг для данной модели с таким ID --}}
{{--$model->rating - общяя оценка рейтинга--}}
{{--$model->type - тип оценки--}}
{{--$model->voted - количество проставленных оценок к рейтингу--}}
{{--$model->grade - общий рейтинг с соотношением проголосовавших --}}

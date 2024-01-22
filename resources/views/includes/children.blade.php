@foreach($obj->children->sortBy('name') as $obj)
    <div class="children" value="{{ $obj->id }}">
       <div class="checkbox">
            <label>
                <input type="checkbox" value="{{ $obj->id }}" name="selected[]" >
                {{ $obj->name }}  <a href="{{ route($model.'.edit',[$url => $obj->id]) }}"><i class="fa fa-pencil"></i> Edit</a>
                <a href="{{ config('app.url') }}/products/{{ $obj->slug }}">
                <i class="fa fa-pencil"></i> Link</a> 
            </label>
        </div>  
    @include('includes.children',['obj'=>$obj])
    </div>
@endforeach
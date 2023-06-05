@extends('layouts.main')

@section('content')

<div id="wrap">
    @if(session()->has('error'))
        <span style="color: red;">{{ session()->get('error') }}</span>
    @endif
    <form method="POST" action="{{ route('update.category') }}" enctype="multipart/form-data">
        @csrf
        <div class="clear" style="height:5px;"></div>
        <div id="wrap2">
            <h1>Edit Category</h1>
            <input type="hidden" name="id" value="{{$category->id}}">
            <br>
            <div class="form-raw">
                <div class="form-name">Category Name</div>
                <div class="form-txtfld">
                    <input type="text" name="name" value="{{$category->name}}" required>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>    
        <div class="form-raw">
            <div class="form-name">Active</div>
            <div class="form-txtfld">
                <input type="checkbox" name="status" value="1" {{ $category->status == "1" ? "checked" : "" }}>
            </div>      
            <div class="clear"></div>
        </div>
                
        <div class="form-raw">
            <div class="form-name">&nbsp;</div>
            <div class="form-txtfld" style="width:290px;">
                <input class="btn" type="submit" name="submit">
            </div>
        </div>
    </form>
</div>
<div class="clear">&nbsp;</div>
</div>
@endsection


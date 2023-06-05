@extends('layouts.main')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="wrap">
    <form method="POST" action="{{ route('update.sub_category') }}" enctype="multipart/form-data">
        @csrf
        <div class="clear" style="height:5px;"></div>
        
        <div id="wrap2">
            <h1>Edit Sub Category</h1>
            <br>
            <div class="form-raw">
                <div class="form-name">Select Category</div>
                <div class="form-txtfld">
                    <input type="hidden" name="id" value="{{$sub_category->id}}" required>
                    <select name="category" required>
                        <option value="">Select Option</option>
                        @foreach($category as $key => $value)
                        <option value="{{$value->id}}" {{ $value->id == $sub_category->category_id ? "Selected" : "" }}>{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-raw">
                <div class="form-name">Add Sub Category</div>
                <div class="form-txtfld">
                    <input type="text" name="name" value="{{$sub_category->name}}" required>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>    
        <div class="form-raw">
            <div class="form-name">Active</div>
            <div class="form-txtfld">
                <input type="checkbox" name="status" value="1" {{ $sub_category->status == "1" ? "checked" : "" }}>
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

@endsection

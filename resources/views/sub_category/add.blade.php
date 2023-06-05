@extends('layouts.main')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="wrap">
    <form method="POST" action="{{ route('insert.sub_category') }}" enctype="multipart/form-data">
        @csrf
        <div class="clear" style="height:5px;"></div>
        
        <div id="wrap2">
            <h1>Add Sub Category</h1>
            <br>
            <div class="form-raw">
                <div class="form-name">Select Category</div>
                <div class="form-txtfld">
                    <select name="category" required>
                        <option value="">Select Option</option>
                        @foreach($category as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-raw">
                <div class="form-name">Add Sub Category</div>
                <div class="form-txtfld">
                    <input type="text" name="name" required>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>    
        <div class="form-raw">
            <div class="form-name">Active</div>
            <div class="form-txtfld">
                <input type="checkbox" name="status" value="1">
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

<div id="wrap3">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="admintable">
        <tr>
            <th width="59" align="left" valign="middle">Sr.No.</th>
            <th width="752" align="left" valign="middle">Category Name</th>
            <th width="752" align="left" valign="middle">Sub Category Name</th>
            <th width="77" align="left" valign="middle">Status</th>
            <th width="54" align="left" valign="middle">Edit</th>
            <th width="71" align="left" valign="middle">Remove</th>
        </tr>
        <tbody id="table_body">
            <?php 
            $x = 1;
            foreach($sub_category as $key => $value)
            {
                $name = App\Models\Category::where('id', $value->category_id)->first();
                ?>
                <tr id="{{$value->id}}">
                    <td align="left" valign="top">{{$x}}</td>
                    <td align="left" valign="top">{{$name->name}}</td>
                    <td align="left" valign="top">{{$value->name}}</td>
                    <td align="left" valign="top"><strong>{{ $value->status == "1" ? "Active" : "Disable" }}</strong></td>
                    <td align="left" valign="top"><a href="{{ route('edit.sub_category', ['id'=>$value->id]) }}">Edit</a></td>
                    <td align="center" valign="top"><button class="delete btn" data-id="{{$value->id}}"><img src="{{asset('images/icon-bin.jpg')}}" alt="" width="25" height="25" border="0" align="absmiddle" /></button></td>
                </tr>
                <?php
                $x++;
            }
            ?>
        </tbody>
    </table>
  <div class="clear">&nbsp;</div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>
<script>
        $("#table_body").on("click", ".delete", function(){
            var id = $(this).data("id");
            $.ajax({
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('delete.sub_category') }}",
                data: {id:id},
                success: (data) => {
                    if(data.message)
                    {
                        $("#"+id).hide();
                        $("#table_body").empty();
                        $("#table_body").html(data.html);
                    }
                    alert(data.message);
                }
            });
        });

</script>

@endpush

@extends('layouts.main')

@section('content')
<div id="wrap">
    @if(session()->has('error'))
        <span style="color: red;">{{ session()->get('error') }}</span>
    @endif
    <form method="POST" action="{{ route('insert.category') }}" enctype="multipart/form-data">
        @csrf
        <div class="clear" style="height:5px;"></div>
        <div id="wrap2">
            <h1>Add Category</h1>
            <br>
            <div class="form-raw">
                <div class="form-name">Category Name</div>
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
            <th width="77" align="left" valign="middle">Status</th>
            <th width="54" align="left" valign="middle">Edit</th>
            <th width="71" align="left" valign="middle">Remove</th>
        </tr>
        <tbody id="table_body">
            <?php 
            $x = 1;
            foreach($category as $key => $value)
            {
                ?>
                <tr id="{{$value->id}}">
                    <td align="left" valign="top">{{$x}}</td>
                    <td align="left" valign="top">{{$value->name}}</td>
                    <td align="left" valign="top"><strong>{{ $value->status == "1" ? "Active" : "Disable" }}</strong></td>
                    <td align="left" valign="top"><a href="{{ route('edit.category', ['id'=>$value->id]) }}">Edit</a></td>
                    <td align="center" valign="top"><button class="delete btn" data-id="{{$value->id}}"><img src="{{ asset('images/icon-bin.jpg') }}" alt="" width="25" height="25" border="0" align="absmiddle" /></button></td>
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
            // alert(id);
            $.ajax({
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('delete.category') }}",
                data: {id:id},
                success: (data) => {
                    if(data.status == 401)
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

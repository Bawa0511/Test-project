@extends('layouts.main')

@push('topscripts')
@endpush

@section('content')
<div id="wrap">
    <div class="clear" style="height:5px;"></div>
        <form method="POST" action="{{ route('insert.product') }}" enctype="multipart/form-data">
            @csrf
            <div id="wrap2">
                <h1>Add Product</h1>
                <br>
                @if(session()->has('error'))
                <span style="color: red;">{{ session()->get('error') }}</span>
                @endif
                <div class="form-raw">
                    <div class="form-name">Select Category</div>
                    <div class="form-txtfld">
                        <select name="category" class="category">
                            <option value="">Select Option</option>
                            @foreach($category as $key => $value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="form-raw">
                    <div class="form-name">Select Sub Category</div>
                    <div class="form-txtfld">
                        <select class="js-example-basic-multiple" id="subcategory" name="subcategory[]" multiple="multiple">
                            <option value="">Select</option>
                        </select>
                    </div>
                </div>
                <div class="clear"></div>
        
                <div class="form-raw">
                    <div class="form-name">Product Name</div>
                    <div class="form-txtfld">
                        <input type="text" name="name">
                    </div>
                </div>
        
                <div class="form-name">Product Image</div>
                <div class="form-txtfld">
                    <input type="file" name="image">
                    <div class="form-name"> Image Size ( Width=560px, Height=390px ) (Product page)</div>
                </div>
            </div>

            <div class="form-raw" style="width:100%;">
                <div class="form-name">Short Description</div>
                <div class="form-txtfld">
                    <textarea name="short_description"></textarea>
                </div>
            </div>
            <div class="clear"></div>


            <h1 style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin: 20px 0 0px 0;">Description </h1>
            <br> 
            <div class="form-raw">
                <div class="description-section">
                    <div class="main-description-section" id="description_1">
                        <div class="form-name"> &nbsp;</div> 
                        <div class="form-txtfld">
                            <input type="text" name="title[1]" placeholder="Title">
                        </div>
                        <div class="form-raw">
                            <div class="form-name">&nbsp;</div>
                            <div class="form-txtfld txtfld50">
                                <input type="text" name="heading[1]" placeholder="heading">
                            </div>
                            <div class="form-txtfld txtfld50">
                                <input type="text" name="description[1]" placeholder="desciption">
                            </div>
                            <button type="button" id="1" class="btn des-remove"><img src="{{asset('images/delete.gif')}}" alt=""></button>
                        </div>
                    </div>
                </div>
                
                <div class="form-raw">
                    <div class="form-name">&nbsp;</div>
                    <div class="form-txtfld" style="width: 320px; text-align: right;">
                        <button type="button" id="des-add-btn" class="btn">Add More +</button>
                    </div>
                </div>
                <div class="clear"></div>

                <h1 style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin: 20px 0 0px 0;">Features</h1>
                <br>  
                <div class="form-raw" style="width:100%;">
                    <div class="form-name">Content</div>
                    <div class="form-txtfld" style="width:780px;">
                        <textarea name="content" style="width:100%; min-height:500px;" id="editor"></textarea>
                    </div>
                </div>
                <div class="clear"></div>
    
                <h1 style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin: 20px 0 0px 0;">Upload PDF </h1>
                <br>
                <div class="pdf-section">
                    <div class="main-pdf-section" id="pdf_1">
                        <div class="form-raw">
                            <div class="form-name">&nbsp;</div>
                            <div class="form-txtfld txtfld50">
                                <input type="text" name="pdf_heading[1]" placeholder="PDF heading">
                            </div>
                            <div class="form-txtfld txtfld50">
                                <input type="file" name="pdf_file[1]" placeholder="desciption">
                            </div>
                            <button type="button" id="1" class="btn pdf-remove"><img src="{{asset('images/delete.gif')}}" alt=""></button>
                        </div>
                    </div>
                </div>
                
                <div class="form-raw">
                    <div class="form-name">&nbsp;</div>
                    <div class="form-txtfld" style="width: 320px; text-align: right;">
                        <button type="button" id="add_pdf" class="btn">Add More +</button>
                    </div>
                </div>
                <div class="clear"></div>

                <div class="form-raw">
                    <div class="form-name">Active</div>
                    <div class="form-txtfld">
                        <input type="checkbox" value="1" name="status">
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>

                <div class="form-raw">
                    <div class="form-name">&nbsp;</div>
                    <div class="form-txtfld">
                        <input class="btn" type="submit" name="submit">
                    </div>
                </div>
            </div>
            <div class="clear">&nbsp;</div>
        </form>
    </div>
    <div id="wrap2">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="admintable">
            <tr>
                <th width="53" align="left" valign="middle">Sr.No.</th>
                <th width="153" align="left" valign="middle">Select Category</th>
                <th width="71" align="left" valign="middle"> Select Sub Category</th>
                <th width="71" align="left" valign="middle"> Product Name</th>
                
                <th width="408" align="left" valign="middle">Short Description</th>
                <th width=" " align="left" valign="middle">Full Description</th>
                <th width="49" align="left" valign="middle">Status</th>
                
                <th width="49" align="left" valign="middle">Edit</th>
                <th width="61" align="left" valign="middle">Remove</th>
            </tr>
            <tbody id="table_body">
                <?php 
                $x = 1;
                foreach($product as $key => $value)
                {
                    if($value->cat_id){
                        $name = App\Models\Category::where('id', $value->cat_id)->first();
                        if($name){
                        $name_cat = $name->name;
                        } else {
                            $name_cat = "-";
                        }
                    } else {
                        $name_cat = "-";
                    }
                    ?>
                    <tr id="{{$value->id}}">
                        <td align="left" valign="top">{{$x}}</td>
                        <td align="left" valign="top">{{$name_cat}}</td>
                        <td align="left" valign="top">
                            <?php
                            if($value->sub_cat_id){
                                $sub_id = explode(", ",$value->sub_cat_id);
                                $sub_cat = App\Models\SubCategory::whereIn('id', $sub_id)->get();
                                $sub_name = "";
                                foreach($sub_cat as $sub_key => $sub_value)
                                {
                                    $sub_name .= $sub_value->name.", ";
                                }
                                echo rtrim($sub_name, ", ");
                            } else {
                                echo "-";
                            }
                            ?>
                        </td>
                        <td align="left" valign="top">@if($value->product_name){{$value->product_name}}@else-@endif</td>
                        
                        <td align="left" valign="top">@if($value->short_description){{$value->short_description}}@else-@endif</td>
                        <td align="left" valign="top">
                            <?php
                            $desc = App\Models\ProductDescription::where('product_id', $value->id)->get();
                            foreach($desc as $key_desc => $value_desc)
                            {
                                if($value_desc->title || $value_desc->heading || $value_desc->description){
                                $no = $key_desc +1;
                                echo "Description no. ".$no."<br><ul>
                                <li>Title:- ".$value_desc->title."</li>
                                <li>Heading:- ".$value_desc->heading."</li>
                                <li>Description:- ".$value_desc->description."</li>
                            </ul><br>";}
                            }
                            ?>
                            
                        </td>

                        <td align="left" valign="top"><strong>{{ $value->status == "1" ? "Active" : "Disable" }}</strong></td>
                        <td align="left" valign="top"><a href="{{ route('edit.product', ['id'=>$value->id]) }}">Edit</a></td>
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
</div>
@endsection

@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/38.0.1/classic/ckeditor.js"></script>

<style>
    .ck-rounded-corners .ck.ck-editor__main>.ck-editor__editable, .ck.ck-editor__main>.ck-editor__editable.ck-rounded-corners {
        min-height: 200px;
        min-width: 100px;
    }
</style>
<script>
    
        $("#table_body").on("click", ".delete", function(){
            // alert("hello");
            var id = $(this).data("id");
            $.ajax({
                type:'POST',
                url: "{{ route('delete.product') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
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

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });

    jQuery(document).ready(function() {
        jQuery(document).on('change', '.category', function(e) {
            var id = $(this).attr('id')
            // console.log(id, "id");
            let cid = jQuery(this).val();
            jQuery.ajax({
                url: "{{ url('/get-subcategory') }}",
                type: 'POST',
                data: 'cid=' + cid + '&_token={{csrf_token()}}',
                success: function(result) {
                    jQuery('#subcategory').empty().trigger('change');
                    jQuery("#subcategory").html(result)
                }
            });
        });
    });
</script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>


<script>
    var k = 1;
    const src = "{{asset('images/delete.gif')}}";
    $("#des-add-btn").click(function() {
        ++k;
        $(".description-section").append('<div class="main-description-section" id="description_'+k+'"><div class="form-name"> &nbsp;</div><div class="form-txtfld"><input type="text" name="title['+k+']" placeholder="Title"></div><div class="form-raw"><div class="form-name">&nbsp;</div><div class="form-txtfld txtfld50"><input type="text" name="heading['+k+']" placeholder="heading"></div><div class="form-txtfld txtfld50"><input type="text" name="description['+k+']" placeholder="desciption"></div><button type="button" id="'+k+'" class="btn des-remove"><img src="'+src+'" alt=""></button></div></div>');
    });
    $(document).on('click', '.des-remove', function() {
        console.log("hello");
        var k = 'description_'+$(this).attr('id');
        $('#' + k).remove();
    });
</script>

<script>
    var j = 1;
    const src2 = "{{asset('images/delete.gif')}}";
    $("#add_pdf").click(function() {
        ++j;
        $(".pdf-section").append('<div class="main-pdf-section" id="pdf_'+j+'"><div class="form-raw"><div class="form-name">&nbsp;</div><div class="form-txtfld txtfld50"><input type="text" name="pdf_heading['+j+']" placeholder="PDF heading"></div><div class="form-txtfld txtfld50"><input type="file" name="pdf_file['+j+']" placeholder="desciption"></div><button type="button" id="'+j+'" class="btn pdf-remove"><img src="'+src2+'" alt=""></button></div></div>');
    }); 
    $(document).on('click', '.pdf-remove', function() {
        console.log("hello");
        var k = 'pdf_'+$(this).attr('id');
        $('#' + k).remove();
    });
</script>
@endpush

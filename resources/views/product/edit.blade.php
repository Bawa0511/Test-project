@extends('layouts.main')

@push('topscripts')
@endpush

@section('content')
<div id="wrap">
    <div class="clear" style="height:5px;"></div>
        <form method="POST" action="{{ route('update.product') }}" enctype="multipart/form-data">
            @csrf
            <div id="wrap2">
                <h1>Add Product</h1>
                <br>
                <input type="hidden" name="id" value="{{$product->id}}">
                @if(session()->has('error'))
                <span style="color: red;">{{ session()->get('error') }}</span>
                @endif
                <div class="form-raw">
                    <div class="form-name">Select Category</div>
                    <div class="form-txtfld">
                        <select name="category" class="category">
                            <option value="" disabled>Select Option</option>
                            @foreach($category as $key => $value)
                            <option value="{{$value->id}}" {{ $product->cat_id == $value->id ? "selected" : "" }}>{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="form-raw">
                    <div class="form-name">Select Sub Category</div>
                    <div class="form-txtfld">
                        <?php
                        $cat = App\Models\SubCategory::where('category_id', $product->cat_id)->where('status', '1')->get();
                        $sub_id = explode(", ",$product->sub_cat_id);
                        ?>
                        <select class="js-example-basic-multiple" id="subcategory" name="subcategory[]" multiple="multiple">
                        @foreach($cat as $key => $value)  
                        <option value="{{$value->id}}" {{in_array($value->id, $sub_id) ? "selected" : ""}}>{{$value->name}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="clear"></div>
        
                <div class="form-raw">
                    <div class="form-name">Product Name</div>
                    <div class="form-txtfld">
                        <input type="text" name="name" value="{{$product->product_name}}">
                    </div>
                </div>
        
                <div class="form-name">Product Image</div>
                <div class="form-txtfld">
                    <input type="file" name="edit_image">
                    <input type="hidden" name="image" value="{{$product->product_image}}">
                    <div class="form-name"> Image Size ( Width=560px, Height=390px ) (Product page)</div>
                    @if($product->product_image)
                    <img src="{{asset('product_image')}}/{{$product->product_image}}" width="100px" height="100px" alt="This product have no image">
                    @endif
                </div>
            </div>

            <div class="form-raw" style="width:100%;">
                <div class="form-name">Short Description</div>
                <div class="form-txtfld">
                    <textarea name="short_description">{{$product->short_description}}</textarea>
                </div>
            </div>
            <div class="clear"></div>


            <h1 style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin: 20px 0 0px 0;">Description</h1> 
            <br> 
            <div class="form-raw">
                @if(count($product_des) >= 1)
                    <div class="description-section">
                        @foreach($product_des as $key => $value)
                            <div class="main-description-section" id="description_{{$key}}">
                                <div class="form-name"> &nbsp;</div> 
                                <div class="form-txtfld">
                                    <input type="text" name="title[{{$key}}]" value="{{$value->title}}" placeholder="Title">
                                </div>
                                <div class="form-raw">
                                    <div class="form-name">&nbsp;</div>
                                    <div class="form-txtfld txtfld50">
                                        <input type="text" name="heading[{{$key}}]" value="{{$value->heading}}" placeholder="heading">
                                    </div>
                                    <div class="form-txtfld txtfld50">
                                        <input type="text" name="description[{{$key}}]" value="{{$value->description}}" placeholder="desciption">
                                    </div>
                                    <button type="button" id="{{$key}}" class="btn des-remove"><img src="{{asset('images/delete.gif')}}" alt=""></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
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
                @endif
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
                        <textarea name="content" style="width:100%; min-height:500px;" id="editor">{!! $product->content !!}</textarea>
                    </div>
                </div>
                <div class="clear"></div>
    
                <h1 style="border-bottom: 1px solid #CCC; padding-bottom: 10px; margin: 20px 0 0px 0;">Upload PDF </h1>
                <br>
                @if(count($product_pdf) >= 1)
                    <div class="pdf-section">
                        @foreach($product_pdf as $key => $value)
                            <div class="main-pdf-section" id="pdf_{{$key}}">
                                <div class="form-raw">
                                    <div class="form-name">&nbsp;</div>
                                    <div class="form-txtfld txtfld50">
                                        <input type="text" name="pdf_heading[{{$key}}]" value="{{$value->heading}}" placeholder="PDF heading">
                                    </div>
                                    <div class="form-txtfld txtfld50">
                                        <input type="file" name="pdf_file_new[{{$key}}]" placeholder="desciption">
                                        <input type="hidden" name="pdf_file[{{$key}}]" value="{{$value->file}}" placeholder="desciption">
                                        @if($value->file)
                                        <!-- <img src="{{asset('product_pdf')}}/{{$value->file}}" width="100px" height="100px"> -->
                                        @endif
                                    </div>
                                    <button type="button" id="{{$key}}" class="btn pdf-remove"><img src="{{asset('images/delete.gif')}}" alt=""></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
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
                @endif
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
                        <input type="checkbox" value="1" name="status" {{ $product->status == "1" ? "checked" : "" }}>
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
                    jQuery("#subcategory").html(result);
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
    $("#des-add-btn").click(function() {
        ++k;
        const src = "{{asset('images/delete.gif')}}";
        $(".description-section").append('<div class="main-description-section" id="description_'+k+'"><div class="form-name"> &nbsp;</div><div class="form-txtfld"><input type="text" name="title['+k+']" placeholder="Title"></div><div class="form-raw"><div class="form-name">&nbsp;</div><div class="form-txtfld txtfld50"><input type="text" name="heading['+k+']" placeholder="heading"></div><div class="form-txtfld txtfld50"><input type="text" name="description['+k+']" placeholder="desciption"></div><button type="button" id="'+k+'" class="btn des-remove"><img src="'+src+'" alt=""></button></div></div>');
    });
    $(document).on('click', '.des-remove', function() {
        console.log("hello");
        var k = 'description_'+$(this).attr('id');
        $('#' + k).remove();
    });

    var j = 1;
    $("#add_pdf").click(function() {
        ++j;
        const src = "{{asset('images/delete.gif')}}";
        $(".pdf-section").append('<div class="main-pdf-section" id="pdf_'+j+'"><div class="form-raw"><div class="form-name">&nbsp;</div><div class="form-txtfld txtfld50"><input type="text" name="pdf_heading['+j+']" placeholder="PDF heading"></div><div class="form-txtfld txtfld50"><input type="file" name="pdf_file['+j+']" placeholder="desciption"></div><button type="button" id="'+j+'" class="btn pdf-remove"><img src="'+src+'" alt=""></button></div></div>');
    }); 
    $(document).on('click', '.pdf-remove', function() {
        console.log("hello");
        var k = 'pdf_'+$(this).attr('id');
        $('#' + k).remove();
    });
</script>
@endpush

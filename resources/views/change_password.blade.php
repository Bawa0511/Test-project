@extends('layouts.main')

@section('content')
<div id="wrap" >
    @if(session()->has('error'))
        <span style="color: red;">{{ session()->get('error') }}</span>
    @endif
    <section class="bodymain" style="min-height:580px;">
        <aside class="middle-container">
            <div class="admin-inr"><br>
                <form method="POST" id="formid" enctype="multipart/form-data">
                    @csrf
                    <div class="form-outer" style="margin-left:320px; width:500px;">
                        <h1>Change Password</h1>
                        <div class="contact-row">
                            <div class="name">Current Password</div>
                            <div class="txtfld-box">
                                <input id="current_password" type="password" required name="current_password"><br>
                            </div>
                            <span id="curr_pass" style="color:red;"></span>
                        </div>
                        <div class="clear"></div>
                        <div class="contact-row">
                            <div class="name">New Password</div>
                            <div class="txtfld-box">
                                <input id="new_password" type="password" required name="new_password">
                            </div>
                            <span id="new_pass" style="color:red;"></span>
                        </div>
                        <div class="clear"></div>
                        <div class="contact-row">
                            <div class="name">Confirm Password</div>
                            <div class="txtfld-box">
                                <input id="confirm" type="password" required name="confirm_password">
                            </div>
                            <span id="con_password" style="color:red;"></span>
                        </div>
                        <div class="clear">&nbsp;</div>
                        <div class="contact-row">
                            <span id="success" style="color:green; font-weight:900;"></span>
                            <div class="name" style="float:right; width:1px;">&nbsp;</div>
                            <div style="background:none; border:none; float:left;">
                                <input class="btn btn-submit" type="submit" name="submit">
                                <br>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="clear">&nbsp;</div>
                            
                    <div class="clear"></div>
                </div>
            </div>
        </aside>
        <div class="clear"></div>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" ></script>
<script>
    $(document).ready(function() {
        $('#formid').submit(function(event) {
            // alert("done");
            $('.btn-submit').val('Processing...');
            event.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("update.password") }}',
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
                success: function(data) {
                    if (data.status == 401) {
                        var myObj = data.message;
                        alert(data.message+" done")
                        if (myObj.new_password) {
                            document.getElementById("new_pass").innerHTML = '*' + myObj.new_password[0];
                        }
                        if (myObj.confirm_password) {
                            document.getElementById("con_password").innerHTML = '*' + myObj.confirm_password[0];
                        }
                        if (data.message == 'Password not match') {
                            document.getElementById("curr_pass").innerHTML = '*' + data.message;
                        }
                    } else {
                        // alert("sort");
                        document.getElementById("success").innerHTML = '*' + data.message;
                    }
                    $('.btn-submit').val('Submit');
                    $('#current_password').val('');
                    $('#new_password').val('');
                    $('#confirm').val('');
                },
                error: function (data) {
                    alert(data);
                }
            });
        });
    });

</script>

@endpush


@extends('layouts.main')

@section('content')
        <div class="bodycont">
            <div id="wrap2" style="min-height:530px;">
                <div class="login-cont">
                    <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                    @csrf
                        <h1 class="loginhd">Login Here</h1>
                        <div class="login-row">
                            <div class="loginname">Email</div>
                            <div class="admintxtfld-box">
                                <input type="text" name="email">
                                @error('email')
                                    <span style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>        
                            <div class="clear"></div>
                        </div>
                        <!-- <div class="loginreq-field">* This Field Required </div> -->
            
                        <div class="login-row">
                            <div class="loginname">Password</div>
                            <div class="admintxtfld-box">
                            <input type="password" name="password">
                                @error('password')
                                    <span style="color: red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="clear"></div>
                        </div>
            
                        <div class="clear"></div>
                        <div class="contact-row" style="width:325px;">
                            <div style="background:none; border:none; margin-top:15px;">
                                <!-- <a href="admin.html" style="text-decoration:none;"> -->
                                    <input type="submit" class="btn" value="Login">
                                <!-- </a><br> -->
                            </div>
                        </div>
                        <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </form>
                </div>
                <div class="clear"></div>
            </div>
@endsection

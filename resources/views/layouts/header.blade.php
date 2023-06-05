<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>AKS Machine Test</title>
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <!--[if lt IE 9]>
        <script type="text/javascript" src="html5.js"></script>
        <![endif]-->
        <!--[if lt IE 7.]>
        <script defer type="text/javascript" src="pngfix1.js"></script>
        <![endif]-->

        <!-- Menu start --------------->
        <link href="{{asset('menu/quickmenu0.css')}}" rel="stylesheet" type="text/css" media="screen" />
        <script type="text/javascript" src="{{asset('menu/quickmenu0.js')}}"></script>
        <!-- Menu End --------------->
    </head>
    <body>
        <header>
            <div id="wrap">
                <div class="logo"><img src="{{asset('images/logo.png')}}" border="0"></div>
                @guest
                <div class="admintxt">Admin panel</div>
                @else
                <div class="topmenu">
                    <ul>
                        <li><a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                        <li><a href="{{ route('change.password') }}">Change Password</a>&nbsp;|</li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{asset('images/logout.png')}}" width="16" height="16" border="0" align="absmiddle">&nbsp;&nbsp; {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
                @endguest
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </header>
        @guest
        @else
        <nav>
            <ul id="qm0" class="qmmc" >
            <li><a href="{{ route('home') }}" class="qmactive">Dashboard</a></li>            
            <li><a href="#">Product</a>
                <ul>
                    <li><a href="{{ route('add.category') }}">Add Category</a></li>
                    <li><a href="{{ route('add.sub_category') }}">Add Sub Category</a></li>
                    
                    <li><a href="{{ route('add.product') }}">Add Product</a></li>
                </ul>
            </li>      
            </ul>
        </nav>
        @endguest
        <div class="clear"></div>
        


<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i
                                        class="fa fa-phone"></i> {{getConfigValueFromSettingTable('phone_contact')}}</a>
                            </li>
                            <li><a href="{{getConfigValueFromSettingTable('email')}}"><i
                                        class="fa fa-envelope"></i> {{getConfigValueFromSettingTable('email')}}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{getConfigValueFromSettingTable('facebook_link')}}"><i
                                        class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="{{getConfigValueFromSettingTable('linkendin_link')}}"><i
                                        class="fa fa-linkedin"></i></a></li>
                            <li><a href="{{getConfigValueFromSettingTable('google_link')}}"><i
                                        class="fa fa-google-plus"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{route('home')}}"><img src="/eshopper/images/home/logo.png" alt=""/></a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="{{route('product.showCart')}}"><i
                                                                           class="fa fa-shopping-cart"></i>
                                    @if(isset($cartsNumber) &&$cartsNumber > 0)
                                        <span id="span-cart" class="badge badge-danger navbar-badge">{{$cartsNumber}}</span>
                                    @else
                                        <span id="span-cart" class="badge badge-danger navbar-badge"></span>
                                    @endif
                                    Cart</a>
                            </li>
                            <li><a href="#"><i class="fa fa-lock"></i> Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    @include('frontend.components.main_menu')
                </div>

            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->

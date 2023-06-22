<header>
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 address">
                    <i class="ti-location-pin"></i> Tripoli , North Lebanon , El Sakafi Street
                </div>
                <div class="col-sm-6 social">
                    <ul>
                        <li><a href="https://www.facebook.com/GhassanElHallak" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href={{ route('index') }}>
                    Hallak<span> | Insurance Broker</span>
                </a>
                <p>Call Us Now <b>+961 (70) 424 200</b></p>
            </div>
            <div class="collapse navbar-collapse navbar-main-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href={{ route('index') }}>Home</a>
                    </li>
                    <li>
                        <a href={{ route('insurancellist') }}>Insurance Plans</a>
                    </li>
                    <li>
                        <a href={{ route('contactus') }}>Contact US</a>
                    </li>
                    <li>
                        <a href={{ route('login') }} target="_blank">Log In</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>

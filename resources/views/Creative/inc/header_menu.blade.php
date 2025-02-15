<div class="inner-content">
    <div class="d-flex align-items-center justify-content-between">
        <div class="logo">
            <a href="/">
                @if($website->logo)
                    <img src="{{ url($website->logo) }}" alt="" >
                @else
                    {{ $website->title }}
                @endif
            </a>
        </div>
        <!-- widget mobile menu -->
        <nav class="navbar navbar-expand-lg">
            <button class="navbar-toggler d-block d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @include('Creative.inc.menu')
                </ul>

                <div class="mobile-content d-block d-lg-none">

                    @include('Creative.inc.socials')
                    @include('common.pluginProducts.inc.topbar_menu')

                    <div class="address-block">
                        <h4 class="title">Fissa un appuntamento</h4>
                        <p>Via Don A. Giusti, 16/3<br/>36045 Lonigo (VI)<br></p>
                        <p>Chiama al <br><a href="tel:393472349421">+39 347 2349421</a></p>
                    </div>
                </div> <!-- /.mobile-content -->
            </div>
        </nav>
        <div class="right-widget d-flex align-items-center">

                @include('Creative.inc.socials')
                @include('common.pluginProducts.inc.topbar_menu')

        </div> <!-- /.right-widget -->
    </div>
</div> <!-- /.inner-content -->







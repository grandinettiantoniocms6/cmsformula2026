@if($website->topbar_fixed_background)
<div class="header-middle sticky-header fix-top sticky-content" style="background-color: {{ $website->topbar_fixed_background }}">
@else
<div class="header-middle sticky-header fix-top sticky-content">
@endif
    <div class="container">
        <div class="header-left">
            <a href="#" class="mobile-menu-toggle">
                <i class="d-icon-bars2"></i>
            </a>
            <a href="/" class="logo">
                @if($website->logo)
                    <img src="{{ url($website->logo) }}" alt="logo" width="153" height="44" />
                @else
                    {{ $website->title }}
                @endif
            </a>
            <!-- End Logo -->

            <div class="header-search hs-simple">
                <form action="#" class="input-wrapper">
                    <input type="text" class="form-control" name="search" autocomplete="off"
                           placeholder="Search..." required />
                    <button class="btn btn-search" type="submit">
                        <i class="d-icon-search"></i>
                    </button>
                </form>
            </div>
            <!-- End Header Search -->
        </div>
        <div class="header-right">
            <a href="tel:#" class="icon-box icon-box-side">
                <div class="icon-box-icon mr-0 mr-lg-2">
                    <i class="d-icon-phone"></i>
                </div>
                <div class="icon-box-content d-lg-show">
                    <h4 class="icon-box-title">Supporto Clienti:</h4>
                    <p>+39 0444 123456</p>
                </div>
            </a>
            <span class="divider"></span>
            <a href="#" class="wishlist">
                <i class="d-icon-heart"></i>
            </a>
            <span class="divider"></span>
            <div class="dropdown cart-dropdown type2 mr-0 mr-lg-2">
                <a href="#" class="cart-toggle label-block link">
                    <div class="cart-label d-lg-show">
                        <span class="cart-name">Carrello:</span>
                        <span class="cart-price">€ 0.00</span>
                    </div>
                    <i class="d-icon-bag"><span class="cart-count">2</span></i>
                </a>
                <div class="dropdown-box">
                    <div class="products scrollable">
                        <div class="product product-cart">
                            <figure class="product-media">
                                <a href="#">
                                    <img src="images/cart/product-1.jpg" alt="product" width="80"
                                         height="88" />
                                </a>
                                <button class="btn btn-link btn-close">
                                    <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                </button>
                            </figure>
                            <div class="product-detail">
                                <a href="#" class="product-name">Riode White Trends</a>
                                <div class="price-box">
                                    <span class="product-quantity">1</span>
                                    <span class="product-price">€ 21.00</span>
                                </div>
                            </div>

                        </div>
                        <!-- End of Cart Product -->
                        <div class="product product-cart">
                            <figure class="product-media">
                                <a href="#">
                                    <img src="images/cart/product-2.jpg" alt="product" width="80"
                                         height="88" />
                                </a>
                                <button class="btn btn-link btn-close">
                                    <i class="fas fa-times"></i><span class="sr-only">Close</span>
                                </button>
                            </figure>
                            <div class="product-detail">
                                <a href="#" class="product-name">Dark Blue Women’s
                                    Leomora Hat</a>
                                <div class="price-box">
                                    <span class="product-quantity">1</span>
                                    <span class="product-price">€ 118.00</span>
                                </div>
                            </div>
                        </div>
                        <!-- End of Cart Product -->
                    </div>
                    <!-- End of Products  -->
                    <div class="cart-total">
                        <label>Subtotale:</label>
                        <span class="price">€ 139.00</span>
                    </div>
                    <!-- End of Cart Total -->
                    <div class="cart-action">
                        <a href="#" class="btn btn-dark btn-link">Vedi Carrello</a>
                        <a href="#" class="btn btn-dark"><span>Vai alla Cassa</span></a>
                    </div>
                    <!-- End of Cart Action -->
                </div>
                <!-- End Dropdown Box -->
            </div>
            <div class="header-search hs-toggle mobile-search">
                <a href="#" class="search-toggle">
                    <i class="d-icon-search"></i>
                </a>
                <form action="#" class="input-wrapper">
                    <input type="text" class="form-control" name="search" autocomplete="off"
                           placeholder="Search your keyword..." required />
                    <button class="btn btn-search" type="submit">
                        <i class="d-icon-search"></i>
                    </button>
                </form>
            </div>
            <!-- End of Header Search -->
        </div>
    </div>

</div>
<div class="header-bottom d-lg-show">
    <div class="container">
        <div class="header-left">
            <nav class="main-nav">
                @include('Shoppy.inc.menu')
            </nav>
        </div>
        <div class="header-right">
            <a href="#"><i class="d-icon-card"></i>Special Offers</a>
        </div>
    </div>
</div>

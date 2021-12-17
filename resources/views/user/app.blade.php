<!DOCTYPE html>
<html lang="en">
  <head>
    <title>GoFarm</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="{{ asset('shopper') }}/fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{ asset('shopper') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('shopper') }}/css/owl.theme.default.min.css">
    
    <link rel="stylesheet" href="{{ asset('adminassets') }}/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('adminassets') }}/assets/vendors/css/vendor.bundle.base.css">

    <link rel="stylesheet" href="{{ asset('shopper') }}/css/aos.css">

    <link rel="stylesheet" href="{{ asset('shopper') }}/css/style.css">
    <link rel="shortcut icon" href="{{ asset('adminassets') }}/assets/images/favicon.png" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
  </head>
  <body>
  
  <div class="site-wrap">
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">
            
            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
              <div class="site-logo">
                <a href="{{ route('home') }}" class="js-logo-clone">
                <img src="{{ asset('adminassets') }}/assets/images/favicon.png" alt="logo" width="30px" height="30px" style="margin: 0px -2px 3px -2px"/>
                GoFarm</a>
              </div>
            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <form action="{{ route('user.produk.cari') }}" method="get" class="site-block-top-search" >
                @csrf
                <input type="text" class="form-control border-0" name="cari" placeholder="Search">
                <span class="icon icon-search2"></span>
              </form>
            </div>

            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
            <div class="top-right links"> 
            <div class="site-top-icons">
              <ul>
              @if (Route::has('login'))
                    @auth
                        <li>
                          <div class="dropdown">
                            <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon icon-person"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('user.alamat') }}">Pengaturan Alamat</a>
                                <a class="dropdown-item" href="#">Pengaturan Akun</a>
                                <a class="dropdown-item" href="#">
                                
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                  <i class="mdi mdi-logout mr-2 text-primary"></i> Logout 
                              </a>

                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                            </div>
                            </div>
                        </li>
                        <li>
                          <?php
                            $user_id = \Auth::user()->id;
                            $total_keranjang = \DB::table('keranjang')
                            ->select(DB::raw('count(id) as jumlah'))
                            ->where('user_id',$user_id)
                            ->first();
                          ?>
                            <a href="{{ route('user.keranjang') }}" class="site-cart">
                            <span class="icon icon-add_shopping_cart"></span>
                            <span class="count">{{ $total_keranjang->jumlah }}</span>
                            </a>
                        </li> 
                        <li>
                        <?php
                            $user_id = \Auth::user()->id;
                            $total_order = \DB::table('order')
                            ->select(DB::raw('count(id) as jumlah'))
                            ->where('user_id',$user_id)
                            ->where('status_order_id','!=',5)
                            ->where('status_order_id','!=',6)
                            ->first();
                          ?>
                        <a href="{{ route('user.order') }}" class="site-cart">
                            <span class="icon icon-shopping_cart"></span>
                            <span class="count">{{ $total_order->jumlah }}</span>
                            </a>
                        </li>
                    @else
                    <div class="dropdown">
                            <a class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="icon icon-person"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ route('login') }}">Masuk</a>
                                @if (Route::has('register'))
                                  <a class="dropdown-item" href="{{ route('register') }}">Daftar</a>
                                @endif
                            </div>
                            </div>
                    @endauth
                </div>
            @endif
            <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
            </div>
            </ul>
            </div> 
          </div>
        </div>
      </div> 
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
            <li class="{{ Request::path() === '/' ? '' : '' }}"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="{{ Request::path() === 'produk' ? '' : '' }}"><a href="{{ route('user.produk') }}">Produk</a></li>
            <li class="{{ Request::path() === 'kontak' ? '' : '' }}"><a href="{{ route('kontak') }}">Kontak</a></li>
          </ul>
        </div>
      </nav>
    </header>

    @yield('content')
    
    <footer class="site-footer border-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="row">
              <div class="col-md-12">
                <a href="{{ route('home') }}">
                  <img src="{{ asset('adminassets') }}/assets/images/GoFarm.png" alt="logo" width="137px" height="45px"/>
                </a>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled"><br>
                  <li><a href="#">Tentang GoFarm</a></li>
                  <li><a href="#">Ketentuan Penggunaan</a></li>
                  <li><a href="#">Kebijakan Privasi</a></li>
                  <li><a href="#">Layanan Pelanggan</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled"><br>
                  <li><a href="#">Kontak</a></li>
                  <li><a href="#">Dropshipping</a></li>
                  <li><a href="#">Pengiriman</a></li>
                </ul>
              </div>
              <div class="col-md-6 col-lg-4">
                <ul class="list-unstyled"><br>
                  <li><a href="#">Produk</a></li>
                  <li><a href="#">Kategori</a></li>
                  <li><a href="#">Mulai Belanja</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-lg-3">
            <div class="block-5 mb-5">
              <h5 class="footer-heading mb-4"><b>Hubungi Kami</b></h5>
              <ul class="list-unstyled">
                <p><i class="mdi mdi-map-marker text-primary"></i> Laguboti, Sumatera Utara</p>
                <p><i class="mdi mdi-phone text-primary"></i><a href="tel://281234567890"> +62 8123 4567 890</a></p>
                <p><i class="mdi mdi-email text-primary"></i><a href="mailto: support@gofarm.com">&nbsp; support@gofarm.com</a></p>
              </ul>
            </div>
          </div>
          <div class="col-md-4 col-lg-3">
            <div class="block-5 mb-5">
              <h5 class="footer-heading mb-4"><b>Ikuti Kami</b></h5>
              <ul class="list-unstyled">
                <p><i class="mdi mdi-facebook-box text-info"></i><a href="#"> Facebook</a></p>
                <p><i class="mdi mdi-twitter-box text-info"></i><a href="#"> Twitter</a></p>
                <p><i class="mdi mdi-instagram text-danger"></i><a href="#"> Instagram</a></p>
              </ul>
            </div>
            {{-- <div class="block-7">
              <form action="#" method="post">
                <label for="email_subscribe" class="footer-heading">Subscribe</label>
                <div class="form-group">
                  <input type="text" class="form-control py-4" id="email_subscribe" placeholder="Email">
                  <input type="submit" class="btn btn-sm btn-primary" value="Send">
                </div>
              </form>
            </div> --}}
          </div>
        </div>
        <div class="row pt-4 mt-4 text-left">
          <div class="col-md-12">
            <strong>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Copyright &copy; <strong>GoFarm</strong> <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script>.&nbsp;All rights reserved.
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </strong>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script src="{{ asset('shopper') }}/js/jquery-3.3.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
  <script src="{{ asset('shopper') }}/js/jquery-ui.js"></script>
  <script src="{{ asset('shopper') }}/js/popper.min.js"></script>
  <script src="{{ asset('shopper') }}/js/bootstrap.min.js"></script>
  <script src="{{ asset('shopper') }}/js/owl.carousel.min.js"></script>
  <script src="{{ asset('shopper') }}/js/jquery.magnific-popup.min.js"></script>
  <script src="{{ asset('shopper') }}/js/aos.js"></script>

  <script src="{{ asset('shopper') }}/js/main.js"></script>
    @yield('js')
  </body>
</html>
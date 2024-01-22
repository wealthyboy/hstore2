<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8" />
    <title>{{ isset( $page_title) ?  $page_title .' |  '.config('app.name') :  $system_settings->meta_title  }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="google-site-verification" content="WQGOl-v7IztNDZtgNC1ZEBkG8nyRsHJ1oLsnsLeiuIQ" />
	<link rel="preload" href="https://hautesignatures.com/fonts/ProximaNovaAltRegular.otf" as="font" type="font/otf" crossorigin>
	<link rel="preload" href="https://hautesignatures.com/fonts/GalaxiePolaris-Bold.otf" as="font" type="font/otf" crossorigin>
	<link rel="preload" href="https://hautesignatures.com/fonts/porto-64334846.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="https://hautesignatures.com/css/bootstrap.min.css" as="style">
	<link rel="preload" href="https://hautesignatures.com/css/style.min.css" as="style">
    <link rel="preload" href="https://hautesignatures.com/css/vendor/fontawesome-free/css/all.min.css" as="style">
    <link rel="preload" href="https://hautesignatures.com/css/skins/skin-default.css" as="style">

    <link rel="preload" href="https://hautesignatures.com/js/app.js" as="script">
 

    <meta name="description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
    <meta name="keywords" content="{{ isset($meta_tag_keywords) ? $meta_tag_keywords : $system_settings->meta_tag_keywords }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="{{ Config('app.url') }}">

     <!-- Favicone Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
	<link rel="icon" href="/img/favicon.ico" type="image/x-icon">
	<link rel="icon" type="image/png" href="/img/favicon-96x96.png">
	<link rel="apple-touch-icon" href="/img/favicon-96x96.png">

    <!-- CSS -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
	<!-- Main CSS File -->
	<link rel="stylesheet" href="/css/style.min.css?version={{ str_random(6) }}">
	<link rel="stylesheet" type="text/css" href="/vendor/fontawesome-free/css/all.min.css">
	<link rel="stylesheet" href="/css/skins/skin-default.css?version={{ str_random(6) }}">
	<link rel="stylesheet" href="/css/banner.css?version={{ str_random(6) }}">

    @yield('page-css')
    <link href="/css/custom.css?version={{ str_random(6) }}" rel="stylesheet" type="text/css" />
    <meta property="og:site_name" content="hautesignatures Co">
    <meta property="og:url" content="https://hautesignatures.com/">
    <meta property="og:title" content=" hautesignatures">
    <meta property="og:type" content="website">
    <meta property="og:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
    <meta property="og:image:alt" content="">
    <meta name="twitter:site" content="@hautesignatures">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
    <meta name="twitter:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-JVYYVR9G8L"></script>
<script>
  	window.dataLayer = window.dataLayer || [];
   function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

     gtag('config', 'G-JVYYVR9G8L');

	(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TBZPGWQ');

	Window.user = {
		user: {!! auth()->check() ? auth()->user() : 0000 !!},
		loggedIn: {!! auth()->check() ? 1 : 0 !!},
		settings: {!! isset($system_settings) ? $system_settings : '' !!},
		token: '{!! csrf_token() !!}'
	}
	</script>





</head>
<script>
  (function(w, d, t, h, s, n) {
    w.FlodeskObject = n;
    var fn = function() {
      (w[n].q = w[n].q || []).push(arguments);
    };
    w[n] = w[n] || fn;
    var f = d.getElementsByTagName(t)[0];
    var v = '?v=' + Math.floor(new Date().getTime() / (120 * 1000)) * 60;
    var sm = d.createElement(t);
    sm.async = true;
    sm.type = 'module';
    sm.src = h + s + '.mjs' + v;
    f.parentNode.insertBefore(sm, f);
    var sn = d.createElement(t);
    sn.async = true;
    sn.noModule = true;
    sn.src = h + s + '.js' + v;
    f.parentNode.insertBefore(sn, f);
  })(window, document, 'script', 'https://assets.flodesk.com', '/universal', 'fd');
</script>
<script>
  window.fd('form', {
    formId: '62e12f9bbf22a55feeba5d45'
  });
</script>
<script>
  window.fd('form', {
    formId: '62e10e95bf22a55feeba5d2f'
  });
</script>
<script>
  window.fd('form', {
    formId: '62e10e95bf22a55feeba5d2f'
  });
</script>
<body class="">

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TBZPGWQ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div id="app" class="page-wrapper">
		<header class="header fixed-top">
			<div class="header-middle">
				<div class="container">
					<div class="header-left w-lg-max ml-auto ml-lg-0">
						<div class="header-icon header-search header-search-inline header-search-category">
							<a href="#" class="search-toggle" role="button"><i class="icon-search-3"></i></a>
							<form action="/search" method="get">
								<div class="header-search-wrapper">
									<input type="search" class="form-control" name="q" id="q" placeholder="Search..." required>
									<button class="btn icon-search-3 p-0" type="submit"></button>
								</div><!-- End .header-search-wrapper -->
							</form>
						</div><!-- End .header-search -->
					</div><!-- End .header-left -->

					<div class="header-center order-first order-lg-0 ml-0 ml-lg-auto">
						<button class="mobile-menu-toggler" type="button">
							<i class="icon-menu"></i>
						</button>
						<a href="/" class="logo">
							<img src="{{ $system_settings->logo_path() }}" alt="{{ Config('app.name') }} Logo">
						</a>
					</div><!-- End .header-center -->
                    <nav-icon    />


				</div><!-- End .container -->
			</div><!-- End .header-middle -->

			<div class="header-bottom sticky-header d-none d-lg-block">
				<div style="padding-left: 50px;" class="container-fluid ">
					<nav class="main-nav d-flex w-lg-max   justify-content-center">
						<ul class="menu">
							
                            @foreach( $global_categories   as  $category)
                                <li>
                                   <a  title="{{ $category->title }}" style="color: {{  $category->text_color }} !important" href="
								       {{  $category->link ? $category->link : '/products/'.$category->slug }}
								   
								   ">{{ $category->name }}</a>
                                   @if ($category->isCategoryHaveMultipleChildren())

                                    <div class="megamenu megamenu-fixed-width">
                                        <div class="row">
										    <div class="col-lg-9">
											    <div class="row">
													@foreach (  $category->children as $children)
													<div class="col-lg-3">
														<a href="/products/{{ $children->slug }}" title="{{ $children->title }}" class="category-heading"><b>{{ $children->name !== 'No Heading' ? $children->name : '' }} </b></a>
														@if ($children->children->count())
															<ul class="submenu">
																@foreach (  $children->children as $children)
																	<li><a title="{{ $children->title }}"  href="/products/{{ $children->slug }}">{{ ucfirst($children->name) }}</a></li>
																@endforeach
															</ul>
														@endif
													</div><!-- End .col-lg-4 -->
													@endforeach
		                                        </div>
											</div>
											
											<div class="col-lg-3">
												<div class="col-lg-12 p-0">
												   <a title="{{ $category->title }}" href="{{ $category->image_custom_link }}"><img src="{{ $category->image }}" alt="{{ $category->image }}" class="product-promo" ></a>
												</div><!-- End .col-lg-4 -->
											</div>
										   

                                        </div><!-- End .row -->
                                    </div><!-- End .megamenu -->
                                    @elseif ( !$category->isCategoryHaveMultipleChildren() && $category->children->count() )
                                        <ul  >
                                            @foreach (  $category->children as $children)
                                               <li class="nav-children color--primary  {{ strtolower($category->name) == 'christmas shop' ? 'pl-5' : '' }}"><a title="{{ $children->title }}" href="/products/{{ $children->slug }}">{{ $children->name }}</a></li>
                                            @endforeach 
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
						</ul>
					</nav>
				</div><!-- End .container -->
			</div><!-- End .header-bottom -->
		</header><!-- End .header -->
        <main class="main main-page">
          @yield('content')
        </main>
		
		<footer class="footer">
			<div class="footer-middle">
				<div class="container-fluid">
					<div class="row">
						<div class="col-sm-6 col-xl-6">
							<div class="widget widget-newsletter">
								<h4 class="widget-title">Subscribe to our newsletter.</h4>
								<p>Get all the latest information on events, sales and offers. Sign up for newsletter today.</p>
								<news-letter />
							</div>
							<p>
								<div class="contact-widget follow">
									<div class="social-icons">
										<a href="https://facebook.com/hautesignatures.ng/" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
										<a href="https://instagram.com/hautesignatures.ng?igshid=zqjic4sfh041" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
										<a href="https://wa.me/2348092907541" class="social-icon" target="_blank"><i class="fab fa-whatsapp"></i></a>
									</div><!-- End .social-icons -->
								</div>
							</p>
						</div>

						<div class="col-lg-6 col-md-6">
							<div class="row ">
								@foreach($footer_info as $info)
									<div class="col-sm-4 col-6 col-lg-4">
										<div class="widget">
											<h2 class="widget-title">{{ title_case($info->title) }}</h2>
											@if($info->children->count())
											<ul class="">
													@foreach($info->children as $info)
														<li>
															<a href="{{ $info->link }}">
																{{ $info->title }}
															</a>
														</li>
													@endforeach
												</ul>
											@endif
											
										</div><!-- End .widget -->
									</div><!-- End .col-sm-6 -->
								@endforeach
							</div>
						</div>	
					</div><!-- End .row -->
				</div><!-- End .container -->
			</div><!-- End .footer-middle -->

			<div class="footer-bottom">
				<div class="container d-flex justify-content-center align-items-center flex-wrap">
					<p class="footer-copyright py-3 pr-4 mb-0">© {{ config('app.name') }}. {{ date('Y') }}. All Rights Reserved</p>
					@if ( auth()->check() && auth()->user()->isAdmin() )
					  <p class="footer-copyright py-3 pr-4 mb-0"><a target="_blank" href="/admin" >Go to Admin</a></p>
					@endif
				</div><!-- End .container -->
			</div><!-- End .footer-bottom -->
        </footer>

			
    </div><!-- End .page-wrapper -->

	<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

	<div class="mobile-menu-container">
		<div class="mobile-menu-wrapper">
			<span class="mobile-menu-close"><i class="icon-cancel"></i></span>
			<nav class="mobile-nav">
				<ul class="mobile-menu">
				@foreach( $global_categories   as  $category)
				    <li>
						<a href="{{  $category->link ? $category->link : '/products/'.$category->slug }}">{{ $category->name }}</a>
						@if ($category->isCategoryHaveMultipleChildren())
							<ul>
							    @foreach (  $category->children as $children)

								<li>
								<a href="/products/{{ $children->slug }}" class="category-heading">{{ $children->name }} </a>
								   @if ($children->children->count())
										<ul>
										    @foreach (  $children->children as $children)
                                                <li><a href="/products/{{ $children->slug }}">{{ $children->name }}</a></li>
                                            @endforeach
										</ul>
									@endif
								</li>
								@endforeach
							</ul>
						@elseif ( !$category->isCategoryHaveMultipleChildren() && $category->children->count() )
							<ul>
								@foreach (  $category->children as $children)
									<li><a class="category-heading" href="/products/{{ $children->slug }}">{{ $children->name }}</a></li>
								@endforeach 
							</ul>
						@endif
					</li>
					
				@endforeach
				</ul>
			</nav><!-- End .mobile-nav -->

			
		</div><!-- End .mobile-menu-wrapper -->
	</div><!-- End .mobile-menu-container -->




	

    <div class="watsapp pt-3">
	   <a class="chat-on-watsapp" target="_blank" href="https://wa.me/{{ $system_settings->store_phone }}">
		  Need help? Chat with us  <i class="fab fa-whatsapp fa-2x float-right mr-2"></i></a>
	</div>
	<a id="scroll-top" href="#top" title="Top" role="button"><i class="icon-angle-up"></i></a>

	<!-- Plugins JS File -->
	<script src="/js/app.js?version={{ str_random(6) }}" type="text/javascript"></script>

    @yield('page-scripts')
    <script type="text/javascript">
        @yield('inline-scripts')
    </script>
</body>
</html>











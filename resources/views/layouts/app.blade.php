<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
	<meta charset="utf-8" />
	<title>{{ isset( $page_title) ?  $page_title .' |  '.config('app.name') :  $system_settings->meta_title  }}</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
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
	<!-- Main CSS File -->
	@yield('page-css')
	<link href="/vendor/fontawesome-free/css/all.min.css?version={{ str_random(6) }}" rel="stylesheet" type="text/css" />

	<link href="/css/all.css?version={{ str_random(6) }}" rel="stylesheet" type="text/css" />
	<meta property="og:site_name" content="theaurabydora Co">
	<meta property="og:url" content="https://theaurabydora.com/">
	<meta property="og:title" content="theaurabydora">
	<meta property="og:type" content="website">
	<meta property="og:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
	<meta property="og:image:alt" content="">
	<meta name="twitter:site" content="@theaurabydora">
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
	<meta name="twitter:description" content="{{ isset($page_meta_description) ? $page_meta_description : $system_settings->meta_description }}">
	<!-- Global site tag (gtag.js) - Google Analytics -->


	@php
	$user = auth()->check() ? auth()->user() : 000;
	$loggedIn = auth()->check() ? 1 : 0;
	@endphp

	<script>
		window.user = {
			user: @json($user),
			loggedIn: @json($loggedIn),
			settings: @json($system_settings),
			token: '{{ csrf_token() }}'
		}
	</script>



</head>

<style>
    .review-card {
      border: none;
      background: #fff;
      padding: 1.5rem;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
    .review-img {
      max-width: 100px;
      margin: 0 auto 1rem;
      border-radius: 8px;
    }
    .stars {
      color: #f5c518;
      margin-bottom: 0.5rem;
    }
    .review-text {
      font-style: italic;
      color: #444;
      margin: 1rem 0;
    }
    .review-author {
      font-weight: 500;
      margin-top: 0.5rem;
      color: #666;
    }

   /* Overlay */
.search-overlay {
  position: fixed;
  top: 60px; /* adjust to your navbar height */
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  justify-content: center;
  align-items: flex-start;
  z-index: 9999;
  opacity: 0;
  pointer-events: none;
  transition: opacity 0.3s ease;
}

/* Search bar wrapper */
.search-bar-wrapper {
  width: 100%;
  background: #fff;
  padding: 15px 20px;
  transform: translateY(-100%);
  opacity: 0;
  transition: transform 0.4s ease, opacity 0.4s ease;
}

/* Active state */
.search-overlay.show {
  opacity: 1;
  pointer-events: auto;
}

.search-overlay.show .search-bar-wrapper {
  transform: translateY(0);
  opacity: 1;
}



	
  </style>



<body class="">

	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TBZPGWQ" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

	<div id="app" class="page-wrapper">
		<header class="header fixed-top">
			<div class="header-middle">
				<div class="container-fluid">
					<div class="header-left w-lg-max ml-auto ml-lg-0">
						<div class="header-bottom sticky-header d-none d-lg-block">
				  <div style="padding-left: 50px;" class="container-fluid ">
					<nav class="main-nav d-flex w-lg-max justify-content-center">
						<ul class="menu">

							@foreach( $global_categories as $category)
							<li>
								<a  title="{{ $category->title }}" 
								    style="color: {{  $category->text_color }} !important;"
									href="{{  $category->link ? $category->link : '/products/'.$category->slug }}"
								>
									{{ $category->name }}
								</a>
								@if ($category->isCategoryHaveMultipleChildren())

								<div class="megamenu megamenu-fixed-width bg--main">
									<div class="row">
										<div class="col-lg-9">
											<div class="row  bg--main">
												@foreach ( $category->children as $children)
												<div class="col-lg-3  bg--main">
													<a href="/products/{{ $children->slug }}" title="{{ $children->title }}" class="category-heading"><b>{{ $children->name !== 'No Heading' ? $children->name : '' }} </b></a>
													@if ($children->children->count())
													<ul class="submenu  bg--main">
														@foreach ( $children->children as $children)
														<li><a title="{{ $children->title }}" href="/products/{{ $children->slug }}">{{ ucfirst($children->name) }}</a></li>
														@endforeach
													</ul>
													@endif
												</div><!-- End .col-lg-4 -->
												@endforeach
											</div>
										</div>

										<div class="col-lg-3">
											<div class="col-lg-12 p-0">
												<a title="{{ $category->title }}" href="{{ $category->image_custom_link }}">
													<img alt="{{ $category->image }}" src="{{ $category->image }}" class="product-promo">
												</a>
											</div><!-- End .col-lg-4 -->
										</div>


									</div><!-- End .row -->
								</div><!-- End .megamenu -->
								@elseif ( !$category->isCategoryHaveMultipleChildren() && $category->children->count() )
								<ul>
									@foreach ( $category->children as $children)
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
					</div><!-- End .header-left -->

					<div class="header-center order-first order-lg-0 ml-0 ml-lg-auto">
						<button class="mobile-menu-toggler" type="button">
							 <svg aria-hidden="true" fill="none" focusable="false" width="24" class="header__nav-icon icon icon-hamburger" viewBox="0 0 24 24">
								<path d="M1 19h22M1 12h22M1 5h22" stroke="currentColor" stroke-width="1" stroke-linecap="square"></path>
							</svg>
						</button>
						<a href="/" class="logo ml-sm-9">
							<img src="{{ $system_settings->logo_path() }}" alt="{{ Config('app.name') }} Logo">
						</a>
					</div><!-- End .header-center -->
					<nav-icon />
				</div><!-- End .container -->
			</div><!-- End .header-middle -->

			<div class="header-bottom sticky-header d-none d-lg-block">
				
			</div><!-- End .header-bottom -->
		</header><!-- End .header -->
		<main class="main main-page">
			@yield('content')
		</main>

		<footer class="footer">
			<div class="footer-middle">
				<div class="container-fluid">
					<div class="row">
						

						<div class="col-lg-6 col-md-6">
							<div class="row ">
								@foreach($footer_info as $info)
								<div class="col-sm-4 col-6 col-lg-4">
									<div class="widget">
										<h2 class="widget-title bold" >{{ title_case($info->title) }}</h2>
										@if($info->children->count())
										<ul class="">
											@foreach($info->children as $info)
											<li>
												<a class="font-weight-lighter text-neutral-500" href="{{ $info->link }}">
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

						<div class="col-sm-6 col-xl-6">
							<div class="widget widget-newsletter">
								<h4 class="widget-title bold">Subscribe to our newsletter.</h4>
								<p>Get all the latest information on events, sales and offers. Sign up for newsletter today.</p>
								<news-letter />
								
							</div>
							

						

							<div class="social-icons mt-3">
								<a href="{{ $system_settings->facebook_link }}" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
								<a href="{{ $system_settings->instagram_link }}" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
							</div><!-- End .social-icons -->
							<p>
						
							</p>
						</div>
					</div><!-- End .row -->
				</div><!-- End .container -->
			</div><!-- End .footer-middle -->

			<div class="footer-bottom">
				<div class="contact-widget  d-flex justify-content-center ">
								
				</div>
				<div class="container d-flex justify-content-center align-items-center flex-wrap">
					
					<p class="footer-copyright py-3 pr-4 mb-0">© {{ config('app.name') }}. {{ date('Y') }}. All Rights Reserved</p>
					@if ( auth()->check() && auth()->user()->isAdmin() )
					<p class="footer-copyright py-3 pr-4 mb-0"><a target="_blank" href="/admin">Go to Admin</a></p>
					@endif
				</div><!-- End .container -->
			</div><!-- End .footer-bottom -->
		</footer>


	</div><!-- End .page-wrapper -->

	<div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

	<div class="mobile-menu-container">
		<div class="mobile-menu-wrapper">
			<span class="mobile-menu-close">
				<svg aria-hidden="true" focusable="false" fill="none" width="16" class="icon icon-close" viewBox="0 0 16 16">
					<path d="m1 1 14 14M1 15 15 1" stroke="currentColor" stroke-width="1"></path>
				</svg>
			</span>
			<nav class="mobile-nav">
				<ul class="mobile-menu">
					@foreach( $global_categories as $category)
					<li>
						<a href="{{  $category->link ? $category->link : '/products/'.$category->slug }}">{{ $category->name }}</a>
						@if ($category->isCategoryHaveMultipleChildren())
						<ul>
							@foreach ( $category->children as $children)

							<li>
								<a href="/products/{{ $children->slug }}" class="category-heading">{{ $children->name }} </a>
								@if ($children->children->count())
								<ul>
									@foreach ( $children->children as $children)
									<li><a href="/products/{{ $children->slug }}">{{ $children->name }}</a></li>
									@endforeach
								</ul>
								@endif
							</li>
							@endforeach
						</ul>
						@elseif ( !$category->isCategoryHaveMultipleChildren() && $category->children->count() )
						<ul>
							@foreach ( $category->children as $children)
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




	<!-- Plugins JS File -->
	<script src="/js/app.js?version={{ str_random(6) }}" type="text/javascript"></script>

	@yield('page-scripts')
	<script type="text/javascript">
		@yield('inline-scripts')

		window.addEventListener("load", function() {
			const toggleBtn = document.getElementById("toggleSearch");
			const overlay = document.getElementById("searchOverlay");
			const closeBtn = document.querySelector(".btn-close-search");
			const input = overlay.querySelector("input[type='search']");

			function openSearch() {
			overlay.classList.add("show");
			setTimeout(() => input.focus(), 300);
			}

			function closeSearch() {
			overlay.classList.remove("show");
			}

			// Toggle with search icon
			toggleBtn.addEventListener("click", function() {
				console.log(true)
			    overlay.classList.contains("show") ? closeSearch() : openSearch();
			});

			// Close with overlay background
			overlay.addEventListener("click", function(e) {
			if (e.target === overlay) closeSearch();
			});

			// Close with "X" button
			closeBtn.addEventListener("click", closeSearch);

			document.addEventListener("keydown", function(e) {
			if (e.key === "Escape" && overlay.classList.contains("show")) {
				closeSearch();
			}
		});
	   }); 
	</script>
</body>

</html>
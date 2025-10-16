<!-- 🔍 Search Bar Section -->
<!-- Search Overlay (below navbar) -->
<div id="searchOverlay" class="search-overlay">
  <div id="searchBarWrapper" class="search-bar-wrapper border py-4 bg--main">
    <div class="container-fluid">
      <form id="predictive-search-form" action="/search" method="GET" role="search" class="search-form mb-0 d-flex align-items-center">
        <svg aria-hidden="true" fill="none" focusable="false" width="20" class="icon icon-search me-2" viewBox="0 0 24 24">
          <path d="M10.364 3a7.364 7.364 0 1 0 0 14.727 7.364 7.364 0 0 0 0-14.727Z" stroke="currentColor" stroke-width="1" stroke-miterlimit="10"></path>
          <path d="M15.857 15.858 21 21.001" stroke="currentColor" stroke-width="1" stroke-miterlimit="10" stroke-linecap="round"></path>
        </svg>

        <input type="search" name="q" placeholder="Search for... and press enter" aria-label="Search" class="bg--main form-control border-0 shadow-none fs-5 mb-0">

        <button type="button" role="button" class="btn-close-search bg-transparent border-0 ms-2">
          <svg width="20" viewBox="0 0 16 16" class="icon-close">
            <path d="m1 1 14 14M1 15 15 1" stroke="currentColor"></path>
          </svg>
        </button>
      </form>
    </div>
  </div>
</div>
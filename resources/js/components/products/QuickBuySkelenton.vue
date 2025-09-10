<template>
     <div class="container py-4">
        <div class="row">
          <!-- Left: Images -->
          <div class="col-md-6">
            <!-- Main Image Skeleton -->
            <div class="skeleton rounded mb-3" style="height: 400px;"></div>

            <!-- Thumbnails -->
            <div class="d-flex">
              <div class="skeleton rounded mr-2" style="width: 80px; height: 100px;"></div>
              <div class="skeleton rounded mr-2" style="width: 80px; height: 100px;"></div>
              <div class="skeleton rounded" style="width: 80px; height: 100px;"></div>
            </div>
          </div>

          <!-- Right: Details -->
          <div class="col-md-6">
            <!-- Title -->
            <div class="skeleton rounded mb-2" style="width: 70%; height: 24px;"></div>
            <div class="skeleton rounded mb-4" style="width: 50%; height: 20px;"></div>

            <!-- Price -->
            <div class="skeleton rounded mb-3" style="width: 120px; height: 28px;"></div>

            <!-- Colors -->
            <div class="mb-3">
              <div class="skeleton rounded-circle d-inline-block mr-2" style="width: 32px; height: 32px;"></div>
              <div class="skeleton rounded-circle d-inline-block mr-2" style="width: 32px; height: 32px;"></div>
            </div>

            <!-- Sizes -->
            <div class="mb-4">
              <div class="skeleton rounded d-inline-block mr-2" style="width: 50px; height: 40px;"></div>
              <div class="skeleton rounded d-inline-block mr-2" style="width: 50px; height: 40px;"></div>
            </div>

            <!-- Add to Cart + Wishlist -->
            <div class="d-flex align-items-center mb-4">
              <div class="skeleton rounded flex-grow-1 mr-2" style="height: 48px;"></div>
              <div class="skeleton rounded" style="width: 48px; height: 48px;"></div>
            </div>

            <!-- Description -->
            <div class="skeleton rounded mb-2" style="height: 20px; width: 60%;"></div>
            <div class="skeleton rounded mb-2" style="height: 20px; width: 80%;"></div>
            <div class="skeleton rounded" style="height: 20px; width: 70%;"></div>
          </div>
        </div>
      </div>
</template>
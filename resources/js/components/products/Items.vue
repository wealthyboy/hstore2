<template>
<div :class="layout">
  <div class="product-default inner-quickview inner-icon position-relative">
    <figure class="position-relative" style="width:100%; height:auto; overflow:hidden;">
      <a
        :href="product.link"
        class="d-block position-relative w-100 h-100"
        style="background:#f5f5f5;"
      >
        <transition name="fade">
          <img
            v-show="imageLoaded"
            :src="product.image_to_show_m"
            :alt="product.product_name"
            class="w-100 h-100"
            style="object-fit:cover;"
            @load="onImageLoad"
            @error="onImageError"
          />
        </transition>

        <!-- Placeholder -->
        <div
          v-if="!imageLoaded"
          class="w-100 h-100 d-flex align-items-center justify-content-center text-uppercase font-weight-bold text-muted position-absolute top-0 left-0"
          style="background:#eaeaea; font-size: 1rem; letter-spacing: 1px;"
        >
          TheAuraByDora
        </div>
      </a>

      <!-- Discount Badge -->
      <div
        v-if="product.default_percentage_off"
        class="badge badge-danger position-absolute"
        style="top: 10px; left: 10px; font-size: 0.8rem; padding: 6px 10px; border-radius: 50px;"
      >
        -{{ product.default_percentage_off }}%
      </div>

      <div
        @click="addToWishList(product.id)"

        class="wishlist-icon position-absolute"
        style="top: 10px; right: 10px; cursor: pointer;"
      >
        <!-- Outlined heart -->
        <svg
          v-if="!is_wishlist"
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
        >
          <path
            d="M19.6706 5.4736C17.6806 3.8336 14.7206 4.1236 12.8906 5.9536L12.0006 6.8436L11.1106 5.9536C9.29063 4.1336 6.32064 3.8336 4.33064 5.4736C2.05064 7.3536 1.93063 10.7436 3.97063 12.7836L11.6406 20.4536C11.8406 20.6536 12.1506 20.6536 12.3506 20.4536L20.0206 12.7836C22.0706 10.7436 21.9506 7.3636 19.6706 5.4736Z"
            stroke="currentColor"
            stroke-miterlimit="10"
            stroke-linecap="round"
            stroke-linejoin="round"
          />
        </svg>

        <!-- Filled heart -->
        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="black"
        >
          <path
            d="M19.6706 5.4736C17.6806 3.8336 14.7206 4.1236 12.8906 5.9536L12.0006 6.8436L11.1106 5.9536C9.29063 4.1336 6.32064 3.8336 4.33064 5.4736C2.05064 7.3536 1.93063 10.7436 3.97063 12.7836L11.6406 20.4536C11.8406 20.6536 12.1506 20.6536 12.3506 20.4536L20.0206 12.7836C22.0706 10.7436 21.9506 7.3636 19.6706 5.4736Z"
          />
        </svg>
      </div>

      <!-- Quick Buy Button (overlay, bottom) -->
      <div class="quick-buy-overlay position-absolute w-100 text-center">
        <button
          class="btn btn-sm btn--primary w-100 py-4"
          @click.prevent="openQuickBuy(product)"
        >
          <i class="fas fa-bolt mr-1"></i> Quick Buy
        </button>
      </div>
    </figure>

    <!-- Product Details -->
    <div class="product-details">
      <div>
        <div class="justify-content-between d-flex mb-1">
          <!-- Ratings -->
          <div class="ratings-container" v-if="product.average_rating_count >= 1">
            <div class="product-ratings">
              <span
                class="ratings"
                :style="{ width: product.average_rating + '%' }"
              ></span>
            </div>
          </div>
        </div>

          <div class="d-flex mb-1">
            <div
              v-for="(color, index) in product.product.colours"
              :key="index"
              class="mr-1 cursor-pointer"
              @click="getColorImage(product, color)"
              :style="{
                border:
                  (product.active_color.name === color.name ? '2px' : '0px') + ' solid #000',
                height: '18px',
                width: '18px',
                borderRadius: '50%',
                backgroundColor: color.image ? '' : color.color_code,
                backgroundImage: color.image ? `url(${color.image})` : 'none',
                backgroundSize: color.image ? 'cover' : 'initial',
              }"
            ></div>
        </div>

        <!-- Name + Price -->
        <div class="d-sm-flex color--primary justify-content-between align-items-center">
          <div class="cl">
            <div class="text-left mr-md-5">
               <a :href="product.link">{{ product.name }}</a>
            </div>
          </div>

          <div v-if="!product.is_gift_card" class="text-lg-right">
            <template v-if="product.default_discounted_price">
              <span class="old-price bold text-muted">
                {{ product.currency }}{{ formatNumber(product.converted_price) }}
              </span>
              <span class="product-price bold text-danger">
                {{ product.currency }}{{ formatNumber(product.default_discounted_price) }}
              </span>
            </template>
            <template v-else>
              <span class="product-price bold">
                {{ product.currency }}{{ formatNumber(product.converted_price) }}
              </span>
            </template>
          </div>
        </div>

        <!-- Colors -->
      
      </div>
    </div>
  </div>

  <QuickBuyModal :show="showQuickBuy" @close="showQuickBuy = false">
      <QuickBuySkelenton v-if="quickBuyIsLoading" />
      <QuickBuy @product-added="showQuickBuy = false" v-if="!quickBuyIsLoading"  :attributes="attributes" :stock="stock" :inventory="inventory"  :product="product_variation" />
  </QuickBuyModal>

  <LoginModal :show="showLogin" @update:show="close"  />

</div>
 

</template>

<script>
import  { mapGetters,mapActions } from 'vuex'
import  LoginModal from '../auth/LoginModal.vue'
import QuickBuyModal from "./QuickBuyModal.vue";
import QuickBuySkelenton from "./QuickBuySkelenton.vue";
import QuickBuy from "./QuickBuy.vue";




export default {
    props:{
        product:Object,
        category:Object,
        user: Object,
        layout: String
    }, 
    components:{
       LoginModal,
       QuickBuyModal,
       QuickBuySkelenton,
       QuickBuy
    },
    data(){
      return {
        product_variation_id: '',
        is_wishlist: this.product.item_is_wishlist,
        showQuickBuy: false,
        quickBuyIsLoading: true,
        attributes: {},
        product_variation: {},
        stock: null,
        inventory: [],
        wishA: {
            background: '#222',
            color: '#ffffff'
        },
        imageLoaded: false,
        showLogin: false,
        
      }
    },
    watch: {
        'product.image_to_show_m': {
          handler(src) {
            if (src) {
              const img = new Image();
              img.src = src;
              if (img.complete) {
                this.imageLoaded = true;
              }
            }
          },
          immediate: true
        }
      },
    computed: {
        ...mapGetters({
            loggedIn:'loggedIn',
            wishlist:'wishlist',
        }),
        rowClass: function () {
           return 'col-lg-4 col-md-4'
        },
    
        wishlistIsActive: function(){
            if (this.wishlist.length){
                if(this.wishlist.some(wishlist => wishlist.product_variation.id === this.product.default_variation_id)){
                   return '#222';
                }
            }
            
            return false;
        }
    },
    created(){
       console.log(this.product)
    },
   
    methods: {
      onImageLoad() {
        this.imageLoaded = true
      },

      close(){
        this.showLogin = false
      },
    
      openQuickBuy(product) {
        this.showQuickBuy = true;
         axios.get(product.link)
          .then(response => {
            let res = response.data
            this.quickBuyIsLoading = false
            this.attributes = res.attributes
            this.product_variation = res.product_variation
            this.stock = res.stock
            this.inventory = res.inventory
          })
          .catch(err => {
            this.quickBuyIsLoading = false
          });
        console.log(product)
      },
        
      onImageError() {
        this.imageLoaded = false
      },
        ...mapActions({
            addProductToWishList: 'addProductToWishList'
        }),
        addToWishList: function(product_variation_id){
            this.showLogin = true
            if (this.is_wishlist) {
                this.is_wishlist = false
            }

            this.addProductToWishList({
                product_variation_id:product_variation_id,
            }).then((response)=>{
                if( this.wishlist.some(wishlist => wishlist.product_variation.id === product_variation_id) ){
                  this.is_wishlist = true
                  $("#addCartModal").modal('show') 
                }
            })
        },
        formatNumber(value) {
          if (!value) return 0;
          return new Intl.NumberFormat().format(value);
        },

        getColorImage(product, color){
          console.log(product, color)
          const url = window.location.href;

          axios.get(url, { 
              params: {
                product_id: product.product.id,
                color: color.name
              }
          })
          .then(response => {
            let res = response.data.product_variation;
              product.image_to_show_m = res.product_variation.image_to_show_m;
              product.active_color = res.product_variation.active_color;
            
          })
          .catch(err => {
            console.error(err);
          });
        },
        


    },
    
}
</script>
<style scoped>
.cursor-pointer{
  cursor: pointer;
}
/* Fade-in transition */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.quick-buy-overlay {
  bottom: 0;
  opacity: 0;
  transform: translateY(100%);
  transition: all 0.35s ease;
  padding: 10px;
}

.product-default:hover .quick-buy-overlay {
  opacity: 1;
  transform: translateY(0);
}

.quick-buy-overlay button {
  border-radius: 30px; /* pill style */
  font-weight: 600;
  padding: 8px 20px;
  transition: all 0.25s ease;
}

.quick-buy-overlay button:hover {
  background-color: #000; /* accent color */
  border-color: #000;
  transform: scale(1.05);
}


  /* Skeleton shimmer animation */
  .skeleton {
    position: relative;
    overflow: hidden;
    background: #e0e0e0;
  }
  .skeleton::after {
    content: "";
    position: absolute;
    top: 0;
    left: -150px;
    height: 100%;
    width: 150px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 1.5s infinite;
  }
  @keyframes shimmer {
    100% {
      transform: translateX(100%);
    }
  }


</style>

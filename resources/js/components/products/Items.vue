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

          <!-- Placeholder (shows until image loads) -->
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
      </figure>

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

          <!-- Name + Price -->
          <div class="d-sm-flex color--primary justify-content-between">
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
          <div class="d-sm-flex mt-1">
            <div
              v-for="(color, index) in product.product.colours"
              :key="index"
              class="mr-1 cursor-pointer"
              @click="getColorImage(product, color)"
              :style="{
                border:
                  ( product.active_color.name  === color.name
                    ? '2px'
                    : '0px') + ' solid #000',
                height: '18px',
                width: '18px',
                borderRadius: '50%',
                backgroundColor: color.image ? '' : color.color_code,
                backgroundImage: color.image ? `url(${color.image})` : 'none',
                backgroundSize: color.image ? 'cover' : 'initial',
              }"
            >
          </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import  { mapGetters,mapActions } from 'vuex'
import  LoginModal from '../auth/LoginModal.vue'


export default {
    props:{
        product:Object,
        category:Object,
        user: Object,
        layout: String
    }, 
    components:{
       LoginModal
    },
    data(){
      return {
        product_variation_id: '',
        is_wishlist: this.product.item_is_wishlist,
        wishA: {
            background: '#222',
            color: '#ffffff'
        },
        imageLoaded: false
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
      onImageError() {
        this.imageLoaded = false
      },
        ...mapActions({
            addProductToWishList: 'addProductToWishList'
        }),
        addToWishList: function(product_variation_id){
            this.addProductToWishList({
                product_variation_id:product_variation_id,
            }).then((response)=>{
                if(this.wishlist.some(wishlist => wishlist.product_variation.id === product_variation_id)){
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
</style>

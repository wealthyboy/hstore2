<template>
  <div class="">
    <div class="product-single-container product-single-default">
      <div class="row">
           
        <div class="col-md-1 product-single-gallery d-none d-lg-block ">

          <div  v-if="images.length > 5"  class="arrow-btn text-center arrow-up" @click="scrollUp">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 8l6 6H6z"/>
            </svg>
          </div>
             
          <div ref="thumbContainer"  class="prod-thumbnail carousel-custom-dots owl-dots   quick-view" id="carousel-custom-dots">
            <div class="owl-dot">
              <img class="animated" @click.prevent="currentSlide(product.image_to_show)" :src="image_m" />
            </div>
            <div @click.prevent="currentSlide(image.image)" v-for="image in images" :key="image.id" class="owl-dot">
              <img :src="image.image_m" :alt="image.image_m" />
            </div>
          </div>

            <div v-if="images.length > 5" class="text-center cursor-pointer" @click="scrollDown">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="black" viewBox="0 0 24 24">
                <path d="M12 16l-6-6h12z"/>
              </svg>
            </div>
           
        </div>
       

        <!-- <images :images="images" :image="image" /> -->
        <div class="col-md-6 product-single-gallery m-0">
          <div class="product-slider-container">
            <div class="product-single-carousel owl-carousel owl-theme">
              <div class="product-item">
                <img class="product-single-image" :data-zoom-image="image" :src="image" />
              </div>
              <div v-for="image in images" :key="image.id" class="product-item">
                <img class="product-single-image" :data-zoom-image="image.image" :src="image.image"
                  v-if="image.image !== ''" :alt="image.image_m" />
              </div>
            </div>
          </div>
        </div>

        <!-- End .product-single-gallery -->
        <div class="d-none d-xs-block d-block d-lg-none d-sm-block d-md-none mx-4 mb-2 mobile">
          <div class="prod-thumbnail d-flex carousel-custom-dots carousel-custom-dots-mobile owl-dots" id="carousel-custom-dots">
            <div class="owl-dot mr-1">
              <img class="animated" @click.prevent="currentSlide(product.image_to_show)" :src="image_m" />
            </div>
            <div @click.prevent="currentSlide(image.image)" v-for="image in images" :key="image.id" class="owl-dot">
              <img :src="image.image_m" :alt="image.image_m" />
            </div>
          </div>
        </div>

        <div class="col-md-5 product-single-details">
          <price 
              :percentage_off="percentage_off" 
              :price="price" 
              :product="product" 
              :name="name"
              :discounted_price="discounted_price" 
             
          />

          <div class="clearfix"></div>

          <div class="">
            <!--Product Variations Form-->
            <product-attributes v-if="!product.is_gift_card" @productAttributeChange="getAttribute"
              :attributes="attributes" :attributesData="attributesData" :inventory="inventory" :stock="stock"
              :product="product" :color="color" :qty="qty" :quantity="quantity" />

            <gift-card-form v-if="product.is_gift_card" :product="product" />

            <div v-if="!product.is_gift_card" class="row no-gutters mb-2 d-fle align-items-center justify-content-between px-1">
              <div v-if="cartError" class="text-danger text-center bold col-12">
                {{ cartError }}
              </div>
               <div v-if="!product.is_gift_card" class="col-2">
                <div class="d-flex align-items-center  rounded-md">
                <a
                  href="#"
                  role="button"
                  class="px-3 py-3 cursor-pointer text-lg font-bold text-gray-600 hover:bg-gray-100"
                  @click.prevent="decrement"
                >
                  −
                </a>
                <span class="px-4 py-2 text-base font-semibold text-gray-800 border-l border-r">
                  {{ quantity_count }}
                </span>
                <a
                  href="#"
                  role="button"
                  class="px-3 py-3 text-lg font-bold text-gray-600 hover:bg-gray-100"
                  @click.prevent="increment"
                >
                  +
                 </a>
              </div>
              </div>
         
              <div v-if="!product.is_gift_card" class="col-8 ml-1">
                <cart-button :loading="loading" :canAddToCart="canAddToCart" :cartText="cartText" @add="addToCart" />
              </div>

              <wishlist 
                v-if="!product.is_gift_card" 
                @wishlistChange="addToWishList" 
                :wishlistText="wishlistText" 
              />
            </div>
          </div>
          <!-- End .product-filters-container -->
          <description :product="product" />
          <!-- End .product-single-tabs -->
        </div>
        <!-- End .product-single-details -->
      </div>
      <!-- End .row -->


    </div>
    <!-- End .product-single-container -->
    <reviews :product="product" :meta="meta" :reviews="reviews" />


    <register-modal />
    <out-of-stock :product_variation="product_variation" />
  </div>
</template>
<script>
import Description from "./Description.vue";

import Reviews from "./Reviews.vue";
import LoginModal from "../auth/LoginModal.vue";
import Price from "./Price.vue";
import RegisterModal from "../auth/RegisterModal.vue";
import OutOfStock from "../newsletter/OutOfStock.vue";
import { mapGetters, mapActions } from "vuex";
import Pagination from "../pagination/Pagination.vue";
import SizeGuide from "./SizeGuide.vue";
import Notify from "./Notify.vue";
import ProductAttributes from "./ProductAttributes.vue";
import Wishlist from "./Wishlist.vue";
import GiftCardForm from "./GiftCardForm.vue";
import CartButton from "./AddToCartButton.vue";

export default {
  name: "Show",
  props: {
    product: Object,
    attributes: Object,
    inventory: Array,
    stock: Array,
  },
  components: {
    Description,
    LoginModal,
    Pagination,
    RegisterModal,
    Reviews,
    OutOfStock,
    SizeGuide,
    Price,
    ProductAttributes,
    Notify,
    Wishlist,
    GiftCardForm,
    CartButton,
  },

  data() {
    return {
      allowSizeGuide: false,
      showMsg: false,
      name: null,
      attributesData: [],
      color: "",
      isActive: false,
      canNotAddToCart: false,
      image: "",
      cText: "Add To Cart",
      images: [],
      variant_images: [],
      noRating: false,
      user: Window.auth,
      file: null,
      useUrl: false,
      price: null,
      discounted_price: null,
      percentage_off: "",
      product_variation_id: "",
      product_variation: null,
      prodAttributes: null,
      category: "",
      cartSideBarOpen: false,
      loading: false,
      is_loggeIn: false,
      is_wishlist: null,
      quantity: 0,
      testn: "x",
      image_m: "",
      image_tn: null,
      profile_photo: null,
      errorsBag: [],
      otherAttrPresent: false,
      fadeIn: false,
      product_slug: this.product.slug,
      wishlistText: false,
      cartError: null,
      quantity_count: 1,
      form: {
        description: null,
        rating: null,
        product_id: this.product.id,
        image: null,
        title: null,
      },
      submiting: false,
      styleObject: {
        "background-color": "red",
      },
    };
  },
  computed: {
    ...mapGetters({
      cart: "cart",
      loggedIn: "loggedIn",
      wishlist: "wishlist",
      reviews: "reviews",
      meta: "reviewsMeta",
      errors: "errors",
      message: "message",
    }),
    qty() {
      return this.quantity == 1 ? "Only 1 left" : "";
    },
    activeObject: function () {
      return {
        "active-attributes": this.isActive,
      };
    },
    cartText: function () {
      return this.cText;
    },
    canAddToCart: function () {
      return [this.canNotAddToCart ? "disabled" : ""];
    },
    removeSpace: function (str) {
      return str.replace(/\s/g, "");
    },
    loggedIn: function () {
      return [this.user ? true : false];
    },
  },

  mounted() {
    this.productReviews();
    this.product_variation = this.product;
    this.image = this.product.image_to_show;
    this.image_tn = this.product.image_to_show_tn;
    this.image_m = this.product.image_m;

    this.images = this.product.images;
    this.product_variation_id = this.product.id;
    this.percentage_off = this.product.default_percentage_off;
    this.quantity = this.product.quantity;
    this.cText =
      this.product.quantity < 1 ? "Item is sold out" : " Add To Cart";
    this.price = this.product.converted_price;
    this.discounted_price = this.product.default_discounted_price;
    this.is_wishlist = this.product.is_wishlist;
    this.name = this.product.name;
    let other_attribute = document.querySelectorAll(".other-attribute");
    let first_attribute = document.querySelector(".active-attribute");

    let styles = {
      pointerEvents: "none",
      textDecoration: "line-through",
      backgroundColor: "#999",
      color: "#fff",
      backgroundImage: "url(/img/outofstock.svg)",
      backgroundPosition: "center",
      backgroundRepeat: "no-repeat",
    };

    if (other_attribute.length) {
      other_attribute.forEach((element) => {
        try {
          let st = this.stock[0][
            first_attribute.dataset.value + "_" + element.dataset.value
          ];
          if (st.quantity === 0) {
            Object.assign(
              document.getElementById(element.dataset.value).style,
              styles
            );
          } else {
          }
        } catch (error) { }
      });
    }
  },
  methods: {
    getStarRating(e, rating) {
      this.form.rating = rating;
      this.noRating = false;
      let ratings = document.querySelectorAll(".rating");
      ratings.forEach((elm) => {
        elm.classList.remove("active");
      });
      e.target.classList.add("active");
    },
    productReviews() {
      return axios
        .get("/reviews/" + this.product.product.id)
        .then((response) => {
          this.loading = false;
          this.$store.commit("setReviews", response.data.data);
          this.$store.commit("setReviewsMeta", response.data.meta);
        })
        .catch((error) => {
          this.loading = false;
        });
    },

    increment: function() {
      quantity_count++;
    },  

   

    currentSlide: function (image) {
      this.fadeIn = !this.fadeIn;
      this.image = image;
     
      setTimeout(() => {
        this.fadeIn = !this.fadeIn;
      }, 1000); // Will alert once, after a second.
    },

    increment() {
      if (this.quantity_count > this.quantity) { return; }

      this.quantity_count++;
    },
    decrement() {
      if (this.quantity_count > 1) {
        this.quantity_count--;
      }
    },

    getAttribute: function ({ vTs, key }) {
      try {
        this.product_variation = vTs;
        this.name = vTs.name ?? this.name;
        this.quantity = vTs.quantity;
        this.price = vTs.converted_price;
        this.percentage_off = vTs.percentage_off;
        this.discounted_price =
          vTs.discounted_price || vTs.default_discounted_price;
        this.product_variation_id = vTs.id;
        this.canNotAddToCart = false;
        this.cText = this.quantity >= 1 ? "Add To Cart" : "Item is sold out";
        console.log(vTs);

        if (key == "Colors") {
          if (vTs.image) {
            this.image = vTs.image;
            this.image_m = vTs.image_m;
            this.images = vTs.images;
          }
        }
      } catch (error) {
        console.log(error);
        this.canNotAddToCart = true;
        this.cText = "Sold Out";
        this.quantity = 0;
      }
    },
    ...mapActions({
      addProductToCart: "addProductToCart",
      addProductToWishList: "addProductToWishList",
      createReviews: "createReviews",
      validateForm: "validateForm",
      clearErrors: "clearErrors",
      checkInput: "checkInput",
      getReviews: "getReviews",
    }),
    addToCart: function () {
      let qty = this.quantity_count;

      if (this.cText === 'Item is sold out') {
        return;
      }

      this.cText = "Adding....";
      this.loading = true;
      this.addProductToCart({
        product_variation_id: this.product_variation_id,
        quantity: qty,
      })
        .then(() => {
          this.cText = "Add To Cart";
          this.loading = false;
        })
        .catch((error) => {
          this.cText = "Add To Cart";
          this.loading = false;
        });


    },
    addToWishList: function () {
      this.wishlistText = true;
      this.addProductToWishList({
        product_variation_id: this.product_variation_id,
      }).then((response) => {
        this.wishlistText = false;
        if (
          this.wishlist.some(
            (wishlist) =>
              wishlist.product_variation.id === this.product_variation_id
          )
        ) {
          this.is_wishlist = true;
          return;
        }
        this.is_wishlist = false;
      });
    },
    scrollUp() {
      this.$refs.thumbContainer.scrollBy({
        top: -100,
        behavior: "smooth"
      });
    },
    scrollDown() {
      this.$refs.thumbContainer.scrollBy({
        top: 150,
        behavior: "smooth"
      });
    },
    currentSlide(image) {
      this.currentImage = image;
    },
    submitReview() {
      let input = document.querySelectorAll(".rating_required");
      this.validateForm({ context: this, input: input });

      console.log(this.errors);
      if (!this.form.rating) {
        this.noRating = true;
        return false;
      }

      if (Object.keys(this.errors).length !== 0) {
        return false;
      }

      this.submiting = true;
      let form = new FormData();
      form.append("description", this.form.description);
      form.append("title", this.form.title);
      form.append("rating", this.form.rating);
      form.append("product_id", this.product.product_id);
      form.append("product_variation_id", this.product.id);
      this.createReviews({ context: this, form });
    },
  },
};
</script>
<style scoped>
 .mt-4 {
   margin-left: 1.8rem !important;
 }

 .quick-view {
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 450px;
  position: relative;
}

#carousel-custom-dots {
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
  scroll-behavior: smooth;
}

.owl-dot {
  margin: 5px 0;
}

.arrow-btn {
  cursor: pointer;
  padding: 6px;
  color: #666;
  transition: color 0.2s ease;
}

.arrow-btn:hover {
  color: #000;
}

#carousel-custom-dots {
  margin-top: -4.5px !important;
}

</style>


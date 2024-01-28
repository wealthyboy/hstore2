<template>
  <div class="">
    <div class="product-single-container product-single-default">
      <div class="row">
        <div class="col-md-1 product-single-gallery d-none d-lg-block">
          <div class="prod-thumbnail carousel-custom-dots owl-dots" id="carousel-custom-dots">
            <div class="owl-dot">
              <img class="animated" @click.prevent="currentSlide(product.image_to_show)" :src="image_tn" />
            </div>
            <div @click.prevent="currentSlide(image.image)" v-for="image in images" :key="image.id" class="owl-dot">
              <img :src="image.image_tn" :alt="image.image_tn" />
            </div>
          </div>
        </div>

        <!-- <images :images="images" :image="image" /> -->
        <div class="col-md-6 product-single-gallery">
          <div class="product-slider-container">
            <div class="product-single-carousel owl-carousel owl-theme">
              <div class="product-item">
                <img class="product-single-image" :data-zoom-image="image" :src="image" />
              </div>
              <div v-for="image in images" :key="image.id" class="product-item">
                <img class="product-single-image" :data-zoom-image="image.image" :src="image.image"
                  v-if="image.image !== ''" :alt="image.image_tn" />
              </div>
            </div>
          </div>
        </div>

        <!-- End .product-single-gallery -->
        <div class="d-none d-xs-block d-block d-lg-none d-sm-block d-md-none">
          <div class="prod-thumbnail d-flex carousel-custom-dots owl-dots" id="carousel-custom-dots">
            <div class="owl-dot">
              <img class="animated" @click.prevent="currentSlide(product.image_to_show)" :src="image_tn" />
            </div>
            <div @click.prevent="currentSlide(image.image)" v-for="image in images" :key="image.id" class="owl-dot">
              <img :src="image.image_tn" :alt="image.image_tn" />
            </div>
          </div>
        </div>

        <div class="col-md-5 product-single-details">
          <price :percentage_off="percentage_off" :price="price" :product="product" :name="name"
            :discounted_price="discounted_price" />

          <div class="clearfix"></div>

          <div class="mt-1">
            <!--Product Variations Form-->
            <product-attributes v-if="!product.is_gift_card" @productAttributeChange="getAttribute"
              :attributes="attributes" :attributesData="attributesData" :inventory="inventory" :stock="stock"
              :product="product" :color="color" :qty="qty" :quantity="quantity" />

            <gift-card-form v-if="product.is_gift_card" :product="product" />

            <div v-if="!product.is_gift_card" class="row no-gutters mb-2">
              <div v-if="cartError" class="text-danger text-center bold col-12">
                {{ cartError }}
              </div>
              <div class="col-2 pl-3">
                <div v-if="quantity >= 1" id="quantity_1234" class="select-custom">
                  <select id="add-to-cart-quantity" name="qty" class="form-control">
                    <option v-for="x in parseInt(quantity)">{{ x }}</option>
                  </select>
                </div>
                <div v-else id="quantity_1234" class="">
                  <select id="add-to-cart-quantity" name="qty" class="form-control">
                    <option value=""></option>
                  </select>
                </div>
              </div>

              <div v-if="!product.is_gift_card" class="col-9">
                <cart-button :loading="loading" :canAddToCart="canAddToCart" :cartText="cartText" @add="addToCart" />
              </div>

              <wishlist v-if="!product.is_gift_card" @wishlistChange="addToWishList" :wishlistText="wishlistText" />

              <size-guide v-if="!product.is_gift_card" :attributes="attributes" />
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
    <login-modal />
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
      quantity: null,
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
        .get("/reviews/" + this.product.id)
        .then((response) => {
          this.loading = false;
          this.$store.commit("setReviews", response.data.data);
          this.$store.commit("setReviewsMeta", response.data.meta);
        })
        .catch((error) => {
          this.loading = false;
        });
    },

    currentSlide: function (image) {
      this.fadeIn = !this.fadeIn;
      this.image = image;
      // jQuery(function() {
      //   $(".product-single-default .product-single-carousel").owlCarousel({
      //     nav: 0,
      //     dotsContainer: "#carousel-custom-dots",
      //     autoplay: !1,
      //   });

      //   $(".carousel-custom-dots .owl-dot").click(function() {
      //     $(".product-single-carousel").trigger("to.owl.carousel", [
      //       $(this).index(),
      //       300,
      //     ]);
      //   });
      // });
      setTimeout(() => {
        this.fadeIn = !this.fadeIn;
      }, 1000); // Will alert once, after a second.
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
      let qty = document.getElementById("add-to-cart-quantity").value;

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

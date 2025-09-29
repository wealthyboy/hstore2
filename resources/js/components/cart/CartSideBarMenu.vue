<template>
    <div class="cart-panel position-fixed top-0 right-0 bg--main  shadow-lg h-100 d-flex flex-column" 
     style="width: 400px; z-index: 1050; display: none;">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center border-bottom p-3">
        <h5 class="mb-0">CART</h5>
        <button type="button" class="close" @click="closeCart()">&times;</button>
    </div>
    
  
    
    <!-- Scrollable items -->
    <div class="cart-items flex-grow-1 overflow-auto p-3 bg--main" style="overflow: scroll;max-height: calc(100vh - 180px);">
        
        <!-- Cart Item -->
    <div v-for="cart in carts" :key="cart.id" class="d-flex mb-4">
    <img :src="cart.image"
         :alt="cart.product_name"
         class="img-fluid rounded mr-3"
         style="width:100px; height:120px; object-fit:cover;">
    
    <div class="flex-grow-1">
        <h6 class="mb-1">{{ cart.product_name }}</h6>
        <div class="text-muted small mb-1">
            {{ cart.currency }}{{ cart.price | priceFormat }}
        </div>
        <div v-if="cart.variations.length" class="text-muted small mb-2">
            {{ cart.variations.toString() }}
        </div>

        <!-- Quantity Control -->

        <a href="#" @click.prevent="removeFromCart(cart.id)" class="remove-link">
            Remove
        </a>
    </div>
</div>
<!-- /Cart Item -->


        <div
            class="cart-sidebar-content d-flex justify-content-center"
            v-if="!carts.length"
        >
            <div class="text-center pb-3">
            <img
                width="100"
                height="100"
                alt="You have no items in your cart"
                src="/images/utilities/empty_product.svg"
            />
            <p class="bold">Your cart is empty</p>
            </div>
        </div>



    </div>
    
    <!-- Footer -->
    <div  v-if="carts.length" class="border-top p-3">
        <div class="text-muted small mb-2">Taxes and shipping calculated at checkout</div>
        <a  href="/cart" class="btn btn--primary btn-block border-raduis-btn py-3">
            View Cart
        </a>
        <a href="/checkout" class="btn btn--primary btn-block border-raduis-btn py-3">
            CHECKOUT • <span class="bold text-white">  {{  meta.currency }}{{ meta.sub_total | priceFormat}}</span>
        </a>
    </div>
</div>
</template>

<script>
import  { mapGetters,mapActions } from 'vuex'

export default {
    
     computed: {
        ...mapGetters({
            carts: 'carts',
            meta:  'meta',
            loading:'loading'
        })
    }, 
    mounted(){
       this.getCart()
    },
    methods: {
        ...mapActions({
            getCart:'getCart',
            deleteCart: 'deleteCart',
            getCart:'getCart',
            updateCart: 'updateCart'
        }),
        removeFromCart(cart_id){
            this.deleteCart({
                cart_id:cart_id
            })
        },
        updateCartQty(e,product_variation_id){
            let qty = e.target.value
            this.updateCart({
                product_variation_id: product_variation_id,
                quantity:qty
            })
        },
        closeCart() {
            this.$emit('close-cart')
        }

    }
    
}
</script>
<style scoped>
.btn {
    padding: .5rem 2.2rem;
    font-family: Polaris-Book, sans-serif;
    line-height: 1.429;
}

.quantity-control.mb-2.border {
    width: 137px;
}
</style>
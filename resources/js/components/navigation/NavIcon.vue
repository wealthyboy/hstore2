
<template>
    <div class="header-right w-lg-max ml-0 ml-lg-auto">
        <div class="header-contact d-none d-lg-flex align-items-center ml-auto pr-xl-4 mr-4">
        </div><!-- End .header-contact -->
        
        <a  v-if="!$root.loggedIn" href="/login" class="header-icon pl-1">
            <svg aria-hidden="true" fill="none" focusable="false" width="24" class="header__nav-icon icon icon-account" viewBox="0 0 24 24">
                <path d="M16.125 8.75c-.184 2.478-2.063 4.5-4.125 4.5s-3.944-2.021-4.125-4.5c-.187-2.578 1.64-4.5 4.125-4.5 2.484 0 4.313 1.969 4.125 4.5Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M3.017 20.747C3.783 16.5 7.922 14.25 12 14.25s8.217 2.25 8.984 6.497" stroke="currentColor" stroke-width="1" stroke-miterlimit="10"></path>
            </svg>
        </a>

        <div v-if="$root.loggedIn" class="header-dropdown ml-4">
            <a href="/acoount" class="header-icon  pl-1">
                <svg aria-hidden="true" fill="none" focusable="false" width="24" class="header__nav-icon icon icon-account" viewBox="0 0 24 24">
                    <path d="M16.125 8.75c-.184 2.478-2.063 4.5-4.125 4.5s-3.944-2.021-4.125-4.5c-.187-2.578 1.64-4.5 4.125-4.5 2.484 0 4.313 1.969 4.125 4.5Z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M3.017 20.747C3.783 16.5 7.922 14.25 12 14.25s8.217 2.25 8.984 6.497" stroke="currentColor" stroke-width="1" stroke-miterlimit="10"></path>
                </svg>
            </a>

            <div class="header-menu">
                <ul>  
                    <li><a href="/account"><i class="icon-user-2 left"></i>  Account</a></li>
                    <li><a href="/orders"><i class="fas fa-shopping-cart left"></i> Orders</a></li>
                    <li>
                        <a class="" href="/logout"
                                                onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt left"></i>
                                            
                                            Logout
                                        </a>
                                        <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                            <input type="hidden" name="_token" :value="$root.token">
                                        </form>
                    </li>
                </ul>
            </div><!-- End .header-menu  -->
        </div>
        <a href="/wishlist" class="header-icon  pl-1 pr-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"><path d="M19.6706 5.4736C17.6806 3.8336 14.7206 4.1236 12.8906 5.9536L12.0006 6.8436L11.1106 5.9536C9.29063 4.1336 6.32064 3.8336 4.33064 5.4736C2.05064 7.3536 1.93063 10.7436 3.97063 12.7836L11.6406 20.4536C11.8406 20.6536 12.1506 20.6536 12.3506 20.4536L20.0206 12.7836C22.0706 10.7436 21.9506 7.3636 19.6706 5.4736Z" stroke="currentColor" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </a>

        <a href="#"  @click="openCart" class="header-icon  pl-1 pr-2">
            <svg aria-hidden="true" fill="none" focusable="false" width="24" class="header__nav-icon icon icon-search" viewBox="0 0 24 24">
                <path d="M10.364 3a7.364 7.364 0 1 0 0 14.727 7.364 7.364 0 0 0 0-14.727Z" stroke="currentColor" stroke-width="1" stroke-miterlimit="10"></path>
                <path d="M15.857 15.858 21 21.001" stroke="currentColor" stroke-width="1" stroke-miterlimit="10" stroke-linecap="round"></path>
            </svg>
        </a>

        <div   class="dropdown cart-dropdown">
            <a @click="openCart" href="#" class="dropdown-toggle dropdown-arrow d-none d-lg-block" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                <svg aria-hidden="true" fill="none" focusable="false" width="24" class="header__nav-icon icon icon-cart" viewBox="0 0 24 24"><path d="M4.75 8.25A.75.75 0 0 0 4 9L3 19.125c0 1.418 1.207 2.625 2.625 2.625h12.75c1.418 0 2.625-1.149 2.625-2.566L20 9a.75.75 0 0 0-.75-.75H4.75Zm2.75 0v-1.5a4.5 4.5 0 0 1 4.5-4.5v0a4.5 4.5 0 0 1 4.5 4.5v1.5" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="cart-count badge-circle">{{ cartItemCount }}</span>
            </a>

            <a @click="openCart" href="#" class="dropdown-toggle dropdown-arrow  d-none d-block  d-xl-none  d-lg-none" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                <svg aria-hidden="true" fill="none" focusable="false" width="24" class="header__nav-icon icon icon-cart" viewBox="0 0 24 24"><path d="M4.75 8.25A.75.75 0 0 0 4 9L3 19.125c0 1.418 1.207 2.625 2.625 2.625h12.75c1.418 0 2.625-1.149 2.625-2.566L20 9a.75.75 0 0 0-.75-.75H4.75Zm2.75 0v-1.5a4.5 4.5 0 0 1 4.5-4.5v0a4.5 4.5 0 0 1 4.5 4.5v1.5" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                <span class="cart-count badge-circle">{{ cartItemCount }}</span>
            </a>
            <div class="dropdown-menu">
            </div><!-- End .dropdown-menu -->
        </div><!-- End .dropdown -->

          <transition name="fade">
            <div v-if="showCart" class="overlay" @click="closeCart"></div>
        </transition>

          <transition name="slide" @after-leave="resetPanel">
      <div 
        v-if="showCart" 
        class="cart-panel" 
        @click.stop
      >
        <div class="cart-header">
          <h5>Cart</h5>
          <button @click="closeCart" class="close-btn">×</button>
        </div>
        <div class="cart-body">
          <p>You are eligible for free shipping.</p>
        </div>
      </div>
    </transition>
    </div>

</template>
<script>

import { mapGetters,mapActions } from 'vuex'


import DropDown from '../cart/DropDown'

export default {
    data(){
        return {
          user:Window.auth,
          token:null,
         cartOffcanvas: null,
         showCart: false,
      cartCount: 1

        } 
    },
    components:{
        DropDown,
    },
    computed:{
        ...mapGetters({
            cartItemCount:'cartItemCount',
            wishlistCount:'wishlistCount'
        })
    } ,
    created(){
       this.getWislist()
       let token = document.head.querySelector('meta[name="csrf-token"]');
       this.token = token.content
    },
    mounted() {
    // Initialize Bootstrap Offcanvas
        const element = document.getElementById("cartPanel");
        this.cartOffcanvas = new bootstrap.Offcanvas(element);
    },
    methods:{
        ...mapActions({
             getWislist:'getWislist',
        }),

       openCart() {
        this.showCart = true;
        document.body.style.overflow = "hidden"; // prevent background scroll
    },

    closeCart() {
      this.showCart = false;
      document.body.style.overflow = "auto";
    }
    }
}
</script>
<style scoped>
  .cart-icon {
  position: relative;
  font-size: 24px;
  cursor: pointer;
}
.cart-icon .badge {
  position: absolute;
  top: -8px;
  right: -8px;
  background: red;
  color: white;
  font-size: 12px;
  border-radius: 50%;
  padding: 2px 6px;
}

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 999;
}

.cart-panel {
  position: fixed;
  top: 0;
  right: 0;
  width: 350px;
  height: 100%;
  background: white;
  z-index: 1000;
  display: flex;
  flex-direction: column;
  box-shadow: -2px 0 10px rgba(0,0,0,0.2);
}

.cart-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 16px;
  border-bottom: 1px solid #eee;
}

.cart-body {
  flex: 1;
  padding: 16px;
  overflow-y: auto;
}

.cart-item {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}
.cart-item img {
  width: 60px;
  height: 60px;
  object-fit: cover;
  margin-right: 12px;
}
.item-info h6 {
  margin: 0;
}

.cart-footer {
  padding: 16px;
  border-top: 1px solid #eee;
}
.checkout-btn {
  width: 100%;
  background: black;
  color: white;
  padding: 12px;
  border: none;
  cursor: pointer;
}
.checkout-btn:hover {
  background: #222;
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter {
  transform: translateX(100%);
}
.slide-leave-to {
  transform: translateX(100%);
}
</style>

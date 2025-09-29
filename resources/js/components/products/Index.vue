<template>
  <div class="row">
    <!-- Filter column -->

        <div class="col-md-2" v-if="loading ">
            <div class="mb-3" v-for="n in 5" :key="n">
                <div class="d-flex align-items-center">
                <div class="skeleton-box rounded" style="width: 100%; height: 20px;"></div>
                <div class="skeleton-box rounded ms-auto" style="width: 20px; height: 20px;"></div>
                </div>
            </div>
        </div>

        <div @click="toggleSideBar" class="sidebar-overlay"></div>
        <div class="sidebar-toggle"><i class="fas fa-sliders-h"></i></div>
        <aside  
             
            class="sidebar-shop  order-lg-first mobile-sidebar col-md-2 "
        >
            <div class="pin-wrapper" style="">
                <div class="sidebar-wrapper" style="">
                    <side-bar 
                       @filters-updated="updateProducts" 
                       :categoryFilters="filters" 
                    />
                </div>
            </div>
        </aside><!-- End .col-lg-3 -->

    <!-- Products column -->
    <div class="col-md-10">
        
        <nav class="toolbox horizontal-filter filter-sorts mb-1  sticky-header " data-sticky-options="{'mobile': true}">
            <div class="toolbox-left">
                <div class="pr-1">
                    Showing <strong>{{ meta.from }}</strong> to <strong>{{ meta.to }}</strong> of <strong>{{ meta.total }}</strong> results
                </div>
            </div>


                <div class="toolbox-right">
                    <a @click.prevent="toggleSideBar" href="#" class="sidebar-toggle ">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <!-- Top line -->
                                <line x1="4" y1="6" x2="20" y2="6"></line>
                                <circle cx="9" cy="6" r="2"></circle>
                                
                                <!-- Middle line -->
                                <line x1="4" y1="12" x2="20" y2="12"></line>
                                <circle cx="15" cy="12" r="2"></circle>
                                
                                <!-- Bottom line -->
                                <line x1="4" y1="18" x2="20" y2="18"></line>
                                <circle cx="12" cy="18" r="2"></circle>
                            </svg>

                    </a>
                    <div class="select-custom">
                        <select  name="sort_by" v-model="sortBy"   @change="updateSort" id="sort_by" class="form-control">
                            <option value="" selected="selected">Sort By</option>
                            <option value="created_at,asc">Oldest</option>
                            <option value="created_at,desc">Newest</option>
                            <option value="price,asc">Lowest Price</option>
                            <option value="price,desc">Highest Price</option>
                        </select>
                    </div>
                    <div class="toolbox-item layout-modes">
                        <a  @click.prevent="setLayout('col-6 col-md-4')" href="#" type="button" value="large" class=" bg-transparent mr-3 border-0 cursor-pointer" aria-label="Switch to larger product images"><svg role="presentation" width="18" viewBox="0 0 18 18" fill="none">
                            <path fill="currentColor" d="M0 0h8v8H0zM0 10h8v8H0zM10 0h8v8h-8zM10 10h8v8h-8z"></path>
                            </svg>
                        </a>
                        <a href="#" @click.prevent="setLayout('col-6 col-md-3')" type="button" value="medium" class="bg-transparent mr-3 cursor-pointer border-0" aria-label="Switch to smaller product images">
                            <svg role="presentation" width="18" viewBox="0 0 18 18" fill="none">
                                <path fill="currentColor" d="M0 0h4v4H0zM0 7h4v4H0zM0 14h4v4H0zM7 0h4v4H7zM7 7h4v4H7zM7 14h4v4H7zM14 0h4v4h-4zM14 7h4v4h-4zM14 14h4v4h-4z"></path>
                            </svg>
                        </a>
                        <a href="#"  @click.prevent="setLayout('col-6 col-md-2')" type="button" value="compact" class="bg-transparent border-0  cursor-pointer" aria-label="Switch to compact product images">
                            <svg role="presentation" width="18" viewBox="0 0 18 18" fill="none">
                                <path fill="currentColor" d="M0 0h18v2H0zm0 4h18v2H0zm0 4h18v2H0zm0 4h18v2H0zm0 4h18v2H0z"></path>
                            </svg>
                        </a>       
                    </div>
            </div>

        </nav>
      

        <div v-if="loading" class="row">
            <div
                v-for="n in skeletonCount"
                :key="n"
                class="col-6 col-md-4 mb-4">
                <div class="product-skeleton card">
                    <div class="skeleton-image d-flex align-items-center justify-content-center">
                    <span class="site-name">{{ siteName }}</span>
                    </div>
                    <div class="card-body p-2">
                    <div class="skeleton-line mb-2"></div>
                    <div class="skeleton-line short"></div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="!loading && items.length" class="row">
                <items
                    v-for="(product, index) in items"
                    :key="product.id"
                    :user="user"
                    :product="product"
                    :layout="layout"
                    :category="category"
                    :style="{
                        transitionDelay: (index * 200) + 'ms',  /* 200ms per item */
                        transitionDuration: '600ms'             /* each animation lasts longer */
                    }"
                />    

        </div>
        <template v-if="!loading && !items.length">
            <section style="height: 100vh;" class="sec-padding">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 text-center raised">
                            <div class="mt-4 mb-4">
                                No products found
                            </div>
                        </div>  
                    </div>
                </div>
            </section>
        </template>

          <div v-if="meta.total > meta.per_page" class="pagination-wraper">
            <div class="pagination">
                <ul class="pagination-numbers w-100">
                    <pagination   :useUrl="true" :meta="meta" />
                </ul>
            </div>
        </div>
    </div>
  </div>
</template>

<script>

import  SideBar from './SideBar.vue'
import  Items from './Items.vue'
import  Pagination from '../pagination/Pagination.vue'


export default {
    name: "Index",
    props:{
        category: Object,
        endpoint:Object,
        user:Object,
        products: Object,
        filters: Array,
        skeletonCount: {
          type: Number,
                default: 12, // how many skeletons to show
            },
            siteName: {
                type: String,
                default: "TheAuraByDora", // replace with ENV or config
            },
            gridType: {
                type: String,
                default: "col-md-4 col-6", // 3 per row by default
            },
    },
    components:{
        SideBar,
        Items,
        Pagination
    },
    data(){
        return {
           meta:{},
           items: [],
           has_filters: 0,
           full_width: false,
           loading:true,
           categories: [],
           layout: 'col-md-4 col-6',
           sortBy: ''
        }
    },
    computed: {
        classObject: function () {
            return {
               full_width:  this.has_filters > 0
            }
        },
        gridClass() {
          return this.gridType
        },
    },
    watch: {
        '$route.query':{
            handler(query){
              // this.getProducts(this.$route.query.page,query)
            },
            deep:true
        },
    },
    mounted(){
        this.loading = true;
        this.getProducts().then(() => {})
    },
    methods: {
        setLayout(mode) {
            this.layout = mode;
        },
        updateProducts(filters) {
            let path = window.location.pathname + window.location.search;

            // Prepend "/api"
            let apiUrl = "/api" + path;

            this.loading = true


            return axios.get(apiUrl).then((response) => {
                    this.items = response.data.products.data;
                    this.meta = response.data.products;
                    this.loading = false
                    this.has_filters = response.data.has_filters;
                    let productId = ''


                }).catch(() => {
                    this.loading = false
                });
        },
        toggleSideBar() {
            $("body").toggleClass("sidebar-opened");
        },
        updateSort() {
            const url = new URL(window.location.href);
            if (this.sortBy) {
                url.searchParams.set("sort_by", this.sortBy);
            } else {
                url.searchParams.delete("sort_by");
            }

            // ✅ Update the URL in the browser without reload
            window.history.replaceState({}, "", url);

            this.getProducts();
        },
        getProducts(page = this.$route.query.page, filters = this.$route.query) {
            let category = this.$route.params.category;

            console.log(this.$route. filters)
            let url = `/api${this.$route.fullPath}`;

            console.log(url)

                return axios.get(url).then((response) => {
                    this.items = response.data.products.data;
                    this.meta = response.data.products;
                    this.loading = false
                    this.has_filters = response.data.has_filters;
                    let productId = ''


                }).catch(() => {
                    this.loading = true
                });
            }
        },
        filterP(filter) {
            console.log(filter)    
        }
        
    
}

</script>
<style scoped>
.stagger-enter-active {
  transition: all 0.6s ease;
}

.stagger-leave-active {
  transition: all 0.4s ease;
  position: absolute;
}

.stagger-enter-from {
  opacity: 0;
  transform: translateY(30px);
}

.stagger-enter-to {
  opacity: 1;
  transform: translateY(0);
}

.stagger-leave-from {
  opacity: 1;
  transform: translateY(0);
}

.stagger-leave-to {
  opacity: 0;
  transform: translateY(20px);
}


.product-skeleton {
  border: 1px solid #eee;
  border-radius: 6px;
  overflow: hidden;
  background: #fff;
}

.skeleton-image {
  width: 100%;
  height: 350px;
  background: #f0f0f0;
}

.site-name {
  font-weight: 600;
  font-size: 18px;
  color: #aaa;
  text-transform: uppercase;
}

.skeleton-line {
  height: 14px;
  background: #e0e0e0;
  border-radius: 4px;
}

.skeleton-line.short {
  width: 60%;
}

.skeleton-box {
  display: inline-block;
  background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 37%, #e0e0e0 63%);
  background-size: 400% 100%;
  animation: shimmer 1.4s ease infinite;
}
@keyframes shimmer {
  0% { background-position: -400px 0; }
  100% { background-position: 400px 0; }
}
</style>
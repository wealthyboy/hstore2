<template>
  <form id="collections">
    <!-- Price Widget -->
    <div class="widget">
      <h3 class="widget-title">
        <a
          data-toggle="collapse"
          href="#widget-prices"
          role="button"
          class="bold"
          aria-expanded="true"
          aria-controls="widget-prices"
        >
          Prices
        </a>
      </h3>
      <div id="widget-prices" class="collapse show">
        <div class="widget-body">
          <ul class="cat-list">
            <li v-for="(price, index) in priceOptions" :key="index">
              <div class="checkbox">
                <label :for="'price-' + price.value" class="checkbox-label">
                  <input
                    :id="'price-' + price.value"
                    name="prices[]"
                    type="checkbox"
                    class="filter-product"
                    :value="price.value"
                    v-model="selected.prices"
                  />
                  <span class="checkbox-custom rectangular"></span>
                  <span class="checkbox-label-text">{{ price.label }}</span>
                </label>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Dynamic Categories -->
    <div
      v-for="category in categories"
      :key="category.id"
      class="widget"
    >
      <h3 class="widget-title">
        <a
          class="collapsed bold"
          :data-toggle="'collapse'"
          :href="'#widget-body-' + category.id"
          role="button"
          aria-expanded="false"
          :aria-controls="'widget-body-' + category.id"
        >
          {{ category.attribute?.name || category.name }}
        </a>
      </h3>
      <div
        class="collapse"
        :id="'widget-body-' + category.id"
      >
        <div class="widget-body">
          <ul
            class="cat-list"
            :class="{ 'widget-scroll': category.children.length > 6 }"
          >
            <li
              v-for="child in category.children"
              :key="child.id"
            > 
              <div v-if="child.name  != ''"  class="checkbox">
                <label
                  :for="`box-${child.id}`"
                  class="checkbox-label"
                >
                  <input
                    type="checkbox"
                    class="filter-product"
                    :id="`box-${child.id}`"
                    @change="activateFilter"

                    :name="`${slugify(category.name)}[]`"
                    :value="child.attribute?.slug"
                  />
                  <span class="checkbox-custom rectangular"></span>
                  <span class="checkbox-label-text color--primary">
                    {{ child.attribute?.name  }} {{ child.slug }}
                  </span>
                </label>
              </div>

            </li>
          </ul>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
    props:{
       category: Object,
       categories: Array
    },
    data(){
        return {
            isOpen: false,
            filters:[],
            selectedFilters: _.omit(this.$route.query, ['page']),
            qS: [],
            filter: true,
            priceOptions: [
                { value: 2500, label: "Less Than 2500" },
                { value: 5000, label: "Less Than 5000" },
                { value: 10000, label: "Less Than 10000" },
                { value: "10000+", label: "More than 10,000" }
            ],
            selected: {
                prices: []
            }
        }  
    },
   
    created(){
      
    },
    mounted(){
        let path = this.$route.path
        this.selected = { ...this.initialFilters };

        axios.get("/api/filters" +path).then((response) => {
            this.filters = response.data.data
           // this.categories = response.data.data
        })
         
    },
    methods:{
        slugify(text) {
        return text
            .toLowerCase()
            .replace(/\s+/g, "_") // spaces → underscores
            .replace(/[^a-z0-9_]/g, ""); // strip anything else
        },
        toggleAccordion(){
           this.isOpen = !this.isOpen
        },
        activateFilter() {
            const inputs = document.querySelectorAll("input.filter-product:checked");
            let filters = {};

            inputs.forEach(input => {
                if (!filters[input.name]) {
                    filters[input.name] = [];
                }
                filters[input.name].push(input.value);
            });

            this.selectedFilters = filters;
            this.$emit("filters-updated", this.selectedFilters);


            this.updateQueryString();
        },

        updateQueryString() {
            const params = new URLSearchParams();

            Object.keys(this.selectedFilters).forEach(key => {
                this.selectedFilters[key].forEach(val => {
                    params.append(`${key}[]`, val);
                });
            });

            const newUrl = `${window.location.pathname}?${params.toString()}`;
            window.history.replaceState({}, "", newUrl);
        },
       
        updateQueryString () {
            this.$router.replace({
                query: {
                   ...this.selectedFilters,
                }
            })
        }


    },
    computed: {
        accordionClasses: function(){
            return {
                'slideDown': this.isOpen
            }
        }
    }
    
}
</script>

<style>
.slideInDown {
   transition: all 0.4s;
   display: block;
}

</style>
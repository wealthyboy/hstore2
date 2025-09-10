<template>
  <div class="row">
    <div
      v-if="Object.keys(attributes).length !== 0"
      v-for="(map, key) in attributes"
      :key="key"
      class="col-12 mt-2 attrs"
    >
      <label class="d-block">
        Select {{ key }}: <span v-if="key == 'Colors'">{{ color }}</span></label
      >
      <div :id="'productV-' + key" class="d-flex flex-wrap mb-1 mt-1">
        <div
          @click="getAttribute($event, key)"
          :data-name="key"
          @mouseenter="showColor(children)"
          @mouseleave="removeColor"
          :class="[
            index == product.active_color.color_code ? 'active-attribute' : '',
            activeObject,
          ]"
          v-if="key == 'Colors'"
          :data-value="children"
          v-for="(children, index) in map"
          :id="children"
          :key="children"
          :style="{ 'background-color': index }"
          class="mr-2  product-variation-circle first-attribute"
        ></div>
        <template v-if="attributesData.length">
          <div
            @click="getAttribute($event, key)"
            :data-name="key"
            v-if="key != 'Colors'"
            :class="[index == 0 ? 'active-other-attribute' : 'border']"
            :data-value="children"
            :id="children"
            v-for="(children, index) in attributesData"
            :key="children"
            class="mr-1 product-variation-box  d-flex align-items-center justify-content-center  position-relative border pr-3 pl-3 o-a bold pt-1 other-attribute"
          >
            {{ children }}
          </div>
        </template>
        <template v-else>
          <div
            @click="getAttribute($event, key)"
            :data-name="key"
            :class="[index == 0 ? 'active-other-attribute' : '']"
            v-if="key != 'Colors'"
            :data-value="children"
            :data-amount="quantity"
            v-for="(children, index) in map"
            :key="children"
            :id="children"
            class="mr-1 product-variation-box  d-flex align-items-center justify-content-center pt-1 border bold other-attribute"
          >
            {{ children }}
          </div>
        </template>
      </div>
    </div>
    <div class="col-12 mt-1 text-danger bold">{{ qty }}</div>
    <notify 
      :quantity="quantity" 
    />
  </div>
</template>
<script>
import Notify from "./Notify.vue";
export default {
  props: ["attributes", "inventory", "stock", "quantity", "qty", "product"],
  data() {
    return {
      attributesData: [],
      isActive: false,
      color: "",
    };
  },
  components: {
    Notify,
  },
  computed: {
    activeObject: function() {
      return {
        "active-attributes": this.isActive,
      };
    },
  },

  methods: {
    showColor(color) {
      this.color = color;
    },
    removeColor(color) {
      this.color = "";
    },
    getAttribute: function(evt, key) {
      let active_attribute = null,
        variation,
        first_attribute,
        active_other_attribute,
        other_attribute,
        f = false,
        af = false,
        cA;
      let inventory = this.inventory;
      let stock = this.stock;
      first_attribute = document.querySelectorAll(".first-attribute");
      other_attribute = document.querySelectorAll(".other-attribute");
      /**
       * Toggle active statte
       */

      if (evt.target.classList.contains("first-attribute")) {
        first_attribute.forEach(function(elm, key) {
          elm.classList.remove("active-attribute");
        });
        af = true;
        evt.target.classList.add("active-attribute");
      }

      /**
       * Toggle active statte for other attributes
       */
      if (evt.target.classList.contains("other-attribute")) {
        other_attribute.forEach(function(elm, key) {
          elm.classList.remove("active-other-attribute");
        });
        f = true;
        evt.target.classList.add("active-other-attribute");
      }

      try {
        if (typeof inventory[0].length === "undefined") {
          let v = inventory[0][evt.target.dataset.value];
          for (let i in v) {
            if (i !== evt.target.dataset.name) {
              this.attributesData = Object.keys(v[i]);
            }
          }
        }

        const styles = {
          pointerEvents: "none",
          textDecoration: "line-through",
          backgroundColor: "#999",
          color: "#fff",
          backgroundImage: "url(/img/outofstock.svg)",
          backgroundPosition: "center",
          backgroundRepeat: "no-repeat",
        };

        active_attribute = document.querySelector(".active-attribute");
        active_other_attribute = document.querySelector(
          ".active-other-attribute"
        );
        if (active_attribute && this.attributesData.length != 0) {
          variation =
            active_attribute.dataset.value + "_" + this.attributesData[0];
        }
        if (active_attribute && this.attributesData.length == 0) {
          variation = active_attribute.dataset.value;
        }

        if (!active_attribute && active_other_attribute !== null) {
          variation = active_other_attribute.dataset.value;
        }

        if (
          active_attribute &&
          other_attribute.length !== 0 &&
          key != "Colors"
        ) {
          variation =
            active_attribute.dataset.value + "_" + evt.target.dataset.value;
        }

        this.attributesData.forEach((element) => {
          try {
            if (element) {
              document.getElementById(element).removeAttribute("style");
            }
            let st = stock[0][active_attribute.dataset.value + "_" + element];
            if (st.quantity === 0) {
              Object.assign(document.getElementById(element).style, styles);
            } else {
            }
          } catch (error) {}
        });

        let vTs = stock[0][variation];

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
        this.$emit("productAttributeChange", { vTs: vTs, key: key });
      } catch (error) {
        console.log(error);
      }
    },

    selectProductAttributes: function() {
      let values = [];
      let attributes = document.querySelectorAll("select.vs");
      attributes.forEach(function(elm, key) {
        values.push(elm.value);
      });
      return values;
    },
  },
};
</script>

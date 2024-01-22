<template>
  <div
    v-if="Object.keys(attributes).includes('Sizes')"
    class="col-12 text-center"
  >
    <a class="bold" target="_blank" href="/product/size/guide">
      <svg id="iconLoaded-ruler">
        <use xlink:href="#sizeGuide">
          <symbol id="sizeGuide">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path
                fill-rule="evenodd"
                d="M16.125 1L23 7.875 7.875 23 1 16.125 16.125 1zm0 2.75l4.125 4.125L7.875 20.25 3.75 16.125l2.75-2.75 2.75 2.75 1.375-1.375L7.875 12l1.375-1.375 2.75 2.75L13.375 12l-2.75-2.75L12 7.875l2.75 2.75 1.375-1.375-2.75-2.75 2.75-2.75z"
              ></path>
            </svg>
          </symbol>
        </use>
      </svg>
      Size Guide
    </a>
  </div>
</template>
<script>
export default {
  name: "Show",
  props: {
    attributes: Object,
  },
};
</script>

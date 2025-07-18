<template>
<div
  class="text-center mt-12"
>
  <Link
    v-for="(link, index) in links"
    v-html="link.label"
    :href="link.url? link.url : ''"
    :key="index"
    :class="[
      {
      'text-white! font-semibold bg-blue-600': index === currentPage,
      'btn-reverse': index !== 0 && index !== (links.length - 1),
      'text-blue-700': index !== currentPage
      }
    ]"
  >
  </Link>
</div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { computed } from 'vue';

const props = defineProps({
  currentPage: {
    type: Number,
    required: true
  },

  links: {
    type:Array,
    required:true
  }
})
</script>
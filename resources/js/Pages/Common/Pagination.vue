<template>
<div
  class="text-center mt-12"
>
  <Link
    v-for="(link, index) in links"
    v-html="link.label"
    :href="link.url? link.url : ''"
    :key="index"
    class="bg-blue-600 mx-2 p-3 rounded text-white cursor-pointer"
  >
  </Link>
</div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  links: {
    type:Array,
    required:true
  }
})
</script>
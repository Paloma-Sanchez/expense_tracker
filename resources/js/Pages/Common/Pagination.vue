<template>
<div
  class="text-center mt-12"
>
  <Link
    v-for="(link, index) in linksToShow"
    v-html="link.label"
    :href="link.url? link.url : ''"
    :key="index"
    :class="[
      {
      'text-white! font-semibold bg-blue-600': Number(link.label) === currentPage,
      'btn-reverse': index !== 0 && index !== (linksToShow.length-1),
      'text-blue-700': index !== currentPage
      }
    ]"
  >
  </Link>
  <pre>
    {{ linksToShow }}
  </pre>
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

const linksToShow = computed(() => {
  // return true
  const links = []

  links.push(props.links[0])

  if(props.currentPage === 1){
    links.push(props.links[1])
    links.push(props.links[2])
    links.push(props.links[3])
  } else if(props.currentPage === props.links.length-2){
    links.push(props.links[props.links.length-4])
    links.push(props.links[props.links.length-3])
    links.push(props.links[props.links.length-2])
  } else {
    links.push(props.links[props.currentPage-1])
    links.push(props.links[props.currentPage])
    links.push(props.links[props.currentPage+ 1])
  }

  links.push(props.links[props.links.length-1])

  return links
})
</script>
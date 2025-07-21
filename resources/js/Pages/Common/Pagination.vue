<template>
<div
  class="text-center mt-12"
>
  <div
    v-if="linksToShow.length > 0"
    class="flex justify-center"
  >
    <div
      v-for="(link, index) in linksToShow"
      :key="index"
    >
      <Link
        v-if="link.url"
        v-html="link?.label ?? ''"
        :disabled="!link.url"
        :href="link?.url ? link.url : ''"
        :class="[
          {
          'text-white! font-semibold bg-blue-600':  Number(link?.label) === currentPage,
          'btn-reverse': index !== 0 && index !== (linksToShow.length-1),
          'text-blue-700': index !== currentPage,
          }
        ]"
        preserve-scroll
      >
      </Link>
      <span
        v-else
        v-html="link.label"
        :key="index"
        class="text-gray-500 cursor-not-allowed"
      />
    </div>
  </div>
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
  },

  lastPage: {
    type: Number,
    required: true
  },
})

const linksToShow = computed(() => {
  const links = []

  links.push(props.links[0])

  if(props.currentPage === 1){
    if( props.currentPage !== props.lastPage) {
      links.push(props.links[1])
      links.push(props.links[2])
      links.push(props.links[3])
    } else {
      links.push(props.links[1])
    }
  } else if(props.currentPage === props.lastPage){
    links.push(props.links[props.lastPage-4])
    links.push(props.links[props.lastPage-3])
    links.push(props.links[props.lastPage])
  } else {
    links.push(props.links[props.currentPage-1])
    links.push(props.links[props.currentPage])
    links.push(props.links[props.currentPage+ 1])
  }

  links.push(props.links[props.links.length-1])

  return links
})
</script>
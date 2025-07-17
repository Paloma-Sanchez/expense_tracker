<template>
  <button 
    class="px-6 py-3 bg-blue-700 hover:bg-blue-600 hover:shadow-md ring ring-blue-500 shadow-blue-500/80 rounded-md text-white cursor-pointer"
    type="type"  
  >
    {{ label }}
  </button>
</template>
<script setup>
const props = defineProps({
  label:{
    type: String,
    default: ''
  },

  type:{
    type:String,
    default:'button'
  }
})
</script>
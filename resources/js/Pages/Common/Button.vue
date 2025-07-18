<template>
  <button 
    class="btn-primary"
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
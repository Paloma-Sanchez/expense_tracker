<template>
<div
  class="mb-8 "
>
  <label 
    :for="name"
    class="text-xl"
  >
    {{ label }}
  </label>
  <br/>

  <input 
    v-model="inputValue"
    :name="name" 
    :type="type"
    class="border focus:outline-2 focus:outline-offset-2 focus:outline-blue-500 border-gray-800/50 w-full h-[40px] rounded-lg mt-3 ps-3"
    ref="input-instance" 
  />

  <span
    v-if="error"
    class="text-red-700 text-sm mt-2 block"
  >
    {{ error }}
  </span>
</div>
</template>

<script setup>
import { onMounted, useTemplateRef } from 'vue'

const props = defineProps({
  error: {
    type: String,
    default: ''
  },

  focused: {
    type: Boolean,
    default: false
  },

  label: {
    type: String,
    default: ''
  },

  name: {
    type: String,
    required:true
  },

  type: {
    type: String,
    default: "text"
  },
})

//ModelValue
const inputValue = defineModel()

//helpers
const input = useTemplateRef('input-instance')

onMounted(() => {
  if(props.focused){
    input?.value.focus()
  }
})
</script>
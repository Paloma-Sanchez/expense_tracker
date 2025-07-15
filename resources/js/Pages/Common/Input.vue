<template>
<div>
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
    class="border w-full h-[40px] rounded-lg mt-3 mb-8 ps-3"
    ref="input-instance" 
  />
</div>
</template>

<script setup>
import { onMounted, useTemplateRef } from 'vue'

const props = defineProps({
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
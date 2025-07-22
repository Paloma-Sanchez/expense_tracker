<template>
<div
  :class="[{
    'mb-8' : !customClass
  }]"
>
  <div
    v-if="label"
  >
    <label 
      :for="name"
      class="text-xl"
    >
      {{ label }}
    </label>
    <br/>
  </div>


  <input 
    v-model="inputValue"
    :name="name" 
    :type="type"
    :class="['input-primary',
      {
        'mt-3' : label,
        'h-[40px]': !customClass
      }
    ]"
    ref="input-instance" 
  />

  <span
    v-if="error"
    class="text-red-700 text-sm mt-2 block overflow-hidden max-h-6 "
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

  customClass:{
    type: Boolean,
    default: false
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
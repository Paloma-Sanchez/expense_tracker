<template>
<div
  class="absolute top-[10%] right-[10%]"
>
  <span
    class="font-semibold text-green-700 block"
  >
    {{ label }}
  </span>
  <span
    class="text-xs  text-green-800 mb-2 block"
  >{{ description }}</span>
  <div
    class="h-0.5 bg-green-800 transition duration-200 ease-in-out "
    ref="progress-bar"
  ></div>
</div>
</template>

<script setup>
import { onMounted, onUnmounted, useTemplateRef } from 'vue';

const props = defineProps({
  description:{
    type: String,
    default:''
  },

  label:{
    type: String,
    required:true
  }
})

const progressBar = useTemplateRef('progress-bar')
let countdown = null;

//onMounted
onMounted(() => {
  startTimer()
})

//emits
const emit = defineEmits(['show', 'close'])

//helpers
const startTimer = () => {
  const initalSeconds = 30 
  let secondsLeft = initalSeconds;

  console.log('progessBar', progressBar)

  progressBar.value.style.width = '100%'

  countdown = setInterval(() => {
    secondsLeft--;
    progressBar.value.style.width = ((secondsLeft * 100)/initalSeconds + '%')
    if(secondsLeft === 0){
      emit('close')
      stopTimer();
    }
  }, 1000);
}

const stopTimer = () => {
  clearInterval(countdown);
}
</script>
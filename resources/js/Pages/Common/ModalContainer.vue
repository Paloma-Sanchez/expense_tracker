<template>
<div 
  id="static-modal" 
  data-modal-backdrop="static" 
  tabindex="-1" 
  aria-hidden="true" 
  class="bg-blue-400/30 backdrop-blur-xs overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full max-h-full"
>
  <div 
    @click.self="$emit('close')"
    class="relative p-4 w-full h-full flex items-center justify-center"
  >
    <!-- Modal content -->
    <div class="">
      <slot/>
    </div>
  </div>
</div>
</template>
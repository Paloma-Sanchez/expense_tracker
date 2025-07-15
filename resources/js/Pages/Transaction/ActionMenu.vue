<template>
<div class="relative">
  <div class="absolute right-14 -top-[50px] text-center">
    <div>
      <span
        @click="$emit('edit')"
        class="block cursor-pointer hover:bg-blue-500 hover:text-white bg-white px-4 py-2 rounded-t-md "
      >
        Edit
      </span>
      <span
        @click="$emit('delete')"
        class="block cursor-pointer hover:bg-blue-500 hover:text-white bg-white px-4 py-2 rounded-b-md"
      >
        Delete
      </span>
    </div>
  </div>
</div>


</template>
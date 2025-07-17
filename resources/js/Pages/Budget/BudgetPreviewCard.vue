<template>
<div class="w-3xs text-center py-[25px] rounded-md border hover:bg-blue-500/30 hover:text-blue-600 cursor-pointer">
  <Link
    :href="`/budget/${budget.id}`"
  >
    <h4 class="font-semibold text-xl"> {{ budget.name }} </h4>
    <span> {{ (budget.budget_amount) }} </span>
  </Link>
</div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  budget: {
    type: Object,
    required: true
  }
})
</script>

<!--    -->
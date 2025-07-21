<template>
<div class="grid grid-rows-2 grid-cols-1fr grid-flow-col gap-4 justify-items-center max-w-[760px] overflow-clip overflow-x-scroll">
  <BudgetPreviewCard
    v-for="budget in budgets"
    :key="budget.id"
    :budget="budget"
  />
</div>
</template>
<script setup>
import BudgetPreviewCard from './BudgetPreviewCard.vue';

const props = defineProps({
  budgets:{
    type: Array,
    default: true
  }
})
</script>

<!--   -->
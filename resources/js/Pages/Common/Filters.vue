<template>
  <form
    @submit.prevent="handleFilterRequest"
    class="flex mb-5"
  >
    <input
      v-model="filterForm.dateFrom"
      name="from"
      label="From"
      placeholder="From"
    />

    <input
      v-model="filterForm.dateTo"
      name="to"
      label="To"
      placeholder="To"
    />

    <select
      v-model="filterForm.in_category_id"
    >
      <option
        v-for="category in categories"
        :key="category.id"
        :value="category.id"
      >
        {{ category.category }}
      </option>
    </select>

    <button
      type="submit"
    >
      filter
    </button>

    <button
      @click="handleClear"
      type="clear"
    >
      Clear
    </button>
  </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  categories: {
    type: Array,
    required:true
  },

  budgetId:{
    type: Number,
    required:true
  },

  filters:{
    type: Object,
    default: () => {}
  }
})

const filterForm = useForm({
  dateFrom: props.filters.dateFrom ?? null,
  dateTo: props.filters.dateTo ?? null,
  in_category_id: props.filters.in_category_id ?? null
})

//helpers
const handleFilterRequest = () => {
  console.log(filterForm)
  filterForm.get(`${props.budgetId}`, {
    preserveState: true,
    preserveScroll: true
  })
}

const handleClear = () => {
  filterForm.dateFrom = null,
  filterForm.dateTo = null,
  filterForm.in_category_id = null
}
</script>
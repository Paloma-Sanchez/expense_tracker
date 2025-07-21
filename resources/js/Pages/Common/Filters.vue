<template>
  <form
    @submit.prevent="handleFilterRequest"
    class="flex mb-5 "
  >
    <div>
      <input
        v-model="filterForm.dateFrom"
        class="border border-blue-600/40 ps-2 rounded-s-md w-28 md:w-36 lg:w-40 py-1"
        name="from"
        label="From"
        placeholder="From"
      />

      <input
        v-model="filterForm.dateTo"
        class="border border-blue-600/40 ps-2 rounded-e-md border-s-0 w-28 md:w-36 lg:w-40 py-1"
        name="to"
        label="To"
        placeholder="To"
      />
    </div>


    <select
      v-model="filterForm.in_category_id"
      class="border border-blue-600/40 ps-2 rounded-md md:w-40 py-1 ms-2 md:ms-6"
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
      class="btn-ghost md:ms-6 md:me-3 mx-2"
      type="submit"
    >
      Filter
    </button>

    <button
      @click="handleClear"
      class="hover:text-blue-600 hover:font-bold cursor-pointer hover:underline"
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

const formatDate = () => {

}
</script>
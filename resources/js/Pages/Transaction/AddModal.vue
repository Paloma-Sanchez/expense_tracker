<template>
<common-modal-container
  @close="$emit('closeModal')"
>
  <div
    class="w-full max-w-[7/10] mx-auto relative bg-white rounded-lg shadow-sm dark:bg-white py-12 px-20"
  >
    <form
      @submit.prevent="handleAddTransaction"
    >
      <h4 class="text-center text-3xl mb-10"> Add a new transaction</h4>

      <common-input
        v-model="newTransactionForm.description"
        :error="newTransactionForm.errors.description"
        name="description"
        label="Description"
        focused
      />

      <common-input
        v-model="newTransactionForm.amount"
        :error="newTransactionForm.errors.amount"
        name="amount"
        label="Amount"
        type="number"
      />

      <div>
        <label 
          for="amount"
          class="text-xl"
        >
          Category
        </label>
        <br/>
        <select
          v-model="newTransactionForm.in_category_id"
          class="w-full h-[40px] mt-3 mb-8 select-primary"
        >
          <option 
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.category }}
          </option>
        </select>
      </div>

      <div>
        <label 
          v-if="!budget_id"
          for="amount"
          class="text-xl"
        >
          Budget
        </label>
        <select 
          v-model="newTransactionForm.in_budget_id"
          v-if="!budget_id"
          class=" w-full h-[40px] mt-3 mb-8 select-primary"
          name="amount"
        >
          <option 
            v-for="budget in budgets"
            :key="budget.id"
            :value="budget.id"
          >
            {{ budget.name }}
          </option>
        </select>
      </div>
  
      <!-- BUTTONS -->
      <div
        class="flex justify-end"
      >
        <common-button
          @click="handleCancel"
          class="me-3"
          label="Cancel"
        />
        <common-button
          label="Add transaction"
          type="submit"
        />
      </div>
    </form>
  </div>
</common-modal-container>
</template>


<script setup>
//inertia
import { useForm } from '@inertiajs/vue3'

//components
import CommonButton from '../Common/Button.vue';
import CommonInput from '../Common/Input.vue';
import CommonModalContainer from '../Common/ModalContainer.vue'; 

const props = defineProps({
  budget_id: { 
    type: Number,
    default: null
  },

  budgets: {
    type: Array,
    default: () => [],
  },

  ownerId: {
    type: Number,
    required: true
  },

  categories: {
    type: Array,
    required: true
  }
})

const newTransactionForm = useForm({
  description: '',
  amount: null,
  in_category_id: 1,  
  in_budget_id: props.budget_id ?? (props.budgets[0].id),
  owner_id: props.ownerId
}); 

//emits
const emit = defineEmits(['closeModal'])

//Event listeners
const handleCancel = () => {
  emit('closeModal')
}

const handleAddTransaction = () => {
  newTransactionForm.post('/transaction',{
    onSuccess:(()=> emit('closeModal'))
  })
}
</script>

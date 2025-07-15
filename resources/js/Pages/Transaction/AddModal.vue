<template>
<common-modal-container
  @close="$emit('closeModal')"
>
  <div
    class="w-full max-w-[7/10] mx-auto relative bg-white rounded-lg shadow-sm dark:bg-white py-12 px-20"
  >
    <form>
      <h4 class="text-center text-3xl mb-10"> Add a new transaction</h4>

      <common-input
        v-model="newTransactionForm.description"
        name="description"
        label="Description"
        focused
      />

      <common-input
        v-model="newTransactionForm.amount"
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
          class="border w-full h-[40px] rounded-lg mt-3 mb-8 ps-3"
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
          v-if="!budget_id"
          class="border w-full h-[40px] rounded-lg mt-3 mb-8 ps-3"
          name="amount"
        >
          <option 
            v-for="budget in budgets"
            :key="budget.id"
            value="budget.id"
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
          @click.prevent="handleCancel"
          class="me-3"
          label="Cancel"
        />
        <common-button
          @click.prevent="handleAddTransaction"
          label="Add transaction"
        />
      </div>
    </form>
  </div>
</common-modal-container>
</template>


<script setup>
// vue imports
import { reactive } from 'vue';

//inertia
import { router } from '@inertiajs/vue3'

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

    validator(value) {
      // Only validate if budget_id is null
      if (this && this.budget_id !== null){
        return true
      };
      
      return Array.isArray(value) && value.length > 0;
    }
  },

  categories: {
    type: Array,
    required: true
  }
})

const newTransactionForm = reactive({
  description: '',
  amount: 0,
  in_category_id: 1,  
  in_budget_id: props.budget_id ? props.budget_id : 1,
}); 

//emits
const emit = defineEmits(['closeModal'])

//Event listeners
const handleCancel = () => {
  emit('closeModal')
}

const handleAddTransaction = () => {
  router.post('/transaction', newTransactionForm)
}
</script>

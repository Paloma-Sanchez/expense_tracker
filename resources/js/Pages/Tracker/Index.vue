<template>
<div class="max-w-8/10 mx-auto pt-[50px]">
  <h2 class="text-center text-5xl mb-14  ">Hello! </h2>

  <!-- BUDGETS -->
  <div class="mb-8">
    <div class="flex items-center justify-between  mb-6">
      <h3 class="font-semibold text-2xl">Active budgets</h3>
      <CommonButton
        @click="makeModalVisible('AddBudget')"
        label="Add new budget"
      />
    </div>

    <budget-preview-list
      :budgets="budgets"
    />
  </div>

  <!-- TRANSACTIONS -->
  <div>
    <div class="flex items-center justify-between  mb-6">
      <h3 class="font-semibold text-2xl ">All transactions</h3>
      <CommonButton
        @click="makeModalVisible('AddTransaction')"
        label="Add a transaction"
      />
    </div>
    <div
      class="max-h-[400px] h-1/4 overflow-clip overflow-y-scroll"
    >
      <transaction
        v-for="transaction in transactions"
        :key="transaction.id"
        :transaction="transaction"
      />
    </div>
  </div>
  <pre>{{ budgetNames }}</pre>
</div>

<!-- Modals -->
 <budget-add-modal
  v-if="openModal === 'AddBudget'"
  @close-modal="resetModal"
 />

 <transaction-add-modal
  v-if="openModal === 'AddTransaction'"
  :budgets="budgetNames"
  :categories="categories"
  @close-modal="resetModal"
 />
</template>

<script setup>
//date-fns
import { format, parseISO } from 'date-fns';

// vue
import { computed, ref } from 'vue';

//components
import BudgetAddModal from '../Budget/AddModal.vue';
import BudgetPreviewList from '../Budget/BudgetPreviewList.vue';
import CommonButton from '../Common/Button.vue';
import Transaction from '../Transaction/Index.vue';
import TransactionAddModal from '../Transaction/AddModal.vue';

const props = defineProps({
  budgets: {
    type: Array,
    required:true
  },

  categories: {
    type: Array,
    required:true
  },

  transactions: {
    type: Array,
    required:true
  }
})

const openModal = ref(null);

//computed
const budgetNames = computed(() => {

  const budgetNames = props.budgets.map((budget) => {
    const {created_at, updated_at, budget_amount, ...lightBudget} = budget

    return lightBudget
  })
  

  return budgetNames
})

//helpers
const formatDate = (dateString) => {
  const date = parseISO(dateString);
  return format(date, 'dd/MM/yy');
}

const makeModalVisible = (modalName) => {
  openModal.value = modalName
}

const resetModal = () => {
  openModal.value = null;
}
</script>
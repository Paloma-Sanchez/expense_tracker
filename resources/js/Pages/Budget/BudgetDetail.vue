<template>
<div class="max-w-8/10 mx-auto pt-[50px] mb-20">
  <Link
    class="btn-secondary"
    href="/tracker"
  >
    <chevron-left
      class="stroke-gray-500 hover:stroke-white"
      width="14px"
      height="14px"
    />
    Go back
  </Link>

  <div
    class="mb-14 text-center"
  >
    <span class="text-center text-xs mt-5 mb-3 block text-gray-500">Budget detail</span>
    <div class="flex  justify-center">
      <h2 class="text-5xl ">{{budget?.name}}</h2>
      <edit
        @click="makeModalVisible('changeName')"
        width="12px"
        height="12px"
        class="stroke-gray-600 hover:stroke-orange-500 cursor-pointer ms-2"
      />
    </div>
    <span 
      @click="handleDeleteBudget"
      class="text-gray-500 hover:text-red-500 hover:underline cursor-pointer mt-2 block text-sm"
    >
      Delete Budget
    </span>
  </div>
  

  <div class="md:flex items-center justify-between mb-12 ">
    <div
      class="flex justify-center"
    >
      <div>
        <span class="text-center text-xl">Current balance: </span>&nbsp;
        <span class="text-center text-2xl font-bold">${{ budgetLeft }}</span>
        <br/>
  
        <div class="text-sm mt-4 flex items-center">
          <span class="text-sm me-2"> remaining from initial budget of </span>
          <span 
            class="text-md font-semibold"
            :class="{
              'text-green-800': budget.budget_amount > 0,
              'text-red-500': budget.budget_amount <= 0
            }"
          > 
            ${{ budget.budget_amount }} 
          </span>
          <edit
            @click="makeModalVisible('changeAmount')"
            width="12px"
            height="12px"
            class="stroke-gray-600 hover:stroke-orange-500 cursor-pointer ms-2"
          />
        </div>
      </div>
    </div>
    
    <div
      class="lg:mr-24 flex justify-center mt-12 md:mt-0"
    >
      <common-pie
        :data="page.props.chartData"
      />
    </div>

  </div>



  <!-- Button -->
  <div class="flex justify-end mt-6 mb-10 lg:mb-6">
    <CommonButton
      @click="makeModalVisible('AddTransaction')"
      class="btn-primary"
      label="Add a transaction"
    />
  </div>

  <!-- Filters -->
  <common-filters
    :categories="categories"
    :budget-id="budget.id"
    :filters="filters"
    :disabled="filtersDisabled"
  />

  <!-- Transactions -->
  <div class="max-h-[400px] h-full overflow-scroll">
    <transaction
      v-for="transaction in transactions.data"
      :key="transaction.id"
      :categories="categories"
      :transaction="transaction"
    />
  </div>

  <!-- Pagination -->
  <common-pagination
    :current-page="transactions.current_page"
    :links="transactions.links"
    :last-page="transactions.last_page"
  />
</div>

<!-- modals -->
 <transaction-add-modal
  v-if="activeModal === 'AddTransaction'"
  @close-modal="resetModal"
  :budget_id="budget.id"
  :categories="categories"
  :ownerId="budget.by_user_id"
/>

<budget-modify-modal
  v-if="activeModal === 'changeName'"
  @close-modal="resetModal"
  :budget-amount="budget.budget_amount"
  :budget-id="budget.id"
  input-label="New budget name"
  input-name="name"
/>

<budget-modify-modal
  v-if="activeModal === 'changeAmount'"
  @close-modal="resetModal"
  :name="budget.name"
  :budget-id="budget.id"
  input-label="New budget amount"
  input-name="budget_amount"
/>

<!-- alert -->
<common-alert
  v-if="showAlert"
  @show="activateAlert"
  @close="deactivateAlert"
  :description="flash.split('  ')[0]"
  label="Success!"
/>
</template>


<script setup>
//vue
import { computed, reactive, ref, watch } from 'vue';

//inertia
import { router, Link, usePage } from '@inertiajs/vue3'

//components
import CommonAlert from '../Common/Alert.vue';
import CommonButton from '../Common/Button.vue';
import CommonFilters from '../Common/Filters.vue';
import CommonPagination from '../Common/Pagination.vue';
import CommonPie from '../Common/Pie.vue';
import BudgetModifyModal from './ModifyModal.vue';
import Transaction from '../Transaction/Index.vue';
import TransactionAddModal from '../Transaction/AddModal.vue';

//svg
import ChevronLeft from '../../../../public/Icons/chevron-left.svg';
import Edit from '../../../../public/Icons/edit.svg';

const props = defineProps({
  budget: {
    type: Object,
    required: true
  },

  categories: {
    type:Array,
    required:true
  },

  filters:{
    type: Object,
    default: () => {}
  },

  transactions: {
    type: Object,
    required: true
  },

  transactionsTotal: {
    type: Number,
    required: true
  }
})

const page = usePage()

const flash = computed(() => page.props.flash.success)

//Modal state
const activeModal = ref(null);
const showAlert=ref(null);

//computed
const budgetLeft = computed(() => {
  return Number.parseFloat((Number(props.budget.budget_amount) + props.transactionsTotal)).toFixed(2);
});

const filtersDisabled = computed(() => {
  return props.transactions.data.length === 0
})

//watch
watch(flash, (newFlash) => {
  if(newFlash){
    activateAlert()
  }
})

//helpers
const handleDeleteBudget = () => {
  router.delete(`/budget/${props.budget.id}`)
}

const makeModalVisible = (modalName) => {
  activeModal.value = modalName
}

const resetModal = () => {
  activeModal.value = null;
}

const activateAlert = () => {
  if(showAlert.value) {
    deactivateAlert()

    setTimeout(() => showAlert.value = true, 1000)
  } else {
    showAlert.value = true
  }
}

const deactivateAlert = () => {
  showAlert.value = false
}
</script>
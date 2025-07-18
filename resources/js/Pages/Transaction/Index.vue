<template>
<div 
  v-click-away="editTransactionActive ? toggleEditTransaction : '' "
  class="flex items-center justify-between w-full py-3 px-8 border border-gray-300"
>
  <div class="pe-3  flex-auto">
    <div class="font-medium">
      <input
        v-model="newDataForm.description"
        v-if="editTransactionActive"
        class="rounded ps-1 border border-gray-400/80"
        ref="description-input"
      />
      <span
        v-else
      >
        {{ transaction.description}}
      </span>
    </div>
    <div>
      <div
        v-if="editTransactionActive"
      >
        <select
          v-model="newDataForm.in_category_id"
          class="border w-1/2 h-[30px] rounded-lg mt-3 mb-8 ps-3"
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
      <span 
        v-else
        class="text-gray-500 text-sm" 
      >
        {{transaction.category.category}}
      </span>
    </div>
  </div>

  <span class="pe-3 text-xs text-gray-500 min-w-1/10 me-3">{{ formatDate(transaction.created_at) }}</span>

  <div 
    class="w-min "
  >
    <input
      v-model="newDataForm.amount"
      v-if="editTransactionActive"
      class="rounded ps-1 border border-gray-400/80 w-fit min-w-1/10 me-5 max-w-[80px]"
    />
    <span 
      v-else
      class="min-w-[80px] w-fit text-left flex justify-end font-medium me-5"
    >
      {{ transaction.amount }}
    </span>
  </div>


  <!-- Buttons -->
  <button
    v-if="!editTransactionActive"
    @click="toggleMenu"
  >
    <three-dots-vertical
      class="cursor-pointer"
      height="18px"
      width="24px"
      fill="#aaa"
    />
  </button>
  <div
    v-else
    class="flex items-center"
  >
    <button
      @click="handleConfirmChange"
    >
      <check-square-fill
        class="cursor-pointer me-2"
        height="24px"
        width="24px"
        fill="#016630"
      />
    </button>
    <button
      @click="toggleEditTransaction"
    >
      <cancel-circle-fill
        class="cursor-pointer"
        height="24px"
        width="24px"
        fill="#e7000b"
      />
    </button>
  </div>
</div>
<transaction-action-menu
  v-click-away="toggleMenu"
  v-if="menuOpen"
  @edit="handleEdit"
  @delete="handleDelete"
/>
</template>

<script setup>
//date-fns
import { format, parseISO } from 'date-fns';

//inertia
import { router, useForm } from '@inertiajs/vue3'

//Logos
import ThreeDotsVertical from '../../../../public/Icons/three-dots-vertical.svg'
import CancelCircleFill from '../../../../public/Icons/cancel-circle-fill.svg'
import CheckSquareFill from '../../../../public/Icons/check-square-fill.svg'

//components
import TransactionActionMenu from './ActionMenu.vue'
import { nextTick, reactive, ref, useTemplateRef } from 'vue';

const props = defineProps({
  transaction:{
    type: Object,
    required:true
  },

  categories:{
    type: Array,
    required:true
  }
})

const editTransactionActive = ref(false)

const newDataForm = useForm({
  description: props.transaction.description,
  in_category_id: props.transaction.category.id,
  amount: props.transaction.amount,
})

const descriptionInput = useTemplateRef('description-input')

//modal action menu
const menuOpen=ref(false)

//helpers
const formatDate = (dateString)=> {
  console.log('date', dateString)
  const date = parseISO(dateString);
  return format(date, 'dd/MM/yy');
}

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
}

const toggleEditTransaction = () => {
  editTransactionActive.value = !editTransactionActive.value
}

//event listeners
const handleDelete = () => {
  router.delete(`/transaction/${props.transaction.id}` )
}

const handleEdit = () => {
  toggleEditTransaction()

  nextTick(() => {
    if (editTransactionActive.value && descriptionInput.value) {
      descriptionInput.value.focus();
    }
  });

  toggleMenu()
}

const handleConfirmChange = () => {

  console.log('changing transaction', newDataForm)

  newDataForm.put(`/transaction/${props.transaction.id}`);

  toggleEditTransaction()
}
</script>
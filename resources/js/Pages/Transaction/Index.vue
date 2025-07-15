<template>
<div 
  v-click-away="editTransactionActive ? toggleEditTransaction : '' "
  class="flex items-center justify-between w-full py-3 px-8 border border-gray-300"
>
  <div class="pe-3  flex-auto">
    <div class="font-medium">
      <input
        v-model="newData.description"
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
      <input
        v-model="newData.category"
        v-if="editTransactionActive"
        class="rounded ps-1 border border-gray-400/80"
      />
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
      v-model="newData.amount"
      v-if="editTransactionActive"
      class="rounded ps-1 border border-gray-400/80 w-fit min-w-1/10 me-5 max-w-[80px]"
    />
    <span 
      v-else
      class="min-w-1/10 w-fit text-left flex justify-end font-medium me-5"
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
import { router } from '@inertiajs/vue3'

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
  }
})

const editTransactionActive = ref(false)
const newData = reactive({
  description: props.transaction.description,
  category: props.transaction.category.category,
  amount: props.transaction.amount,
})

const descriptionInput = useTemplateRef('description-input')

//modal action menu
const menuOpen=ref(false)

//helpers
const formatDate = (dateString)=> {
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
  const payload = {
    description: newData.description,
    amount: newData.amount,
    in_category_id: 2//newData.in_category_id // if you want to update category
  };

  console.log('changing transaction', payload)

  router.put(`/transaction/${props.transaction.id}`, payload);

  toggleEditTransaction()
}
</script>
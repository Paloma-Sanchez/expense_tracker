<template>
<div 
  v-click-away="editTransactionActive ? toggleEditTransaction : '' "
  class="flex items-center justify-between w-full py-3 px-8 border border-gray-300"
>
  <div class="pe-3  flex-auto">
    <div class="font-medium">
      <common-input
        v-model="newDataForm.description"
        v-if="editTransactionActive"
        :custom-class="true"
        :error="newDataForm.errors.description"
        class="w-fit"
        name="description"
        focused
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
          class="w-fit h-[26px] mt-1.5 px-3 select-primary"
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
    class="flex items-center"
  >
    <common-input
      v-model="newDataForm.amount"
      v-if="editTransactionActive"
      :custom-class="true"
      :error="newDataForm.errors.amount"
      class="w-fit min-w-1/10 max-w-[80px] me-3"
      name="amount"
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
      class="cursor-pointer "
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
        class="cursor-pointer me-2 hover:scale-125"
        height="24px"
        width="24px"
        fill="#016630"
      />
    </button>
    <button
      @click="toggleEditTransaction"
    >
      <cancel-circle-fill
        class="cursor-pointer hover:scale-125"
        height="24px"
        width="24px"
        fill="#e7000b"
      />
    </button>
  </div>
</div>

<!-- Menu -->
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

//vue
import { nextTick, ref, useTemplateRef } from 'vue';

//Logos
import ThreeDotsVertical from '../../../../public/Icons/three-dots-vertical.svg'
import CancelCircleFill from '../../../../public/Icons/cancel-circle-fill.svg'
import CheckSquareFill from '../../../../public/Icons/check-square-fill.svg'

//components
import CommonInput from '../Common/Input.vue'
import TransactionActionMenu from './ActionMenu.vue'

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
  const date = parseISO(dateString);
  return format(date, 'dd/MM/yy');
}

const toggleMenu = () => {
  menuOpen.value = !menuOpen.value
}

const toggleEditTransaction = () => {
  newDataForm.description = props.transaction.description
  newDataForm.in_category_id = props.transaction.category.id
  newDataForm.amount = props.transaction.amount

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
  newDataForm.put(`/transaction/${props.transaction.id}`, {
    onSuccess:() => toggleEditTransaction(),
    preserveScroll:true
  });

  // 
}
</script>
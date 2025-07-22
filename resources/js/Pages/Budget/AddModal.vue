<template>
<common-modal-container
  @close="$emit('closeModal')"
>
  <div
    class="w-full max-w-[7/10] mx-auto relative bg-white rounded-lg shadow-sm dark:bg-white py-12 px-20"
  >
    <form
      @submit.prevent="handleAddBudget"
    >
      <h4 class="text-center text-3xl mb-10"> Create a new budget</h4>

      <common-input
        v-model="newBudgetForm.name"
        :error="newBudgetForm.errors.name"
        name="name"
        label="Budget name"
        focused
      />
      <common-input
        v-model="newBudgetForm.budget_amount"
        :error="newBudgetForm.errors.budget_amount"
        name="amount"
        label="Amount"
        type="number"
      />
  
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
          label="Add budget"
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
  userId:{
    type: Number,
    required:true
  }
})

const newBudgetForm = useForm({
  name: null,
  budget_amount: null,
  by_user_id: props.userId ?? null
}); 


//emits
const emit = defineEmits(['closeModal'])

//Event listeners
const handleCancel = () => {
  emit('closeModal')
}

const handleAddBudget = () => {
  newBudgetForm.post('/budget',{
    onSuccess:(() => emit('closeModal'))
  })
}


</script>
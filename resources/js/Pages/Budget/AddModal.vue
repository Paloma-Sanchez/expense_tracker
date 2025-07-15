<template>
<common-modal-container
  @close="$emit('closeModal')"
>
  <div
    class="w-full max-w-[7/10] mx-auto relative bg-white rounded-lg shadow-sm dark:bg-white py-12 px-20"
  >
    <form>
      <h4 class="text-center text-3xl mb-10"> Create a new budget</h4>

      <common-input
        v-model="newBudgetForm.name"
        name="name"
        label="Budget name"
        focused
      />
      
      <common-input
        v-model="newBudgetForm.amount"
        name="name"
        label="Budget name"
        type="number"
      />
  
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
          @click.prevent="handleAddBudget"
          label="Add budget"
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

const newBudgetForm = reactive({
  name: '',
  amount: 0,
  by_user_id: 1
}); 

//emits
const emit = defineEmits(['closeModal'])

//Event listeners
const handleCancel = () => {
  console.log('cancel')
  emit('closeModal')
}

const handleAddBudget = () => {
  router.post('/budget', newBudgetForm)
  emit('closeModal')
}


</script>
<template>
<common-modal-container
  @close="$emit('closeModal')"
>
  <div
    class="w-full max-w-[7/10] mx-auto relative bg-white rounded-lg shadow-sm dark:bg-white py-12 px-20"
  >
    <form
      @submit.prevent="handleChange"
    >
      <common-input
        v-model="updatedValueForm[inputName]"
        :name="inputName"
        :label="inputLabel"
        :error="updatedValueForm.errors.name || updatedValueForm.errors.budget_amount"
        focused
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
          label="Change"
          tyoe="submit"
        />
      </div>
    </form>
    <pre>{{updatedValueForm}}</pre>
  </div>
</common-modal-container>
</template>


<script setup>
import { reactive, ref } from 'vue';

import { useForm } from '@inertiajs/vue3';

import CommonButton from '../Common/Button.vue';
import CommonInput from '../Common/Input.vue';
import CommonModalContainer from '../Common/ModalContainer.vue'; 

const props = defineProps({
  inputName:{
    type: String,
    
    validator: ((x) => {
      return ['name', 'budget_amount'].includes(x)
    })
  },

  inputLabel:{
    type: String,
    default:''
  },

  name:{
    type: String,
    default: null
  },

  budgetAmount:{
    type: Number,
    default: null
  },

  budgetId:{
    type: Number,
    required: true
  }
})

const updatedValueForm = useForm({
  name: props.name ?? null,
  budget_amount: props.budgetAmount ?? null
})

//emits
const emit = defineEmits(['closeModal', 'changeRequest'])

//Event listeners
const handleCancel = () => {
  emit('closeModal')
}

const handleChange = () => {
  updatedValueForm.put(`/budget/${props.budgetId}`, {
    onSuccess: () => emit('closeModal')
  })
}

</script>

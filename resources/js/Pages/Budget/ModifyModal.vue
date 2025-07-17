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
        v-model="updatedValue"
        :name="inputName"
        :label="inputLabel"
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
  </div>
</common-modal-container>
</template>


<script setup>
import { reactive, ref } from 'vue';
import CommonButton from '../Common/Button.vue';
import CommonInput from '../Common/Input.vue';
import CommonModalContainer from '../Common/ModalContainer.vue'; 

const props = defineProps({
  inputName:{
    type: String,
    default:''
  },

  inputLabel:{
    type: String,
    default:''
  },
})

const updatedValue = ref(null)
//emits
const emit = defineEmits('closeModal', 'changeRequest')

//Event listeners
const handleCancel = () => {
  emit('closeModal')
}

const handleChange = () => {
  emit('changeRequest', updatedValue.value)
}

</script>

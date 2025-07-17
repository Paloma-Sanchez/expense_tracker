<template>
<div>
  <h2
    class="text-3xl text-center font-semibold mt-32 mb-24"
  >
    Log in to access your tracker
  </h2>
  <form
    @submit.prevent="handleSubmit"
    class="max-w-[50%] mx-auto"
  >
    <common-input
      v-model="form.email"
      :error="form.errors.email"
      name="email"
      label="E-mail"
      focused
    />

    <common-input
      v-model="form.password"
      :error="form.errors.password"
      name="password"
      label="Password"
      focused
    />

    <div
      class="text-center"
    >
      <common-button
        label="Log In"
      />
    </div>
  </form>
  <pre>{{form}}</pre>

</div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import CommonButton from '../Common/Button.vue'
import CommonInput from '../Common/Input.vue'

const form = useForm(
  {
    email: null,
    password: null
  }
)


//helpers
const handleSubmit = () => {
  form.post('/login')
}
</script>
<template>
<div>
  <h2
    class="text-4xl text-center font-semibold mt-36 mb-16"
  >
    Log in to access your tracker
  </h2>
  <form
    @submit.prevent="handleSubmit"
    class="max-w-[400px] mx-auto"
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
    />

    <div
      class="text-center mb-16"
    >
      <common-button
        class="text-lg! px-8!"
        label="Log In"
      />
    </div>

    <!-- Sign up -->
    <span
      class="block text-center text-sm text-gray-700"
    >
      Don't have an account yet?
    </span>
    <Link
      class="block text-center text-lg hover:text-blue-700 hover:font-semibold"
      href="/user-account/create"
    >
      Register now
    </Link>
  </form>
  <pre>{{form}}</pre>

</div>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3';
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
<template>
<div>
  <h2
    class="text-4xl text-center font-semibold mt-36 mb-18"
  >
    Sign up to start using your tracker
  </h2>
  <form
    @submit.prevent="handleSubmit"
    class="max-w-[400px] mx-auto"
  >
    <common-input
      v-model="form.name"
      :error="form.errors.name"
      name="name"
      label="Full Name"
      focused
    />

    <common-input
      v-model="form.email"
      :error="form.errors.email"
      name="email"
      label="E-mail"
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
        label="Sign up"
      />
    </div>

    <!-- Sign in -->
    <span
      class="block text-center text-sm text-gray-700"
    >
      You have an account already?
    </span>
    <Link
      class="block text-center text-lg hover:text-blue-700 hover:font-semibold"
      href="/login"
    >
      Sign in
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
    name: null,
    email: null,
    password: null
  }
)


//helpers
const handleSubmit = () => {
  form.post('/user-account')
}
</script>
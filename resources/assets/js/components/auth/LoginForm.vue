<template>
  <div class="flex items-center justify-center min-h-screen my-0 mx-auto flex-col gap-5">
    <form v-show="!showingForgotPasswordForm" :class="{ error: failed }"
      class="w-full sm:w-[288px] sm:border duration-500 p-7 rounded-xl border-transparent sm:bg-white/10 space-y-3"
      data-testid="login-form" @submit.prevent="login">
      <div class="text-center mb-8">
        <img alt="Koel's logo" class="inline-block" src="../../../img/icon.png" width="156">
      </div>

      <FormRow>
        <TextInput v-model="email" autofocus placeholder="Email Address" require type="email" />
      </FormRow>

      <FormRow>
        <PasswordField v-model="password" placeholder="Password" required />
      </FormRow>

      <FormRow>
        <Btn data-testid="submit" type="submit">Log In</Btn>
      </FormRow>

      <FormRow v-if="canResetPassword">
        <a class="text-right text-[.95rem] text-k-text-secondary" role="button" @click.prevent="showForgotPasswordForm">
          Forgot password?
        </a>
      </FormRow>
    </form>

    <ForgotPasswordForm v-if="showingForgotPasswordForm" @cancel="showingForgotPasswordForm = false"/>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { authService } from '@/services';
import { logger } from '@/utils';

import FormRow from '@/components/ui/form/FormRow.vue';
import TextInput from '@/components/ui/form/TextInput.vue';
import PasswordField from '@/components/ui/form/PasswordField.vue';
import Btn from '@/components/ui/form/Btn.vue';
import ForgotPasswordForm from '@/components/auth/ForgotPasswordForm.vue';

const DEMO_ACCOUNT = {
  email: 'demo@musicbox.dev',
  password: 'demo'
}

const canResetPassword = window.MAILER_CONFIGURED && !window.IS_DEMO

const email = ref(window.IS_DEMO ? DEMO_ACCOUNT.email : '')
const password = ref(window.IS_DEMO ? DEMO_ACCOUNT.password : '')
const failed = ref(false)
const showingForgotPasswordForm = ref(false)

const emit = defineEmits<{ (e: 'loggedIn') }>()

const login = async () => {
  try {
    await authService.login(email.value, password.value)

    failed.value = false
    password.value = ''

    emit('loggedIn')
  } catch (error: unknown) {
    failed.value = true
    logger.error(error)
    setTimeout(() => (failed.value = false), 2000);
  }
}

const showForgotPasswordForm = () => (showingForgotPasswordForm.value = true)
</script>

<style lang="postcss" scoped>
/**
 * I like to move it move it
 * I like to move it move it
 * I like to move it move it
 * You like to - move it!
 */
@keyframes shake {

  8%,
  41% {
    transform: translateX(-10px);
  }

  25%,
  58% {
    transform: translateX(10px);
  }

  75% {
    transform: translateX(-5px);
  }

  92% {
    transform: translateX(5px);
  }

  0%,
  100% {
    transform: translateX(0);
  }
}

form {
  &.error {
    @apply border-red-500;
    animation: shake .5s;
  }
}
</style>
<template>
  <form class="min-w-full sm:min-w-[480px] sm:bg-white/10 p-7 rounded-xl" data-testid="forgot-password-form"
    @submit.prevent="submit">
    <h1 class="text-2xl mb-4">Forgot Password</h1>

    <FormRow>
      <div class="flex flex-col gap-3 sm:flex-row sm:gap-0 sm:content-stretch">
        <TextInput v-model="email" class="flex-1 sm:rounded-l sm:rounded-r-none" placeholder="Your email address"
          required type="email" />
        <Btn :disabled="loading" class="sm:rounded-l-none sm:rounded-r" type="submit">Reset Password</Btn>
        <Btn :disabled="loading" class="!text-k-text-secondary" transparent @click="cancel">Cancel</Btn>
      </div>
    </FormRow>
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { authService } from '@/services';
import { useMessageToaster } from '@/composables';

import FormRow from '@/components/ui/FormRow.vue';
import TextInput from '@/components/ui/TextInput.vue';
import Btn from '@/components/ui/Btn.vue';

const { toastSuccess } = useMessageToaster()

const emit = defineEmits<{ (e: 'cancel'): void }>();

const email = ref('')
const loading = ref(false)

const cancel = () => {
  email.value = ''
  emit('cancel')
}

const submit = async () => {
  try {
    loading.value = true
    await authService.requestResetPasswordLink(email.value)
    toastSuccess('Password reset link sent. Please check your email.')
  } catch (error: unknown) {
  } finally {
    loading.value = false
  }
}
</script>
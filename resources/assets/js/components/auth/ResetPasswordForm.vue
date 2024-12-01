<template>
  <div class="flex items-center justify-center h-screen">
    <form v-if="validPayload" class="flex flex-col gap-3 sm:w-[480px] sm:bg-white/10 sm:rounded-lg p-7"
      @submit.prevent="submit">
      <h1 class="text-2xl mb-2">Set New Password</h1>
      <label>
        <PasswordField v-model="password" minlength="10" placeholder="New password" required />
        <span class="help block mt-4">Min. 10 characters. Should be a mix of characters, numbers, and symbols.</span>
      </label>
      <div>
        <Btn :disabled="loading" type="submit">Save</Btn>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { authService } from '@/services';
import { useMessageToaster, useRouter } from '@/composables';
import { base64Decode } from '@/utils';

import PasswordField from '@/components/ui/PasswordField.vue';
import Btn from '@/components/ui/Btn.vue';

const { toastSuccess, toastError } = useMessageToaster()
const { go, getRouteParam } = useRouter();

const email = ref('')
const password = ref('')
const token = ref('')
const loading = ref(false)

const validPayload = computed(() => email.value && token.value)

const extractPayloadFromRoute = () => {
  try {
    [email.value, token.value] = base64Decode(decodeURIComponent(getRouteParam('payload')!)).split('|');
    console.log('email: ',email.value)
    console.log('token: ',token.value)
  } catch (error: unknown) {
    toastError("Invalid reset password link.")
  }
}
extractPayloadFromRoute()

const submit = async () => {
  try {
    loading.value = true
    await authService.resetPassword(email.value, password.value, token.value)
    toastSuccess('Password reset successful!')

    await authService.login(email.value, password.value)
    setTimeout(() => go('/', true));
  } catch (error) {
  } finally {
    loading.value = false
  }
}
</script>
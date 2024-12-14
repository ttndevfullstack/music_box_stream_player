<template>
  <Overlay ref="overlay" />
  <MessageToaster ref="toaster" />

  <main v-if="layout === 'main' && initialized && authenticated">
    <h1>Welcome {{ userStore.state.current.name }} to MusicBox Player</h1>
  </main>

  <LoginForm v-if="layout === 'auth'" @loggedIn="onUserLoggedIn" />
  <ResetPasswordForm v-if="layout === 'reset-password'" />

  <AppInitializer v-if="authenticated" @success="onInitSuccess" @error="onInitError" />
</template>

<script lang="ts" setup>
import { defineAsyncComponent, onMounted, provide, ref } from "vue";
import { MessageToasterKey, OverlayKey } from "@/symbols";
import { userStore } from "@/stores";
import { useRouter } from "@/composables";
import { authService } from "@/services";

import Overlay from "@/components/ui/Overlay.vue";
import AppInitializer from "@/components/utils/AppInitializer.vue";
import MessageToaster from "@/components/ui/message-toaster/MessageToaster.vue";

const LoginForm = defineAsyncComponent(() => import("@/components/auth/LoginForm.vue"));
const ResetPasswordForm = defineAsyncComponent(() => import("@/components/auth/ResetPasswordForm.vue"));

const overlay = ref<InstanceType<typeof Overlay>>()
const toaster = ref<InstanceType<typeof MessageToaster>>()

const layout = ref<'main' | 'auth' | 'invitation' | 'reset-password'>();

const { getCurrentScreen, resolveRoute } = useRouter()

const authenticated = ref(false)
const initialized = ref(false)

onMounted(async () => {
  if (authService.hasApiToken()) {
    triggerAppInitialization()
    return;
  }

  await resolveRoute()

  switch (getCurrentScreen()) {
    case "Password.Reset":
      layout.value = 'reset-password'
      break;
    default:
      layout.value = 'auth'
  }
})

const triggerAppInitialization = () => (authenticated.value = true)

const onUserLoggedIn = () => {
  layout.value = "main";
  triggerAppInitialization();
}

const onInitSuccess = () => {
  authenticated.value = true;
  initialized.value = true;
  layout.value = "main";
}

const onInitError = () => {
  authenticated.value = false,
    initialized.value = false;
  layout.value = "auth";
}

provide(OverlayKey, overlay);
provide(MessageToasterKey, toaster);
</script>

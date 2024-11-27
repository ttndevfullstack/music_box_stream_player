<template>
  <Overlay ref="overlay" />

  <main v-if="layout === 'main' && initialized && authenticated">
    <h1>Welcome {{ userStore.state.current.name }} to MusicBox Player</h1>
  </main>

  <LoginForm v-if="layout === 'auth'" @loggedIn="onUserLoggedIn" />

  <AppInitializer v-if="authenticated" @success="onInitSuccess" @error="onInitError" />
</template>

<script lang="ts" setup>
import { onMounted, provide, ref } from "vue";
import { OverlayKey } from "./symbols";

import AppInitializer from "@/components/utils/AppInitializer.vue";
import LoginForm from "@/components/auth/LoginForm.vue";
import Overlay from "@/components/ui/Overlay.vue";
import { userStore } from "@/stores";

const overlay = ref<InstanceType<typeof Overlay>>()

const layout = ref<'main' | 'auth' | 'invitation' | 'reset-password'>();

const authenticated = ref(false)
const initialized = ref(false)

onMounted(async () => {
  switch (true) {
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
</script>

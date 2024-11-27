<template>
  <dialog ref="dialog" :class="state.type" class="border-0 p-0 bg-transparent backdrop:bg-black/80 outline-0"
    data-testid="overlay" @cancel.prevent="onCancel">
    <span class="flex items-baseline justify-center gap-3">
      <SoundBars v-if="state.type === 'loading'" />
      <Icon v-if="state.type === 'error'" :icon="faCircleExclamation" />
      <Icon v-if="state.type === 'warning'" :icon="faWarning" />
      <Icon v-if="state.type === 'info'" :icon="faCircleInfo" />
      <Icon v-if="state.type === 'success'" :icon="faCircleCheck" />

      <span class="message" v-html="state.message" />
    </span>
  </dialog>
</template>

<script setup lang="ts">
import { defineAsyncComponent, reactive, ref } from 'vue';
import { faCircleCheck, faCircleExclamation, faCircleInfo, faWarning } from '@fortawesome/free-solid-svg-icons'

const SoundBars = defineAsyncComponent(() => import("@/components/ui/SoundBars.vue"))

const dialog = ref<HTMLDialogElement>()

const state = reactive<TOverlayState>({
  dismissible: false,
  type: 'loading',
  message: '',
})

const show = (options: Partial<TOverlayState> = {}) => {
  Object.assign(state, options)
  dialog.value?.open || dialog.value?.showModal()
}

const hide = () => dialog.value?.close()

const onCancel = () => state.dismissible && hide()

defineExpose({ show, hide });
</script>

<style lang="postcss" scoped>
dialog {
  /* since the texts are placed directly on a dark backdrop, the colors should be a bit washed out */

  &.error {
    @apply text-red-400;
  }

  &.success {
    @apply text-green-400;
  }

  &.info {
    @apply text-blue-400;
  }

  &.loading {
    @apply text-k-text-secondary;
  }

  &.warning {
    @apply text-orange-400;
  }
}
</style>

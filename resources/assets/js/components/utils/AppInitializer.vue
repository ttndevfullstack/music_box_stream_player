<template>
  <slot />
</template>

<script setup lang="ts">
import { useOverlay } from '@/composables/useOverlay';
import { onMounted } from 'vue';
import { commonState } from '@/stores';

const { showOverlay, hideOverlay } = useOverlay();

const emits = defineEmits<{
  (e: 'success'): void,
  (e: 'error', err: unknown): void,
}>();

onMounted(async () => {
  showOverlay({ message: 'Just a little patience…' })

  try {
    await commonState.init();

    emits('success')
  } catch (error) {
    emits('error', error)
  } finally {
    hideOverlay()
  }
})
</script>
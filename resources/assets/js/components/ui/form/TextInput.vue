<template>
  <input v-model="value" type="text"
    class="block text-base w-full px-4 py-2.5 rounded bg-k-bg-input text-k-text-input read-only:bg-gray-400 read-only:text-gray-900 disabled:bg-gray-400 disabled:text-gray-900" />
</template>

<script lang="ts" setup>
import { computed } from 'vue'

const props = withDefaults(defineProps<{ modelValue?: any }>(), { modelValue: null })
const emit = defineEmits<{ (e: 'update:modelValue', value: any): void }>()

const value = computed({
  get: () => props.modelValue,
  set: value => emit('update:modelValue', value)
})
</script>

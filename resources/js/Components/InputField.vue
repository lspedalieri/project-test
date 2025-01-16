<script setup>
import { computed } from 'vue';
import { defineProps, defineEmits } from 'vue';

// Define props and emit events
const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'text',
    },
    placeholder: {
        type: String,
        default: '',
    },
    modelValue: {
        type: String,
        default: '',
    },
    error: {
        type: String,
        default: null,
    },
    id: {
        type: String,
        required: true,
    },
    disable:{
        type: Boolean,
        default: 0
    }
});

const emit = defineEmits(['update:modelValue']);

// Computed function for dynamic input id and name
const inputId = computed(() => props.id);

// Emit input changes to the parent component
const onInput = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<template>
    <div class="mb-4">
        <label :for="inputId" class="block text-gray-700 text-sm font-bold mb-2">
            {{ label }}:
        </label>
        <input
            :type="type"
            :id="inputId"
            :placeholder="placeholder"
            :value="modelValue"
            :disabled="disabled == disable"
            @input="onInput"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        />
        <span v-if="error" class="text-red-500 text-sm mt-1">
            {{ error }}
        </span>
    </div>
</template>

<style scoped>
/* Optional custom styling */
</style>
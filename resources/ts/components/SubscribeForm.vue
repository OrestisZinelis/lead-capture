<template>
    <form @submit.prevent="handleFormSubmit" class="space-y-6">
        <div>
            <label
                for="name"
                class="text-sm font-medium text-gray-700 block mb-2"
                >Full Name:</label
            >
            <input
                type="text"
                id="name"
                v-model="lead.name"
                @blur="() => validateName(lead.name)"
                required
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                :class="{
                    'border-red-500': errors.name,
                    'border-gray-300': !errors.name,
                }"
            />
            <p v-if="errors.name" class="text-red-500 text-xs mt-1">
                {{ errors.name }}
            </p>
        </div>
        <div>
            <label
                for="email"
                class="text-sm font-medium text-gray-700 block mb-2"
                >Email:</label
            >
            <input
                type="email"
                id="email"
                v-model="lead.email"
                @blur="() => validateEmail(lead.email)"
                required
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                :class="{
                    'border-red-500': errors.email,
                    'border-gray-300': !errors.email,
                }"
            />
            <p v-if="errors.email" class="text-red-500 text-xs mt-1">
                {{ errors.email }}
            </p>
        </div>
        <div class="flex items-center">
            <input
                type="checkbox"
                id="consent"
                v-model="lead.consent"
                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
            />
            <label for="consent" class="ml-2 text-sm text-gray-700"
                >I consent to receive marketing emails</label
            >
        </div>
        <button
            type="submit"
            :disabled="!canSubmit"
            class="w-full px-4 py-2 border border-transparent rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:cursor-not-allowed"
            :class="
                canSubmit
                    ? 'bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500'
                    : 'bg-indigo-400 text-white'
            "
        >
            Submit
        </button>
    </form>
</template>

<script lang="ts" setup>
import { ref, computed } from "vue";
import type { Lead } from "@/type/lead.types";
import { validateName, validateEmail } from "@/utils/validators.utils";

interface Errors {
    name: string | null;
    email: string | null;
}

const emit = defineEmits<{
    submit: [lead: Omit<Lead, "id">];
}>();

const lead = ref<Omit<Lead, "id">>({ name: "", email: "", consent: false });
const errors = ref<Errors>({ name: null, email: null });

const canSubmit = computed(() => {
    errors.value.name = validateName(lead.value.name);
    errors.value.email = validateEmail(lead.value.email);
    return lead.value.consent && !errors.value.name && !errors.value.email;
});

const handleFormSubmit = () => {
    if (canSubmit.value) emit("submit", lead.value);
};
</script>

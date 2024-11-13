<template>
    <transition name="fade">
        <div
            v-if="visible"
            :class="[
                'fixed bottom-0 left-0 right-0 py-3 text-center',
                messageType === 'success' ? 'bg-green-500' : 'bg-red-500',
                messageType === 'error'
                    ? 'flex justify-between items-center px-4'
                    : '',
            ]"
            role="alert"
        >
            <span class="text-white">{{ message }}</span>
            <button
                v-if="messageType === 'error'"
                @click="closeToast"
                class="text-white text-xl leading-none ml-4"
                aria-label="Close"
            >
                &times;
            </button>
        </div>
    </transition>
</template>

<script lang="ts" setup>
import { ref, watchEffect } from "vue";
import { ToastType } from "@/type/toast.types";

const props = defineProps<{
    message: string;
    messageType: ToastType;
    duration: number;
}>();

const visible = ref(false);

watchEffect(() => {
    if (props.message) {
        visible.value = true;
        if (props.messageType === "success" && props.duration) {
            setTimeout(() => {
                visible.value = false;
            }, props.duration);
        }
    }
});

const closeToast = () => {
    visible.value = false;
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>

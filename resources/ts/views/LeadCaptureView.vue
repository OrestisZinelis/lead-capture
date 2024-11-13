<template>
    <div class="flex justify-center items-center h-screen">
        <button
            v-if="!showModal"
            @click="showModal = true"
            class="w-32 h-12 bg-indigo-600 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:bg-indigo-700"
        >
            Subscribe
        </button>
        <Modal v-if="showModal" @close="showModal = false">
            <SubscribeForm @submit="submitForm" />
        </Modal>
        <Toast
            v-if="toastMessage"
            :message="toastMessage"
            :messageType="toastType"
            :duration="TOAST_DURATION"
            @dismissed="toastMessage = ''"
        />
    </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import axios from "axios";
import Modal from "@/components/Modal.vue";
import SubscribeForm from "@/components/SubscribeForm.vue";
import Toast from "@/components/Toast.vue";
import type { Lead } from "@/type/lead.types";
import type { ToastType } from "@/type/toast.types";

const TOAST_DURATION = 3000;
const toastMessage = ref("");
const toastType = ref<ToastType>("success");
const showModal = ref(false);

const submitForm = async (leadData: Omit<Lead, "id">) => {
    try {
        await axios.post("/api/leads", leadData);
        toastMessage.value = "You have subscribed successfully!";
        toastType.value = "success";
    } catch (error) {
        console.error("There was an error submitting the lead:", error);
        toastMessage.value = "Failed to submit lead. Please try again.";
        toastType.value = "error";
    } finally {
        showModal.value = false;
    }
};
</script>

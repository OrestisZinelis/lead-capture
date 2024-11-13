<template>
    <div class="p-6">
        <button
            @click="fetchLeads"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 cursor-pointer"
        >
            Fetch All Leads
        </button>
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2 w-[200px]">Consent</th>
                    <th class="px-4 py-2 w-[100px]">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="lead in leads" :key="lead.id" class="bg-white">
                    <td class="border px-4 py-2">{{ lead.id }}</td>
                    <!-- Name cell -->
                    <td class="border px-4 py-2 cursor-pointer">
                        <div
                            v-if="
                                editingCell.leadId === lead.id &&
                                editingCell.cell === 'name'
                            "
                            class="flex items-center"
                        >
                            <input
                                v-model="lead.name"
                                class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-8 py-1 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"
                            />
                            <button
                                @click="confirmEdit(lead)"
                                class="bg-gray-200 hover:bg-gray-300 font-bold h-8 w-8 rounded ml-2 flex justify-center items-center cursor-pointer"
                            >
                                <span class="text-green-500">✔️</span>
                            </button>
                            <button
                                @click="discardEdit(lead, 'name')"
                                class="bg-gray-200 hover:bg-gray-300 font-bold h-8 w-8 rounded ml-2 flex justify-center items-center cursor-pointer"
                            >
                                <span class="text-red-500">❌</span>
                            </button>
                            <span
                                v-if="cellErrors.name"
                                class="text-red-500 text-xs ml-2"
                            >
                                {{ cellErrors.name }}
                            </span>
                        </div>
                        <div
                            v-else
                            @click="setEditingCell(lead.id, 'name', lead.name)"
                        >
                            {{ lead.name }}
                        </div>
                    </td>

                    <!-- Email cell -->
                    <td class="border px-4 py-2 cursor-pointer">
                        <div
                            v-if="
                                editingCell.leadId === lead.id &&
                                editingCell.cell === 'email'
                            "
                            class="flex items-center"
                        >
                            <input
                                v-model="lead.email"
                                type="email"
                                class="bg-gray-100 rounded border border-gray-400 leading-normal resize-none w-full h-8 py-1 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"
                            />
                            <button
                                @click="confirmEdit(lead)"
                                class="bg-gray-200 hover:bg-gray-300 font-bold h-8 w-8 rounded ml-2 flex justify-center items-center cursor-pointer"
                            >
                                <span class="text-green-500">✔️</span>
                            </button>
                            <button
                                @click="discardEdit(lead, 'email')"
                                class="bg-gray-200 hover:bg-gray-300 font-bold h-8 w-8 rounded ml-2 flex justify-center items-center cursor-pointer"
                            >
                                <span class="text-red-500">❌</span>
                            </button>
                            <span
                                v-if="cellErrors.email"
                                class="text-red-500 text-xs ml-2"
                            >
                                {{ cellErrors.email }}
                            </span>
                        </div>
                        <div
                            v-else
                            @click="
                                setEditingCell(lead.id, 'email', lead.email)
                            "
                        >
                            {{ lead.email }}
                        </div>
                    </td>

                    <!-- Consent cell -->
                    <td class="border px-4 py-2 cursor-pointer">
                        <div
                            v-if="
                                editingCell.leadId === lead.id &&
                                editingCell.cell === 'consent'
                            "
                            class="flex items-center"
                        >
                            <select
                                v-model="lead.consent"
                                class="bg-gray-100 rounded border border-gray-400 leading-normal w-[full] h-8 py-1 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"
                            >
                                <option :value="true">Yes</option>
                                <option :value="false">No</option>
                            </select>
                            <button
                                @click="confirmEdit(lead)"
                                class="bg-gray-200 hover:bg-gray-300 font-bold h-8 w-8 rounded ml-2 py-1 px-2 flex justify-center items-center cursor-pointer"
                            >
                                <span class="text-green-500">✔️</span>
                            </button>
                            <button
                                @click="discardEdit(lead, 'consent')"
                                class="bg-gray-200 hover:bg-gray-300 font-bold h-8 w-8 rounded ml-2 py-1 px-2 flex justify-center items-center cursor-pointer"
                            >
                                <span class="text-red-500">❌</span>
                            </button>
                        </div>
                        <div
                            v-else
                            @click="
                                setEditingCell(lead.id, 'consent', lead.consent)
                            "
                        >
                            {{ lead.consent ? "Yes" : "No" }}
                        </div>
                    </td>

                    <!-- Actions cell -->
                    <td
                        class="border px-4 py-2 flex justify-center items-center"
                    >
                        <button
                            @click="deleteLead(lead.id)"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded cursor-pointer"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
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
import { ref, onMounted } from "vue";
import axios from "axios";
import { validateName, validateEmail } from "@/utils/validators.utils";
import Toast from "@/components/Toast.vue";
import type { Lead } from "@/type/lead.types";
import type { ToastType } from "@/type/toast.types";

interface EditingCell {
    leadId: Lead["id"] | null;
    cell: string | null;
}
interface CellErrors {
    name: Lead["name"];
    email: Lead["email"];
}
type OriginalValue = {
    [K in keyof Lead]?: Lead[K];
};

const TOAST_DURATION = 3000;

const leads = ref<Lead[]>([]);
const editingCell = ref<EditingCell>({
    leadId: null,
    cell: null,
});
const originalValue = ref<OriginalValue>({});
const cellErrors = ref<CellErrors>({
    name: "",
    email: "",
});

const toastMessage = ref("");
const toastType = ref<ToastType>("success");

const setEditingCell = (
    leadId: Lead["id"],
    cell: keyof Lead,
    value: string | boolean
) => {
    if (
        editingCell.value.leadId !== leadId ||
        editingCell.value.cell !== cell
    ) {
        // If we're already editing a cell, discard changes before switching
        if (editingCell.value.leadId && editingCell.value.cell) {
            const leadToDiscard = leads.value.find(
                (l) => l.id === editingCell.value.leadId
            );
            if (leadToDiscard) {
                discardEdit(
                    leadToDiscard,
                    editingCell.value.cell as keyof Lead
                );
            }
        }
        editingCell.value = { leadId, cell };
        originalValue.value = { ...originalValue.value, [cell]: value };
    }
};

const confirmEdit = async (lead: Lead) => {
    let isValid = true;
    cellErrors.value = { name: "", email: "" };

    if (editingCell.value.cell === "name") {
        const error = validateName(lead.name);
        if (error) {
            cellErrors.value.name = error;
            isValid = false;
        }
    } else if (editingCell.value.cell === "email") {
        const error = validateEmail(lead.email);
        if (error) {
            cellErrors.value.email = error;
            isValid = false;
        }
    }

    if (isValid) updateLead(lead);
};

const discardEdit = (lead: Lead, cell: keyof Lead) => {
    const originalCell = originalValue.value[cell];
    if (originalCell !== undefined) {
        (lead[cell] as string | boolean) = originalCell!;
    }
    editingCell.value = { leadId: null, cell: null };
};

const fetchLeads = async () => {
    try {
        const response = await axios.get("/api/leads");
        leads.value = response.data;
    } catch (error) {
        console.error("There was an error fetching the leads:", error);
    }
};

const updateLead = async (lead: Lead) => {
    try {
        await axios.put(`/api/leads/${lead.id}`, lead);
        editingCell.value = { leadId: null, cell: null };
        toastMessage.value = "Lead updated successfully!";
        toastType.value = "success";
    } catch (error) {
        console.error("There was an error updating the lead:", error);
        toastMessage.value = "Failed to update lead. Please try again.";
        toastType.value = "error";
    }
};

const deleteLead = async (id: Lead["id"]) => {
    try {
        await axios.delete(`/api/leads/${id}`);
        leads.value = leads.value.filter((lead) => lead.id !== id);
        toastMessage.value = "Lead deleted successfully!";
        toastType.value = "success";
    } catch (error) {
        console.error("There was an error deleting the lead:", error);
        toastMessage.value = "Failed to delete lead. Please try again.";
        toastType.value = "error";
    }
};

onMounted(fetchLeads);
</script>

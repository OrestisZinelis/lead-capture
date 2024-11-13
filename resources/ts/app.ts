import "./bootstrap";
import { createApp } from "vue";

const app = createApp({});

import LeadCaptureView from "@views/LeadCaptureView.vue";
import LeadsManagementView from "@/views/LeadsManagementView.vue";

app.component("lead-capture-view", LeadCaptureView);
app.component("leads-management-view", LeadsManagementView);

app.mount("#app");

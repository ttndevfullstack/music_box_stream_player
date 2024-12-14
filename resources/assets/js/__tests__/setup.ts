import vueSnapshotSerializer from "jest-serializer-vue";
import { expect } from "vitest";

declare global {
    interface Window {
        BASE_URL: string;
        IS_DEMO: boolean;
        IS_PRODUCTION: boolean;
        MAILER_CONFIGURED: boolean;
    }
}

window.BASE_URL = "http://test/";
window.IS_DEMO = false;
window.IS_PRODUCTION = false;
window.MAILER_CONFIGURED = true;

expect.addSnapshotSerializer(vueSnapshotSerializer);
import { Ref } from "vue";
import { requireInjection } from "@/utils";
import { MessageToasterKey } from "@/symbols";
import MessageToaster from "@/components/ui/message-toaster/MessageToaster.vue";

let toaster: Ref<InstanceType<typeof MessageToaster>>;

export const useMessageToaster = () => {
    console.log(MessageToasterKey)
    toaster = toaster || requireInjection(MessageToasterKey);

    return {
        toastSuccess: toaster.value.success.bind(toaster.value),
        toastInfo: toaster.value.info.bind(toaster.value),
        toastWarning: toaster.value.warning.bind(toaster.value),
        toastError: toaster.value.error.bind(toaster.value),
    };
};

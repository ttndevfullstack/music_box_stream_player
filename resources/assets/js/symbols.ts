import { InjectionKey, Ref } from "vue";
import Overlay from "@/components/ui/Overlay.vue";
import MessageToaster from "@/components/ui/message-toaster/MessageToaster.vue";
import Router from "@/router";

export const RouterKey: InjectionKey<Router> = Symbol("Router");
export const OverlayKey: InjectionKey<Ref<InstanceType<typeof Overlay>>> = Symbol("Overlay");
export const MessageToasterKey: InjectionKey<Ref<InstanceType<typeof MessageToaster>>> = Symbol("MessageToaster");

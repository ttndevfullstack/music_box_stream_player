import { InjectionKey, Ref } from "vue";
import Overlay from "@/components/ui/Overlay.vue";

export const OverlayKey: InjectionKey<Ref<InstanceType<typeof Overlay>>> = Symbol("Overlay");

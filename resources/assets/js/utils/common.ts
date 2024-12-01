import { noop } from "@/utils";

export const forceReloadWindow = () => {
  window.onbeforeunload = noop;
  window.location.reload();
}
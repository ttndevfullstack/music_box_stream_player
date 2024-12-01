import Router from "@/router";
import { RouterKey } from "@/symbols";
import { requireInjection } from "@/utils";

let router: Router;
export const useRouter = () => {
    router = router || requireInjection(RouterKey);

    const getRouteParam = (name: string) => router.$currentRoute.value?.params?.[name];
    const getCurrentScreen = () => router.$currentRoute.value?.screen;

    return {
      getRouteParam,
      getCurrentScreen,
      go: Router.go,
      resolveRoute: router.resolve.bind(router),
      triggerNotFound: router.triggerNotFound.bind(router),
      onRouteChanged: router.onRouteChanged.bind(router)
    }
}
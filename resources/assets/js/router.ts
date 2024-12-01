import { ref, Ref } from "vue";
import { forceReloadWindow } from "@/utils";

export default class Router {
    public $currentRoute: Ref<TRoute>;

    private readonly routes: TRoute[];
    private readonly homeRoute: TRoute;
    private readonly notFoundRoute: TRoute;
    private routeChangedHandler: TRouteChangedHandler[] = [];
    private cache: Map<string, { route: TRoute, params: TRouteParams }> = new Map();

    constructor(routes: TRoute[]) {
        this.routes = routes;
        this.homeRoute = this.routes.find(({ screen }) => screen === "Home")!;
        this.notFoundRoute = this.routes.find(({ screen }) => screen === "404")!;
        this.$currentRoute = ref(this.homeRoute);
    }

    public static go(path: string | number, reload = false) {
        if (typeof path === "number") {
            history.go(path);
            return;
        }

        if (!path.startsWith("/")) {
            path = `/${path}`;
        }
        if (!path.startsWith("/#")) {
            path = `/#${path}`;
        }

        path = path.substring(1, path.length);
        location.assign(`${location.origin}${location.pathname}${path}`);
        
        reload && forceReloadWindow()
    }

    public async resolve() {
        console.log(location)
        if (!location.hash || location.hash === '#/' || location.hash === '#!/') {
            return Router.go(this.homeRoute.path)
        }

        const matched = this.tryMatchRoute();
        const [route, params] = matched ? [matched.route, matched.params] : [null, null];

        if (!route) {
            return this.triggerNotFound()
        }
    
        if ((await route.onResolve?.(params)) === false) {
            return this.triggerNotFound()
        }

        if (route.redirect) {
            const to = route.redirect(params);
            // Todo:
        }

        return this.activateRoute(route, params);
    }

    public triggerNotFound = async () => await this.activateRoute(this.notFoundRoute);
    public onRouteChanged = (handler: TRouteChangedHandler) => this.routeChangedHandler.push(handler);

    public async activateRoute(route: TRoute, params: TRouteParams = {}) {
        this.$currentRoute.value = route;
        this.$currentRoute.value.params = params;
    }

    private tryMatchRoute() {
        if (!this.cache.has(location.hash)) {
            for (let i = 0; i  < this.routes.length; i++) {
                const route = this.routes[i];
                const matches = location.hash.match(new RegExp(`^#!?${route.path}/?(?:\\?(.*))?$`));

                if (matches) {
                    const searchParams = new URLSearchParams(new URL(location.href.replace("#/", "")).search);
                    
                    this.cache.set(location.hash, {
                      route,
                      params: Object.assign(Object.fromEntries(searchParams.entries()), matches.groups || {})
                    });

                    break;
                }
            }
        }

        return this.cache.get(location.hash);
    }
}

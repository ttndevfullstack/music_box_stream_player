declare type Closure<T = unknown | any> = (...args: Array<unknown | any>) => T

declare type TScreenName = 
  | "Home" 
  | "Password.Reset" 
  | "404";

type TRoute = {
  path: string;
  screen: TScreenName;
  params?: TRouteParams;
  redirect?: TRedirectHook;
  onResolve?: TResolveHook;
}

type TRouteParams = Record<string, string>
type TRedirectHook = (params: TRouteParams) => TRoute | string
type TResolveHook = (params: TRouteParams) => Promise<boolean | void> | boolean | void
type TRouteChangedHandler = (newRoute: TRoute, oldRoute: TRoute | undefined) => any

interface Window {
    BASE_URL: string;
    IS_DEMO: boolean;
    IS_PRODUCTION: boolean;
    MAILER_CONFIGURED: boolean;
}

interface ILogger {
    warn: (message: any, ...args: any[]) => void;
    log: (message: any, ...args: any[]) => void;
    error: (message: any, ...args: any[]) => void;
    info: (message: any, ...args: any[]) => void;
}

type TToastMessage = {
    id: string;
    type: "info" | "success" | "warning" | "danger";
    content: string;
    timeout: number; // seconds
};

type TMethodOf<T> = { [K in keyof T]: T[K] extends Closure ? K : never; }[keyof T]

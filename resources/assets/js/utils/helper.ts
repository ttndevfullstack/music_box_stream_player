import { inject, InjectionKey } from "vue";

export const requireInjection = <T>(key: InjectionKey<T>, defaultValue?: T) => {
    const value = inject(key, defaultValue);

    if (typeof value === "undefined") {
        throw new Error(`Missing injection key: ${key.toString()}`);
    }

    return value;
};

export const noop = () => {};
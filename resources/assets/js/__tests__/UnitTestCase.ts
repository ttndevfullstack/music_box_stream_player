import Router from "@/router";
import { routes } from "@/config";
import { render, RenderOptions } from "@testing-library/vue";
import { http } from "@/services";
import { isObject, mergeWith } from 'lodash'
import { afterEach, beforeEach, vi } from 'vitest'
import { defineComponent } from "vue";
import { MessageToasterKey, OverlayKey, RouterKey } from '@/symbols'
import { MessageToasterStub, OverlayStub } from "@/__tests__/stubs"

// A deep-merge function that
// - supports symbols as keys (_.merge doesn't)
// - supports Vue's Ref type without losing reactivity (deepmerge doesn't)
// Credit: https://stackoverflow.com/a/60598589/794641
const deepMerge = (first: object, second: object) => {
  return mergeWith(first, second, (a, b) => {
    if (!isObject(b)) return b

    // @ts-ignore
    return Array.isArray(a) ? [...a, ...b] : { ...a, ...b }
  })
}

const setPropIfNotExists = (obj: object | null, prop: any, value: any) => {
  if (!obj) return

  if (!Object.prototype.hasOwnProperty.call(obj, prop)) {
    obj[prop] = value
  }
}

export default abstract class UnitTestCase {
    protected router: Router;
    private backupMethods = new Map();

    public constructor() {
        this.router = new Router(routes);
        this.mock(http, "request"); // prevent actual HTTP requests from being made

        this.beforeEach();
        this.afterEach();
        this.test();
    }

    protected beforeEach() {
        // Todo
    }

    protected afterEach() {
        // Todo
    }

    protected abstract test();

    protected mock<T, M extends TMethodOf<Required<T>>>(
        obj: T,
        methodName: M,
        implementation?: any
    ) {
        const mock = vi.fn();

        if (implementation !== undefined) {
            mock.mockImplementation(
                implementation instanceof Function
                    ? implementation
                    : () => implementation
            );
        }

        this.backupMethods.set(obj[methodName], obj[methodName]);

        return obj[methodName];
    }

    protected render (component: any, options: RenderOptions<any> = {}) {
      return render(component, deepMerge({
        global: {
          directives: {
            'koel-focus': {},
            'koel-tooltip': {},
            'koel-hide-broken-icon': {},
            'koel-overflow-fade': {}
          },
          components: {
            Icon: this.stub('Icon')
          }
        }
      }, this.supplyRequiredProvides(options)))
    }

    protected stub (testId = 'stub') {
      return defineComponent({
        template: `<br data-testid="${testId}"/>`
      })
    }

    private supplyRequiredProvides (options: RenderOptions<any>) {
      options.global = options.global || {}
      options.global.provide = options.global.provide || {}
  
      // setPropIfNotExists(options.global.provide, DialogBoxKey, DialogBoxStub)
      setPropIfNotExists(options.global.provide, MessageToasterKey, MessageToasterStub)
      setPropIfNotExists(options.global.provide, OverlayKey, OverlayStub)
      setPropIfNotExists(options.global.provide, RouterKey, this.router)
      return options
    }
}

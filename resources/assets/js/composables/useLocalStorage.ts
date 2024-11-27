import { useAuthorization } from "./useAuthorization";
import { get as baseGet, set as baseSet, remove as baseRemove } from "local-storage";

export const useLocalStorage = (namespaced: boolean = true) => {
  let namespace = '';

  if (namespaced) {
    const { currentUser } = useAuthorization();
    namespace = `${currentUser.value.id}::`;

  }

  const get = <T>(key: string, defaultValue: T | null = null): T | null => {
    const value = baseGet<T>(namespace + key);

    return value === null ? defaultValue : value;
  }

  const set = (key: string, value: any) => baseSet(namespace + key, value);

  const remove = (key: string) => baseRemove(namespace + key);

  return { get, set, remove };
}
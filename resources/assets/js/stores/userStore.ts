import { reactive } from "vue";

export const userStore = {
  state: reactive({
    users: [] as IUser[],
    current: null! as IUser,
  }),

  init (currentUser: IUser) {
    this.state.current = currentUser;
  }
}
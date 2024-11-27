import { http } from "@/services/http";
import { reactive } from "vue";
import { userStore } from ".";

const initialValue = {
    allow_download: false,
    cdn_url: "",
    current_version: "",
    latest_version: "",
    current_user: null! as IUser,
    users: [] as IUser[],
};

export const commonState = {
    state: reactive(initialValue),

    async init() {
        Object.assign(this.state, await http.get("data"));

        userStore.init(this.state.current_user);
    },
};

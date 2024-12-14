import { useLocalStorage } from "@/composables/useLocalStorage";
import { http } from "@/services";

const API_TOKEN_STORAGE_KEY = "api-token";
const AUDIO_TOKEN_STORAGE_KEY = "audio-token";

const { get: lsGet, set: lsSet, remove: lsRemove } = useLocalStorage(false);

export const authService = {
    async login(email: string, password: string) {
        this.setTokensUsingCompositeToken(
            await http.post<ICompositeToken>("me", { email, password })
        );
    },

    async logout() {
        await http.delete("me");
        this.destroyTokens();
    },

    getApiToken: () => lsGet(API_TOKEN_STORAGE_KEY),

    getAudioToken: () => lsGet(AUDIO_TOKEN_STORAGE_KEY),

    getOneTimeToken: () => {},

    setApiToken: (token: string) => lsSet(API_TOKEN_STORAGE_KEY, token),

    setAudioToken: (token: string) => lsSet(AUDIO_TOKEN_STORAGE_KEY, token),

    setTokensUsingCompositeToken(compositeToken: ICompositeToken) {
        this.setApiToken(compositeToken.token);
        this.setAudioToken(compositeToken.audioToken);
    },

    destroyTokens: () => {
        lsRemove(API_TOKEN_STORAGE_KEY);
        lsRemove(AUDIO_TOKEN_STORAGE_KEY);
    },

    hasApiToken() {
        return Boolean(this.getApiToken());
    },

    hasAudioToken() {
        return Boolean(this.getAudioToken());
    },

    requestResetPasswordLink: async (email: string) =>
        await http.post("forgot-password", { email }),

    resetPassword: async (email: string, password: string, token: string) =>
        await http.post("reset-password", { email, password, token }),
};

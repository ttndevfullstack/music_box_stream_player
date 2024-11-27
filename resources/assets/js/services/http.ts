import Axios, {
    AxiosError,
    AxiosInstance,
    AxiosRequestConfig,
    AxiosResponse,
    Method,
} from "axios";
import { authService } from "@/services";
// import { eventBus } from "@/utils/eventBus";

class Http {
    client: AxiosInstance;

    private silent = false;

    constructor() {
        this.client = this.initAxiosInstance();
        this.setupRequestInterceptor();
        this.setupResponseInterceptor();
    }

    private initAxiosInstance() {
        return Axios.create({
            baseURL: `${window.BASE_URL}api`,
            headers: {
                "Content-Type": "application/json",
                "X-Api-Version": "v1",
            },
        });
    }

    private setupRequestInterceptor() {
        this.client.interceptors.request.use((config: AxiosRequestConfig) => {
            this.silent || this.showLoadingIndicator();
            config.headers.Authorization = `Bearer ${authService.getApiToken()}`;

            return config;
        });
    }

    private setupResponseInterceptor() {
        this.client.interceptors.response.use(
            (response: AxiosResponse) => {
                this.silent || this.hideLoadingIndicator();
                this.silent = false;

                // Update token if exists in headers
                // This occurs during user updating password
                const token = response.headers.authorization;
                token && authService.setApiToken(token);

                return response;
            },
            (error: AxiosError) => {
                this.silent || this.hideLoadingIndicator();
                this.silent = false;

                const isLoginFailure =
                    (error.response?.status === 400 ||
                        error.response?.status === 401) &&
                    error.config.url === "me" &&
                    error.config.method?.toLowerCase() === "post";

                if (isLoginFailure) {
                    // eventBus.emit("LOG_OUT");
                }

                return Promise.reject(error);
            }
        );
    }

    private showLoadingIndicator() {}

    private hideLoadingIndicator() {}

    public silently() {
        this.silent = true;
        return this.silent;
    }

    public request<T>(
        method: Method,
        url: string,
        data: Record<string, any> = {},
        onUploadProgress?: any
    ) {
        return this.client.request({
            method,
            url,
            data,
            onUploadProgress,
        }) as Promise<{ data: ApiResponse }>;
    }

    public async get<T>(url: string) {
        return (await this.request<T>("get", url)).data?.data;
    }

    public async post<T>(
        url: string,
        data: Record<string, any> = {},
        onUploadProgress?: any
    ) {
        return (await this.request<T>("post", url, data, onUploadProgress)).data?.data;
    }

    public async put<T>(url: string, data: Record<string, any>) {
        return (await this.request<T>("put", url, data)).data?.data;
    }
    public async patch<T>(url: string, data: Record<string, any>) {
        return (await this.request<T>("patch", url, data)).data?.data;
    }
    public async delete<T>(url: string, data: Record<string, any> = {}) {
        return (await this.request<T>("delete", url, data)).data?.data;
    }
}

export const http = new Http();

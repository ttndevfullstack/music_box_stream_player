type TOverlayState = {
    dismissible: boolean;
    type: "loading" | "success" | "info" | "warning" | "error";
    message: string;
};

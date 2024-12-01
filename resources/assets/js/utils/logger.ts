const prefix = "[music box]";

export const logger: ILogger = {
    warn: (message: any, ...args: any[]) => console.warn(prefix, message, ...args),
    log: (message: any, ...args: any[]) => console.log(prefix, message, ...args),
    error: (message: any, ...args: any[]) => console.error(prefix, message, ...args),
    info: (message: any, ...args: any[]) => console.info(prefix, message, ...args),
};

export const routes: TRoute[] = [
    {
        path: "/home",
        screen: "Home",
    },
    {
        path: "/404",
        screen: "404",
    },
    {
      path: `/reset-password/(?<payload>[a-zA-Z0-9\\+/=]+)`,
      screen: 'Password.Reset'
    }
];

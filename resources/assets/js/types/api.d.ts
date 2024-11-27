interface ApiResponse {
  status: number;
  success: boolean;
  data?: any;
}

interface ICompositeToken {
  token: string;
  audioToken: string;
}
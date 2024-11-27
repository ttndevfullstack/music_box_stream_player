interface IUser {
  type: 'users'
  id: number
  name: string
  email: string
  is_admin: boolean
  // is_prospect: boolean
  password?: string
  // preferences?: UserPreferences
  // avatar: string
  // sso_provider: SSOProvider | null
  // sso_id: string | null
}
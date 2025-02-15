export default {
  errors: {
    string: {
      required: 'The {value} field is required!',
      email: 'Must be a valid email!',
      min: '{value} must be at least {number} characters!',
      oneOf: 'Passwords must be the same!'
    },
    home: {
      'missing userName': 'Your are not logged in. Enter user name to start chatting!',
      url: 'This is the wrong URL!',
      param: 'There is no room number in the link!',
      noUserName: 'Username required!'
    }
  },
  home: {
    'create new room': 'Create new room',
    'or': 'or',
    'id room': 'id room',
    'enter': 'Enter an existing one',
  },
  handler: {
    'log in': 'Log in'
  },
  logIn: {
    'sign in to': 'Sign in to your account',
    'email': 'Your email',
    'password': 'Password',
    'remember': 'Remember me',
    'forgot': 'Forgot password?',
    'do not account': 'Don’t have an account yet?',
    'sign up': 'Sign up',
    'sign in': 'Sign in'
  },
  registration: {
    register: 'Register a new account',
    name: 'Your name',
    passwordConfirm: 'Confirm password',
    'i accept': 'I accept the',
    terms: 'Terms and Conditions'
  },
  reset: {
    'reset password': 'Password reset',
    reset: 'Reset'
  },
  forgotPassword: {
    'forgot password': 'Forgot your password?',
    forgot: 'Send link',
    description: 'We will send you a link to reset your password to this email address!'
  },
  textChat: {
    typing: '{name} enters message'
  }
};
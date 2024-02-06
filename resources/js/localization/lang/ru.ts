export default {
  errors: {
    string: {
      required: 'Поле {value} обязательно для заполнения!',
      email: 'Должен быть действующий email!',
      min: '{value} должно быть не менее {number} символов!',
      oneOf: 'Пароли должны быть одинаковыми!'
    },
    home: {
      'missing userName': 'Вы не вошли в систему. Введите имя пользователя, чтобы начать общение!',
      url: 'Это неправильный URL!',
      param: 'В ссылке нет номера комнаты!',
      noUserName: 'Необходимо ввести имя пользователя!'
    }
  },
  home: {
    'create new room': 'Создать новую комнату',
    'or': 'или',
    'id room': 'id комнаты',
    'enter': ' Войти в уже существующую'
  },
  handler: {
    'log in': 'Войти'
  },
  logIn: {
    'sign in to': 'Войти в свою учетную запись',
    'email': 'Ваша электронная почта',
    'password': 'Пароль',
    'remember': 'Запомните меня',
    'forgot': 'Забыли пароль?',
    'do not account': 'У вас еще нет учетной записи?',
    'sign up': 'Зарегистрироваться',
    'sign in': 'Войти'
  },
  registration: {
    register: 'Зарегистрируйте новую учетную запись',
    name: 'Ваше имя',
    passwordConfirm: 'Подтвердите пароль',
    'i accept': 'Я принимаю',
    terms: 'Условия и положения'
  },
  reset: {
    'reset password': 'Сброс пароля',
    reset: 'Сбросить'
  },
  forgotPassword: {
    'forgot password': 'Забыли пароль?',
    forgot: 'Отправить ссылку',
    description: 'Мы вышлем вам ссылку для сброса пароля на этот адрес электронной почты!'
  },
  textChat: {
    typing: '{name} вводит сообщение'
  }
}
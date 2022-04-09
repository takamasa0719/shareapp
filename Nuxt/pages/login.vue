<template>
  <div class="login">
    <div class="login_container">
        <p>ログイン</p>
        <input v-model="email" type="email" placeholder="メールアドレス" required />
        <br />
        <input v-model="password" type="password" placeholder="パスワード" required />
        <br />
        <button @click="login">ログイン</button>
        <br />
        </div>
  </div>
</template>


<script>
import firebase from '~/plugins/firebase'
export default {
  data() {
    return {
      email: null,
      password: null,
    }
  },
  layout(){
      return 'beforeLogin';
  },
  methods: {
    login() {
      if (!this.email || !this.password) {
        alert('メールアドレスまたはパスワードが入力されていません。')
        return
      }
      firebase
        .auth()
        .signInWithEmailAndPassword(this.email, this.password)
        .then(() => {
          alert('ログインが完了しました')
          this.$router.push('/')
        })
        .catch((error) => {
          switch (error.code) {
            case 'auth/invalid-email':
              alert('メールアドレスの形式が違います。')
              break
            case 'auth/user-disabled':
              alert('ユーザーが無効になっています。')
              break
            case 'auth/user-not-found':
              alert('ユーザーが存在しません。')
              break
            case 'auth/wrong-password':
              alert('パスワードが間違っております。')
              break
            default:
              alert('エラーが起きました。しばらくしてから再度お試しください。')
              break
          }
        })
    },
  },
}
</script>

<style>
    .login{
        background-color: #223344;
        height:100vh;
    }
    .login_container{
        margin: 0 auto;
        background-color: #fff;
        width: 400px;
        border-radius: 3px;
        padding: 15px 30px;
        text-align: center;
    }
    .login_container p{
        font-weight: bold;
        margin-bottom: 10px;
    }
    .login_container input{
        margin-bottom: 10px;
        border-radius: 3px;
        width: 90%;
        padding:5px;
        border: 1px solid #7d7d7d;;
    }
    .login_container button{
        background-color: #583f99;
        color: #fff;
        border-radius: 30px;
        padding: 5px 20px;
    }
</style>
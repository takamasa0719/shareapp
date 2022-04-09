<template>
  <div class="register">
    <div class="register_container">
        <p>新規登録</p>
        <input v-model="userName" type="text" placeholder="ユーザーネーム" maxLength="20" required/>
        <br />
        <input v-model="email" type="email" placeholder="メールアドレス" required/>
        <br />
        <input v-model="password" type="password" placeholder="パスワード" required/>
        <br />
        <button @click="register">新規登録</button>
        <br />
    </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase';
export default {
  data() {
    return {
      userName: null,
      email: null,
      password: null,
    }
  },
  layout(){
      return 'beforeLogin';
  },
  methods: {
    async register() {
      if (!this.userName || !this.email || !this.password) {
        alert('ユーザーネームまたはメールアドレスまたはパスワードが入力されていません。')
        return
      }
      firebase.auth()
      .onAuthStateChanged((user)=>{
        if (user){
          let id = user.uid;
          const sendData = {
        id: id,
        name: this.userName,
      };
      this.$axios.post("http://127.0.0.1:8000/api/user/", sendData);
        }
      });
      firebase
        .auth()
        .createUserWithEmailAndPassword(this.email, this.password)
        .then((data) => {
          data.user.sendEmailVerification().then(() => {
            this.$router.replace('/')
          })
        })
        .catch((error) => {
          switch (error.code) {
            case 'auth/invalid-email':
              alert('メールアドレスの形式が違います。')
              break
            case 'auth/email-already-in-use':
              alert('このメールアドレスはすでに使われています。')
              break
            case 'auth/weak-password':
              alert('パスワードは6文字以上で入力してください。')
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
    .register{
        background-color: #223344;
        height:100vh;
    }
    .register_container{
        margin: 0 auto;
        background-color: #fff;
        width: 400px;
        border-radius: 3px;
        text-align: center;
        padding: 15px 30px;
    }
    .register_container p{
        font-weight: bold;
        margin-bottom: 10px;
    }
    .register_container input{
        margin-bottom: 10px;
        border-radius: 3px;
        width: 90%;
        padding:5px;
        border: 1px solid #7d7d7d;;
    }
    .register_container button{
        background-color: #583f99;
        color: #fff;
        border-radius: 30px;
        padding: 5px 20px;
    }
</style>
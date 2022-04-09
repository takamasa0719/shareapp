<template>
  <div class="container">
    <div class="sidebar">
      <img src="/image/logo.png"><br />
      <div class="home">
        <img src="/image/home.png">
        <NuxtLink to="/">ホーム</NuxtLink><br />
      </div>
      <div class="logout">
        <img src="/image/logout.png">
        <button @click="logout">ログアウト</button>
      </div>
      <br />
      <p>シェア</p>
      <textarea rows="10" cols="30" v-model="content" maxlength="120" required></textarea><br />
      <button class="share_btn" :disabled="activateButton" @click="contentPost">シェアする</button>
    </div>
    <Nuxt />
  </div>
</template>


<script>
import firebase from '~/plugins/firebase'
export default {
  data(){
    return{
    content: '',
    uid: null,
    }
  },
  methods: {
    logout() {
      firebase
        .auth()
        .signOut()
        .then(() => {
          alert('ログアウトが完了しました')
          this.$router.replace('/login')
        })
    },
    async contentPost(){
      const sendData = {
        user_id: this.uid,
        content: this.content,
      };
      await this.$axios.post("http://127.0.0.1:8000/api/post/", sendData);
      location.reload();
    },
  },
  computed: {
    activateButton: function (){
      if(this.content != ''){
        return false;
      }else{
        return true;
      }
    },
  },
  created(){
    firebase.auth()
      .onAuthStateChanged((user)=>{
        if (user){
          this.uid = user.uid;
        }
      });
  }
}
</script>

<style scoped>
    .container{
        background-color: #223344;
        height:100vh;
        width:100vw;
        position: fixed;
        display: flex;
    }
    .sidebar{
      width:30%;
      padding: 10px;
    }
    .home a{
      text-decoration: none;
      color: #fff;
      font-size:20px;
    }
    .home{
      display:flex;
      align-items: center;
    }
    .logout{
      display:flex;
      align-items: center;
    }
    .logout button{
      background-color: #223344;
      border: none;
      color: #fff;
      font-size:20px;
      cursor: pointer;
    }
    img{
      height:30px;
      margin-bottom: 10px;
      margin-right: 10px;
    }
    p{
      color: #fff;
      font-size:20px;
      margin-bottom:5px;
    }
    textarea{
        background-color: #223344;
        border: 1px solid #fff;
        border-radius:5px;
        resize:none;
        color: #fff;
    }
    .share_btn{
        background-color: #583f99;
        color: #fff;
        border-radius: 30px;
        padding: 5px 20px;
        margin-top: 10px;
        margin-left: 130px;
        cursor: pointer;
    }
</style>
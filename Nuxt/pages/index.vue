<template>
  <div class="top">
      <h1>ホーム</h1>
      <div class="posts" v-for="item in postLists" :key="item.id">
        <div class="posts_btn">
          <p>{{ item.name }}</p>
          <likeButton :data="item" />
          <input type="image" src="/image/cross.png" class="delete_btn" @click="deletePost(item.id)">
          <input type="image" src="/image/detail.png" class="comment_btn" @click="movetoComment(item.id, item.name, item.content)">
        </div>
        <p>{{item.content}}</p>
      </div>
  </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
  layout: 'toppage',
  data(){
    return{
      postLists: [],
    }
  },
  methods: {
    async getPost() {
      const resData = await this.$axios.get(
        "http://127.0.0.1:8000/api/post/"
      );
      this.postLists = resData.data.data;
    },
    async deletePost(id) {
      await this.$axios.delete("http://127.0.0.1:8000/api/post/" + id);
      this.getPost();
      location.reload();
    },
    movetoComment(id, name, content){
      this.$router.push({path: 'comment', query: {id: id, name: name, content: content}});
    }
  },
  created() {
    firebase.auth().onAuthStateChanged((user) => {
      if (!user) {
        this.$router.replace('/login')
      }else{
      }
    })
    this.getPost();
  },
}
</script>

<style scoped>
  .top{
    background-color:#223344;
    height:100vh;
    width: 70%;
  }
  h1{
    color: #fff;
    border-left: 1px solid #fff;
    padding: 10px;
    display: inline-block;
  }
  .posts{
    border:1px solid #fff;
    color: #fff;
    padding: 10px;
  }
  .posts_btn{
    display: flex;
    align-items: center;
  }
  .delete_btn{
    width:20px;
    display: inline-block;
    margin-left: 10px;
  }
  .comment_btn{
    width: 20px;
    margin-left: 40px;
  }
</style>
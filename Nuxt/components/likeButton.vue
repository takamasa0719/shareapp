<template>
    <div class="container">
        <input v-if="!usersLike" type="image" src="/image/heart.png" class="like_btn" @click="like()">
        <input v-else type="image" src="/image/heart.png" class="like_btn" @click="unlike(usersLike.id)">
        <p>{{ this.likeCount }}</p>
    </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
    data() {
        return{
            likeData: [],
            uid: null,
            usersLike: null,
            likeCount: 0,
        }
    },
    props: ["data"], 
    methods:{
        async like(){
            const sendData = {
                    like: 1,
                    user_id: this.uid,
                    post_id: this.data.id,
                };
            await this.$axios.post(
            "http://127.0.0.1:8000/api/like/", sendData);
            this.getLike();
            location.reload();
        },
        async unlike(id){
            await this.$axios.delete("http://127.0.0.1:8000/api/like/" + id);
            this.getLike();
            location.reload();
        },
        async getLike(){
            const resData = await this.$axios.get(
            "http://127.0.0.1:8000/api/like/" + this.data.id
            );
            this.likeData = resData.data.data
            this.usersLike = this.likeData
            .find(function(value){
            return value.user_id == this.uid
            }.bind(this));
            this.likeCountSet();
        },
        likeCountSet(){
            this.likeCount = Object.keys(this.likeData).length;
        },
    },
    created(){
        this.getLike()
        firebase.auth()
        .onAuthStateChanged((user)=>{
        if (user){
            this.uid = user.uid;
            }
        });
    },
};
</script>

<style scoped>
.like_btn{
    width:20px;
    display: inline-block;
    margin-left: 10px;
    margin-right: 5px;
  }
.container{
    display: flex;
}
</style>
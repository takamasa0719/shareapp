<template>
    <div class="top">
        <h1>コメント</h1>
        <div class="post_container">
            <div class="post_btn">
                <p>{{ this.$route.query.name }}</p>
                <input type="image" src="/image/heart.png" class="like_btn">
                <p>0</p>
                <input type="image" src="/image/cross.png" class="delete_btn" @click="deletePost(postId)">
            </div>
                <p>{{ this.$route.query.content }}</p>
        </div>
        <div class="comment_ttl">
            <p>コメント</p>
        </div>
        <div class="comment_container" v-for="item in commentLists" :key="item.id" >
            <p class="comment_name">{{ item.user.name }}</p>
            <p class="comment">{{ item.comment }}</p>
        </div>
        <div class="comment_area">
            <textarea rows="1" cols="120" v-model="comment"></textarea><br />
            <button class="comment_btn" :disabled="activateButton" @click="commentPost">コメント</button>
        </div>
    </div>
</template>

<script>
import firebase from '~/plugins/firebase'
export default {
    layout: 'toppage',
    data(){
        return {
            postId: '',
            uid: null,
            comment: '',
            commentLists: [],
        }
    },
    methods:{
        async deletePost(id) {
            await this.$axios.delete("http://127.0.0.1:8000/api/post/" + id);
            this.$router.replace('/')
        },
        async getComment() {
            const resData = await this.$axios.get(
            "http://127.0.0.1:8000/api/comment/" + this.postId
            );
            this.commentLists = resData.data.data
        },
        async commentPost(){
        const sendData = {
            user_id: this.uid,
            post_id: this.postId,
            comment: this.comment,
            };
            await this.$axios.post("http://127.0.0.1:8000/api/comment/", sendData);
            location.reload();
        },
        setPostId(){
            this.postId = this.$route.query.id;
        },
    },
    computed: {
    activateButton: function (){
        if(this.comment != ''){
            return false;
        }else{
            return true;
            }
        },
    },
    created(){
        this.setPostId()
        this.getComment()
        firebase.auth()
        .onAuthStateChanged((user)=>{
        if (user){
            this.uid = user.uid;
            }
        });
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
    .comment_ttl{
        color: #fff;
        text-align: center;
        border: 1px solid #fff;
        padding: 5px;
    }
    .comment_ttl p{
        font-size: 14px;
        font-weight: thin;
    }
    .post_btn{
        display:flex;
        align-items: center;
        margin-bottom: 5px;
    }
    .like_btn{
        width:20px;
        display: inline-block;
        margin-left: 10px;
        margin-right: 5px;
    }
    .delete_btn{
        width:20px;
        display: inline-block;
        margin-left: 10px;
    }
    .post_container{
        border: 1px solid #fff;
        padding: 10px;
        color: #fff;
    }
    .comment_container{
        border: 1px solid #fff;
        padding: 5px;
    }
    .comment_name{
        color: #fff;
        font-size: 14px;
    }
    .comment{
        color: #fff;
        font-size:12px;
    }
    .comment_btn{
        background-color: #583f99;
        color: #fff;
        border-radius: 30px;
        padding: 5px 20px;
        margin-top: 10px;
        float: right;
        cursor: pointer;
    }
    .comment_area{
        text-align: center;
    }
    textarea{
        background-color: #223344;
        border: 1px solid #fff;
        border-radius: 5px;
        margin-top: 10px;
        width: 95%;
        resize: none;
        color: #fff;
    }
</style>
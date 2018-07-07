<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Who is not follow you back is : <em
                        class="badge badge-primary">{{list_count}}</em> people
                </div>
                <div class="card-body">
                    <h3 v-if="list_count == 0 ">
                        This list will be ready soon <i class="fa fa-circle-o-notch fa-spin fa-2x"></i>
                    </h3>


                    <!--<div class="col-md-4 padding" v-for="user in users_list">-->
                    <!--<div class="card">-->
                    <!--<img class="card-img-top" v-bind:src="user['profile_image_url_https']">-->
                    <!--<div class="card-body">-->
                    <!--<h5 class="card-title">{{user['name']}}</h5>-->
                    <!--<p class="card-text">{{user['screen_name']}}</p>-->
                    <!--</div>-->
                    <!--<ul class="list-group list-group-flush">-->
                    <!--<li class="list-group-item">Bio: {{user['description']}}</li>-->
                    <!--<li class="list-group-item">Location : {{user['location']}}</li>-->
                    <!--<li class="list-group-item">Followers : {{user['followers_count']}}</li>-->
                    <!--<li class="list-group-item">Following : {{user['friends_count']}}</li>-->
                    <!--</ul>-->
                    <!--<div class="card-body">-->
                    <!--<a href="#" class="card-link">UnFollow</a>-->
                    <!--</div>-->
                    <!--</div>-->
                    <!--</div>-->
                    <div class="row">
                        <div v-for="user in users_list" class="card mb-3 mr-1"
                             style="width: 18rem;height: 20rem" v-bind:id="user['screen_name']" >
                            <div class="card-header"> @{{user['screen_name']}}
                                <button @click="unfollow(user['screen_name'],user['id'])" class="btn btn-sm btn-danger float-right">Unfollow</button>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <img class="img-thumbnail img-circle" v-bind:src="user['profile_image_url_https']">
                                    {{user['name']}}
                                </h5>
                                <p class="card-text">
                                    Bio: {{user['description']}} <br>
                                    <span v-if="user['location']">Location : {{user['location']}} <br> </span>
                                    Followers : {{user['followers_count']}} <br>
                                    Following : {{user['friends_count']}} <br>
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                list_count: 0,
                users_list: []
            }
        },
        methods: {
            getUserData(nex_cur = null) {
                axios.get('api/not-follow-list', {params: {'next_cursor': nex_cur}}).then(response => {
                    this.list_count = response.data['list_count'];
                    this.users_list = response.data['list_data'];
                    console.log(response.data);
                });
            },
            unfollow(screen_name,id){
                console.log(screen_name,id);
                axios.post('api/un-follow',{screen_name:screen_name,id:id}).then(response =>{
                    if (response){
                        $('#'+screen_name).hide();
                    }
                });
            }
        },
        created() {
            this.getUserData()
        },
    }

</script>

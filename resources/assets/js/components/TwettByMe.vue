<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"> Tweet as anonymous
                </div>
                <div class="card-body">
                    <span class="text-justify">
                            This tweet will tweet with my account @_Blue_Helper_ please be nice :
                    </span>
                    <br>
                    <textarea maxlength="255" name="message" v-model="tweet_string" class="form-control"></textarea>
                    <br>
                    <button :disabled="tweet_string.length <= 0" @click="tweet" type="submit"
                            class="btn btn-primary float-right">
                        Tweet
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Notifications from 'vue-notification'

    Vue.use(Notifications);
    export default {
        data() {
            return {
                tweet_string: "",
            }
        },
        methods: {
            tweet() {
                axios.post('api/tweet-by-me', {tweet_string: this.tweet_string}).then(response => {
                    console.log(response);
                    this.$notify({
                        group: 'notify',
                        title: '',
                        text: "Done",
                        type: 'success',
                    });
                    this.tweet_string = '';
                });
            }
        },
    }
</script>
